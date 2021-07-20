<?php


namespace App\Controller;

use App\Repository\MyOAuthAccessTokenRepository;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PostController
 * @package App\Controller
 *
 */
class PostController
{
    private $postRepository;
    private $myOAuthAccessTokenRepository;

    public function __construct(PostRepository $postRepository, MyOAuthAccessTokenRepository $myOAuthAccessTokenRepository)
    {
        $this->postRepository = $postRepository;
        $this->myOAuthAccessTokenRepository = $myOAuthAccessTokenRepository;
    }

    /**
     * @Route("/post/add", name="add_hashtag", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(),true);

        $content = $data['content'];
        $author = $data['author'];
        $token = $data['token'];

        if(empty($content) ||
            empty($author) ||
            empty($token)
        ){
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        // sprawdzanie czy token istnieje
        // sprawdzanie czy token ma tego samego usera co autor
        // sprawdzanie czy token jest aktywny
        // sprawdzanie czy token ma dobrego scope

        if($this->myOAuthAccessTokenRepository->checkTokenTerm() &&
            $this->myOAuthAccessTokenRepository->isExistToken()
        ){
            $this->postRepository->savePost($content, $author);
            return new JsonResponse(['status' => 'Post created.'], Response::HTTP_CREATED);
        }
    }

    /**
     * @Route("/posts/{id}", name="get_one_post", methods={"GET"})
     * @param $id
     * @return JsonResponse
     */
    public function get($id): JsonResponse
    {
        $post = $this->postRepository->findOneBy(['id' => $id]);
        $data = [
            'id' => $post->getId(),
            'content' => $post->getContent(),
            'author' => $post->getAuthor(),
        ];
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/posts", name="get_all_posts", methods={"GET"})
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        $posts = $this->postRepository->findAll();
        $data = [];

        foreach ($posts as $post){
            $data[] = [
                'id' => $post->getId(),
                'content' => $post->getContent(),
                'author' => $post->getAuthor(),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/posts/{id}", name="update_post", methods={"PUT"})
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update($id, Request $request): JsonResponse
    {
        $post = $this->postRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        empty($data['content']) ? true : $post->setContent($data['content']);

        $updatedPost = $this->postRepository->updatePost($post);

        return new JsonResponse($updatedPost->toArray(), Response::HTTP_OK);
    }

    /**
     * @Route("/posts/{id}", name="delete_post", methods={"DELETE"})
     * @param $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        $post = $this->postRepository->findOneBy(['id' => $id]);
        $this->postRepository->removePost($post);

        return new JsonResponse(['status' => 'Hashtag say goodbye.', Response::HTTP_NO_CONTENT]);
    }
}