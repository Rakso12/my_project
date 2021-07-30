<?php


namespace App\Controller;

use App\Repository\FollowingRepository;
use App\Repository\MyOAuthAccessTokenRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
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
    private $userRepository;
    private $followingRepository;

    public function __construct(PostRepository $postRepository, MyOAuthAccessTokenRepository $myOAuthAccessTokenRepository, UserRepository $userRepository, FollowingRepository $followingRepository)
    {
        $this->postRepository = $postRepository;
        $this->myOAuthAccessTokenRepository = $myOAuthAccessTokenRepository;
        $this->userRepository = $userRepository;
        $this->followingRepository = $followingRepository;
    }

    /**
     * This is endpoint function to adding new post. Mandatory data:
     * - author (user email - string)
     * - token (access token - string)
     * - content (post content - string)
     * - hashtags (hashtag string with one space between hashtags)
     * @Route("/post/add", name="add_hashtag", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(),true);

        $content = $data['content'];
        $hashtags = $data['hashtags'];
        $username = $data['username'];
        $token = $data['token'];

        $scope = 'add';
        $errors = [];

        if(empty($content) ||
            empty($username) ||
            empty($token) ||
            empty($hashtags)
        ){
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        if(!$this->myOAuthAccessTokenRepository->checkTokenTerm($token)){
            $errors[] = "Token not valid.";
        }

        if(!$this->myOAuthAccessTokenRepository->checkTokenUser($username, $token)){
            $errors[] = "Author is not correct";
        }

        if(!$this->myOAuthAccessTokenRepository->checkScope($scope, $token)){
            $errors[] = "Scope not valid";
        }

        if(!$errors){
            $user = $this->userRepository->findOneBy(['email' => $username]);
            $authorId = $user->getId();
            $this->postRepository->savePost($content, $authorId, $hashtags);
            return new JsonResponse(['status' => 'Post created.'], Response::HTTP_CREATED);
        }

        return new JsonResponse($errors);
    }

    /**
     * This is endpoint function to show all user's post. Mandatory data:
     * - token (string)
     * - author  (email - string)
     * @Route("/post/showmypost", name="show_all_my_post",methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function showMyPost(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $token = $data['token'];
        $username = $data['username'];

        $scope = 'read';
        $errors = [];

        if(empty($token) ||
            empty($username)){
            $errors[] = "Expecting mandatory parameters!";
        }

        if(!$this->myOAuthAccessTokenRepository->checkScope($scope, $token)){
            $errors[] = "Scope not valid";
        }

        if(!$this->myOAuthAccessTokenRepository->checkTokenTerm($token)){
            $errors[] = "Token is out of date.";
        }

        if(!$this->myOAuthAccessTokenRepository->checkTokenUser($username, $token)){
            $errors[] = "Token is not your - Check user.";
        }

        if(!$errors){
                $user = $this->userRepository->findOneBy(['email' => $username]);
                $authorId = $user->getId();

                $posts = $this->postRepository->getPosts($authorId);

                return new JsonResponse(var_export($posts));
        }

        return new JsonResponse($errors);
    }

    /**
     * This is endpoint function to show all user's post. Mandatory data:
     * - token (string)
     * - wanted user  (email - string)
     * - username (email - string)
     * @Route("/post/showuserpost", name="show_all_post_by_user", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function showUserPost(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $token = $data['token'];
        $wanted_user = $data['wanted_user'];
        $username = $data['username'];

        $scope = 'readOther';
        $errors = [];

        if (empty($token) ||
            empty($wanted_user) ||
            empty($username)
        ){
         $errors[] = "Expecting mandatory parameters!";
        }

        if(!$this->myOAuthAccessTokenRepository->checkScope($scope, $token)){
            $errors[] = "Scope not valid";
        }

        if(!$this->myOAuthAccessTokenRepository->checkTokenTerm($token)){
            $errors[] = "Token is out of date";
        }

        if(!$this->myOAuthAccessTokenRepository->checkTokenUser($username, $token)){
            $errors[] = "Token is not your - Check user.";
        }

        if(!$errors){
            $user = $this->userRepository->findOneBy(['email' => $wanted_user]);
            $userId = $user->getId();

            $posts = $this->postRepository->getPosts($userId);

            return new JsonResponse(var_export($posts));
        }
        return new JsonResponse($errors);
    }

    /**
     * This is endpoint function to show all following post (by hashtags and users). Mandatory data:
     * - token (string)
     * - username (email - string)
     * @Route("/post/showmyfollow", name="show_all_following_post", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function showMyFollow(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $user = $data['username'];
        $token = $data['token'];

        $scope = 'read';
        $errors = [];

        if(empty($user) ||
            empty($token)
        ){
            $errors[] = "Expecting mandatory parameters!";
        }

        if(!$this->myOAuthAccessTokenRepository->checkScope($scope, $token)){
            $errors[] = "Scope not valid";
        }

        if(!$this->myOAuthAccessTokenRepository->checkTokenTerm($token)){
            $errors[] = "Token out of date.";
        }

        if(!$this->myOAuthAccessTokenRepository->checkTokenUser($user, $token)){
            $errors[] = "Token is not this user.";
        }

        if(!$errors){
            $tmp = $this->followingRepository->findOneBy(['user_email' => $user]);

            $followingUsers = $tmp->getUsers();
            $followingHashtags = $tmp->getHashtags();

            $posts = $this->postRepository->getByFollowingProperties($followingHashtags, $followingUsers);

            return new JsonResponse(var_export($posts));
        }

        return new JsonResponse($errors);
    }

    /**
     * This is endpoint function to show all post with hashtag. Mandatory data:
     * - username (email - string)
     * - token (string)
     * - hashtag (string)
     * @Route("/post/showbyhashtag", name="show_all_post_with_that_hashtag", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function showByHashtag(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $user = $data['username'];
        $token = $data['token'];
        $hashtag = $data['hashtag'];

        $scope = 'read';
        $errors = [];

        if(empty($user) ||
            empty($token) ||
            empty($hashtag)
        ){
            $errors[] = "Expecting mandatory parameters!";
        }

        if(!$this->myOAuthAccessTokenRepository->checkScope($scope, $token)){
            $errors[] = "Scope not valid";
        }

        if($this->myOAuthAccessTokenRepository->checkTokenTerm($token) &&
            $this->myOAuthAccessTokenRepository->checkTokenUser($user, $token)
        ){
            $posts = $this->postRepository->getPostByHash($hashtag);

            return new JsonResponse(var_export($posts));
        }
        return new JsonResponse($errors);
    }

    // ---------------------------------------------------------------------------------------
    // ---------------------------- DO PRZEROBIENIA NA OAUTH LUB USUNIĘCIA -------------------
    // ---------------------------------------------------------------------------------------

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