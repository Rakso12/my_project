<?php


namespace App\Controller;

use App\Repository\MyOAuthClientRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class MyOAuthClientController
{
    private $myOAuthClientRepository;

    public function __construct(MyOAuthClientRepository $myOAuthClientRepository)
    {
        $this->myOAuthClientRepository = $myOAuthClientRepository;
    }

    /**
     * This is function for creating new client on OAuth2 Server. Mandatory data:
     * - identifier (ssl public key)
     * - secret (ssl private key)
     * - name (name of application - string)
     * @Route("/oauth/makeclient", name="make_client_endpoint", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function makeClient(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $identifier = $data['identifier'];
        $name = $data['name'];
        $secret = $data['secret'];

        $errors = [];

        if(empty($identifier) ||
            empty($name) ||
            empty($secret)
        ){
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        if(strlen($identifier)!=10){
            $errors[] = "Identifier is not valid.";
        }

        if(strlen($secret)!=20){
            $errors[] = "Secret is not valid.";
        }

        if(strlen($name) < 5){
            $errors[] = "Name must be longer";
        }

        if(!$errors) {
            if (!$this->myOAuthClientRepository->clientExist($identifier)) {
                $this->myOAuthClientRepository->saveClient($identifier, $name, $secret);
                return new JsonResponse(['Status' => 'Client added'], Response::HTTP_CREATED);
            } else {
                return new JsonResponse(['Status' => 'Client exist']);
            }
        }

        return new JsonResponse($errors);
    }

    /**
     * This is function to update client Scope or Grant. Mandatory data:
     * - identifier (client_id)
     * - grant (string with space separator between grants)
     * - scope (string with space separator between scopes)
     * @Route("/oauth/updateclient", name="update_client_endpoint", methods={"POST"})
     */
    public function updateClient(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $identifier = $data['identifier'];
        $grant = $data['grant'];
        $scope = $data['scope'];

        $errors = [];

        if(empty($identifier) ||
            empty($grant) ||
            empty($scope)
        ){
            $errors[] = "You forgot about some items, please add all parameters";
        }

        if(!$errors){
            if($this->myOAuthClientRepository->clientExist($identifier)){
                $this->myOAuthClientRepository->updateParameters($identifier, $grant, $scope);
                return new JsonResponse(['Status' => 'Client update success.'], Response::HTTP_OK);
            }
            else {
                return new JsonResponse(['Status' => 'Client not exist.']);
            }
        }

        return new JsonResponse($errors);
    }

    /**
     * This is function for deactivating the client. Mandatory data:
     * - identifier (public key)
     * - secret (private key)
     * @Route("/oauth/deactive", name="deactive_client", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function deActive(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $identifier = $data['identifier'];
        $secret = $data['secret'];

        $errors = [];

        if(empty($identifier)
            || empty($secret)
        ){
            $errors[] = "You forgot about some items, please add all parameters";
        }

        if(!$errors){
            if($this->myOAuthClientRepository->clientExist($identifier) &&
                $this->myOAuthClientRepository->checkSecret($identifier, $secret)
            ){
                $this->myOAuthClientRepository->deActive($identifier, $secret);
                return new JsonResponse(['Status' => 'Client deactive.']);
            }
            else {
                return new JsonResponse(['Status' => 'Client not exist']);
            }
        }

        return new JsonResponse($errors);
    }

    /**
     * This is function for activating the client. Mandatory data:
     * - identifier (public key)
     * - secret (private key)
     * @Route("/oauth/makeactive", name="make_active", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function makeActive(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $identifier = $data['identifier'];
        $secret = $data['secret'];

        $errors = [];

        if(empty($identifier)
            || empty($secret)
        ){
            $errors[] = "You forgot about some items, please add all parameters";
        }

        if(!$errors){
            if($this->myOAuthClientRepository->clientExist($identifier) &&
                $this->myOAuthClientRepository->checkSecret($identifier, $secret)
            ){
                $this->myOAuthClientRepository->upActive($identifier, $secret);
                return new JsonResponse(['Status' => 'Client active.']);
            }
            else {
                return new JsonResponse(['Status' => 'Client not exist']);
            }
        }
        return new JsonResponse($errors);
    }
}