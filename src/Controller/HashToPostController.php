<?php


namespace App\Controller;


use App\Repository\HashToPostRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class HashToPostController
{
    private $hashToPostRepository;

    public function __construct(HashToPostRepository $hashToPostRepository)
    {
        $this->hashToPostRepository = $hashToPostRepository;
    }

    /**
     * @Route("/hashtopost/add", name="hash_to_post_add", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $id_post = $data['id_post'];
        $id_hash = $data['id_hash'];

        if(empty($id_hash) || empty($id_post)){
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        $this->hashToPostRepository->saveHashToPost($id_post, $id_hash);
        return new JsonResponse(['status'=>'Hash to post added'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/hashtopost/{id}", name="get_one_hashtopost", methods={"GET"})
     * @param $id
     * @return JsonResponse
     */
    public function get($id): JsonResponse
    {
        $hashToPost = $this->hashToPostRepository->findOneBy(['id' => $id]);
        $data = [
            'id' => $hashToPost->getId(),
            'id_post' => $hashToPost->getIdPost(),
            'id_hash' => $hashToPost->getIdHash()
        ];
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/hashtopost", name="get_all_hashtopost", methods={"GET"})
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        $hashToPost = $this->hashToPostRepository->findAll();
        $data = [];

        foreach ($hashToPost as $hashToPostItem){
            $data[] = [
                'id' => $hashToPostItem->getId(),
                'id_post' => $hashToPostItem->getIdPost(),
                'id_hash' => $hashToPostItem->getIdHash()
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/hashtopost/{id}", name="update_hashtopost", methods={"PUT"})
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update($id, Request $request): JsonResponse
    {
        $hashToPost = $this->hashToPostRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        empty($data['id_post']) ? true : $hashToPost->setIdPost($data['id_post']);
        empty($data['id_hash']) ? true : $hashToPost->setIdHash($data['id_hash']);

        $updateHashToPost = $this->hashToPostRepository->updateHashToPost($hashToPost);

        return new JsonResponse($updateHashToPost->toArray(), Response::HTTP_OK);
    }

    /**
     * @Route("/hashtopost/{id}", name="delete_hashtopost", methods={"DELETE"})
     * @param $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        $hashToPost = $this->hashToPostRepository->findOneBy(['id' => $id]);
        $this->hashToPostRepository->removeHashToPost($hashToPost);

        return new JsonResponse(['status' => 'Hash die in this post.'], Response::HTTP_NO_CONTENT);
    }
}