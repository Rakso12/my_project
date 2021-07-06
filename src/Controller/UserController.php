<?php


namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @package App\Controller
 *
 */
class UserController
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/user/add", name="add_user", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(),true);

        $email = $data['email'];
        $password = $data['password'];
        $firstName = $data['first_name'];
        $lastName = $data['last_name'];
        $birth_day = $data['birth_date'];

        if(empty($email) || empty($password) ||empty($firstName) || empty($lastName) || empty($birth_day)) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        $this->userRepository->saveUser($email,$password,$firstName,$lastName,$birth_day);
        return new JsonResponse(['status' => 'User created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/users/{id}", name="get_one_user", methods={"GET"})
     * @param $id
     * @return JsonResponse
     */
    public function get($id): JsonResponse
    {
        $user = $this->userRepository->findOneBy(['id' => $id]);
        $data = [
            'id' => $user->getId(),
            'firstName' => $user->getFirstName(),
            ];
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/users", name="get_all_users", methods={"GET"})
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        $users = $this->userRepository->findAll();
        $data = [];

        foreach ($users as $user) {
            $data[] = [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
                'first_name' => $user->getFirstName(),
                'last_name' => $user->getLastName(),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/users/{id}", name="update_customer",methods={"PUT"})
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update($id, Request $request): JsonResponse
    {
        $user = $this->userRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(),true);

        empty($data['email']) ? true : $user->setEmail($data['email']);
        empty($data['password']) ? true : $user->setPassword($data['password']);
        empty($data['first_name']) ? true : $user->setFirstName($data['first_name']);
        empty($data['last_name']) ? true : $user->setLastName($data['last_name']);
        empty($data['birth_day']) ? true : $user->setBirthDate($data['birth_day']);

        $updatedUser = $this->userRepository->updateUser($user);

        return new JsonResponse($updatedUser->toArray(), Response::HTTP_OK);
    }

    /**
     * @Route("/users/{id}",name="delete_user",methods={"DELETE"})
     * @param $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        $user = $this->userRepository->findOneBy(['id' => $id]);
        $this->userRepository->removeUser($user);

        return new JsonResponse(['status'=>'User say bye.', Response::HTTP_NO_CONTENT]);
    }
}