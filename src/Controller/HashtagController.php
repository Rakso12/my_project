<?php


namespace App\Controller;


use App\Repository\HashtagRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HashtagController
 * @package App\Controller
 *
 */
class HashtagController
{
    private $hashtagRepository;

    public function __construct(HashtagRepository $hashtagRepository)
    {
        $this->hashtagRepository = $hashtagRepository;
    }

    /**
     * @Route("/hashtag/add", name="add_hashtag", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(),true);

        $name = $data['name'];

        if(empty($name)){
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        $this->hashtagRepository->saveHashtag($name);
        return new JsonResponse(['status' => 'Hashtag created.'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/hashtags/{id}", name="get_one_hashtag", methods={"GET"})
     * @param $id
     * @return JsonResponse
     */
    public function get($id): JsonResponse
    {
        $hashtag = $this->hashtagRepository->findOneBy(['id' => $id]);
        $data = [
            'id' => $hashtag->getId(),
            'name' => $hashtag->getName(),
        ];
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/hashtags", name="get_all_hashtags", methods={"GET"})
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        $hashtags = $this->hashtagRepository->findAll();
        $data = [];

        foreach ($hashtags as $hashtag){
            $data[] = [
                'id' => $hashtag->getId(),
                'name' => $hashtag->getName(),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/hashtags/{id}", name="delete_hashtag", methods={"DELETE"})
     * @param $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        $hashtag = $this->hashtagRepository->findOneBy(['id' => $id]);
        $this->hashtagRepository->removeHashtag($hashtag);

        return new JsonResponse(['status' => 'Hashtag say goodbye.', Response::HTTP_NO_CONTENT]);
    }
}