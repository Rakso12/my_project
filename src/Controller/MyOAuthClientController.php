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
     * - client_id (ssl public key)
     * - client_secret (ssl private key)
     * - name (name of application - string)
     * @Route("/oauth/makeclient", name="make_client_endpoint", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function makeClient(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $client_id = $data['client_id'];
        $client_secret = $data['client_secret'];
        $name = $data['name'];

        $errors = [];

        if(empty($client_id) ||
            empty($name) ||
            empty($client_secret)
        ){
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        if(strlen($client_id)!=10){
            $errors[] = "Identifier is not valid.";
        }

        if(strlen($client_secret)!=20){
            $errors[] = "Secret is not valid.";
        }

        if(strlen($name) < 5){
            $errors[] = "Name must be longer";
        }

        if(!$errors) {
            if (!$this->myOAuthClientRepository->clientExist($client_id)) {
                $this->myOAuthClientRepository->saveClient($client_id, $name, $client_secret);
                return new JsonResponse(['Status' => 'Client added'], Response::HTTP_CREATED);
            } else {
                return new JsonResponse(['Status' => 'Client exist']);
            }
        }

        return new JsonResponse($errors);
    }

    /**
     * This is function to update client Scope or Grant. Mandatory data:
     * - client_id (client_id)
     * - grant (string with space separator between grants)
     * - scope (string with space separator between scopes)
     * @Route("/oauth/updateclient", name="update_client_endpoint", methods={"POST"})
     */
    public function updateClient(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $client_id = $data['client_id'];
        $grant = $data['grant'];
        $scope = $data['scope'];

        $errors = [];

        if(empty($client_id) ||
            empty($grant) ||
            empty($scope)
        ){
            $errors[] = "You forgot about some items, please add all parameters";
        }

        if(!$errors){
            if($this->myOAuthClientRepository->clientExist($client_id)){
                $this->myOAuthClientRepository->updateParameters($client_id, $grant, $scope);
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
     * - client_id (public key)
     * - client_secret (private key)
     * @Route("/oauth/deactive", name="deactive_client", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function deActive(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $client_id = $data['client_id'];
        $client_secret = $data['client_secret'];

        $errors = [];

        if(empty($client_id)
            || empty($client_secret)
        ){
            $errors[] = "You forgot about some items, please add all parameters";
        }

        if(!$errors){
            if($this->myOAuthClientRepository->clientExist($client_id) &&
                $this->myOAuthClientRepository->checkSecret($client_id, $client_secret)
            ){
                $this->myOAuthClientRepository->deActive($client_id, $client_secret);
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
     * - client_id (public key)
     * - client_secret (private key)
     * @Route("/oauth/makeactive", name="make_active", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function makeActive(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $client_id = $data['client_id'];
        $client_secret = $data['client_secret'];

        $errors = [];

        if(empty($client_id)
            || empty($client_secret)
        ){
            $errors[] = "You forgot about some items, please add all parameters";
        }

        if(!$errors){
            if($this->myOAuthClientRepository->clientExist($client_id) &&
                $this->myOAuthClientRepository->checkSecret($client_id, $client_secret)
            ){
                $this->myOAuthClientRepository->upActive($client_id, $client_secret);
                return new JsonResponse(['Status' => 'Client active.']);
            }
            else {
                return new JsonResponse(['Status' => 'Client not exist']);
            }
        }
        return new JsonResponse($errors);
    }
}