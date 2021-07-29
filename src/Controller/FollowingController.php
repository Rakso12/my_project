<?php


namespace App\Controller;


use App\Repository\FollowingRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FollowingController
{
    private $followingRepository;

    public function __construct(FollowingRepository $followingRepository)
    {
        $this->followingRepository = $followingRepository;
    }

    /**
     * @Route("/following/adduser", name="add_new_following_user", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function addFollowingUser(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $username = $data['username'];
        $following_user = $data['following_user'];

        $errors = [];

        if(empty($username) ||
            empty($following_user)
        ){
            $errors[] = "Expecting mandatory parameters!";
        }

        if(!$errors){
            $tmpFollowing = $this->followingRepository->findOneBy(['user_email' => $username]);
            $tmpUsers = $tmpFollowing->getUsers();
            $tmp = $tmpUsers." ".$following_user;
            $tmpFollowing->setUsers($tmp);

            // TODO: poprawić pobieranie usera i zmianę aktualnie obserwowanych (coś nie chodzi prawdopodobnie pobieranie)

            return new JsonResponse(["Status" => "User add to following"]);
        }
        return new JsonResponse($errors);
    }

    /**
     * @Route("/following/addhashtag", name="add_new_following_hashtag", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function addFollowingHashtag(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $username = $data['username'];
        $following_hashtag = $data['following_hashtag'];

        $errors = [];

        if(empty($username) ||
            empty($following_hashtag)
        ){
            $errors[] = "Expecting mandatory parameters!";
        }

        if(!$errors){
            $tmpFollowing = $this->followingRepository->findOneBy(['user_email' => $username]);
            $tmpUsers = $tmpFollowing->getUsers();
            $tmp = $tmpUsers." ".$following_hashtag;
            $tmpFollowing->setUsers($tmp);

            // TODO: poprawić pobieranie hashtagu i zmianę aktualnie obserwowanych (coś nie chodzi prawdopodobnie pobieranie)

            return new JsonResponse(["Status" => "Hashtag add to following"]);
        }
        return new JsonResponse($errors);
    }
}