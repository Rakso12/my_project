<?php

namespace App\Controller;

use App\Entity\Following;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\EmailVerifier;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

/**
 * Class RegistrationController
 * @package App\Controller
 */
class RegistrationController extends AbstractController
{
    private $emailVerifier;

    /**
     * RegistrationController constructor.
     * @param EmailVerifier $emailVerifier
     */
    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    /**
     * Function to register user by registe form - not used.
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
//                  $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
//                      (new TemplatedEmail())
//                          ->from(new Address('admin@security-demo.com', 'Security Mailer Bot'))
//                          ->to($user->getEmail())
//                          ->subject('Please Confirm your Email')
//                          ->htmlTemplate('registration/confirmation_email.html.twig')
//                  );

            return $this->redirectToRoute('index');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * Function for send verify email.
     * NOTICE: Not used now.
     * @Route("/verify/email", name="app_verify_email")
     */
    public function verifyUserEmail(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_register');
    }

    /**
     * Endpoint for register new user.
     * @Route("/api/register", name="api_register", methods={"POST"})
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function registerUser(UserPasswordEncoderInterface  $passwordEncoder, Request $request): JsonResponse
    {
        $user = new User();
        $follow = new Following();

        $data = json_decode($request->getContent(), true);

        $email = $data["email"];
        $password = $data['password'];
        $passwordConfirmation = $data["password_confirmation"];
        $firstName = $data["first_name"];
        $lastName = $data["last_name"];

        $errors = [];

        if(empty($email) ||
            empty($password) ||
            empty($passwordConfirmation) ||
            empty($firstName) ||
            empty($lastName)
        ){
            $errors[] = $password."You forgot about some items, please add all parameters";
        }

        if($password != $passwordConfirmation){
            $errors[] = "Password does not math the password confirmation.";
        }

        if(strlen($password) < 8){
            $errors[] = "Password should be at least 8 characters.";
        }

        if(!$errors) {
            $encodedPassword = $passwordEncoder->encodePassword($user, $password);
            $user->setEmail($email);
            $user->setPassword($encodedPassword);
            $user->setFirstName($firstName);
            $user->setLastName($lastName);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $follow->setUserEmail($email);
            $follow->setHashtags('');
            $follow->setUsers('');

            $entityManager->persist($follow);
            $entityManager->flush();

            return $this->json([
                'user' => $user
            ]);
        }

        return $this->json([
            'errors' => $errors,
            'Remember about add items' => [
                'email',
                'password',
                'password_confirmation',
                'first_name',
                'last_name'
            ],
        ], 400);
    }
}
