<?php


namespace App\Controller;


use App\Repository\FollowingRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FollowingController
{
    private $followingRepository;
    private $userRepository;

    public function __construct(FollowingRepository $followingRepository, UserRepository $userRepository)
    {
        $this->followingRepository = $followingRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/following/adduser", name="add_new_following_user", methods={"POST"})
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

        if($username == $following_user){
            $errors[] = "It's you!";
        }

        if(!$this->userRepository->findOneBy(["email" => $following_user])){
            $errors[] = "User don't exist.";
        }

        $currentFollowing = $this->followingRepository->findOneBy(['user_email' => $username]);
        $currentUsers = $currentFollowing->getUsers();
        $usersArray = preg_split("/[\s,]+/", $currentUsers);

        $flag = false;

        foreach ($usersArray as $user){
            if($user == $following_user){
                $flag = true;
            }
        }

        if($flag == true){
            $errors[] = "User was followed.";
        }

        if(!$errors){
            $tmpFollowing = $following_user." ".$currentUsers;
            $this->followingRepository->addUser($currentFollowing, $tmpFollowing);

            return new JsonResponse(["Status" => "User add to following."]);
        }
        return new JsonResponse($errors);
    }

    /**
     * @Route("/following/addhashtag", name="add_new_following_hashtag", methods={"POST"})
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

        $currentFollowing = $this->followingRepository->findOneBy(["user_email" => $username]);
        $currentHashtags = $currentFollowing->getHashtags();
        $hashtagsArray = preg_split("/[\s,]+/", $currentHashtags);

        $flag = false;

        foreach ($hashtagsArray as $hashtag) {
            if ($hashtag == $following_hashtag){
                $flag = true;
            }
        }

        if($flag == true){
            $errors[] = "Hashtag was followed.";
        }

        if(!$errors){
            $tmpFollowing = $following_hashtag." ".$currentHashtags;
            $this->followingRepository->addHashtag($currentFollowing, $tmpFollowing);

            return new JsonResponse(["Status" => "Hashtag add to following"]);
        }
        return new JsonResponse($errors);
    }

    /**
     * @Route("/following/unfollowuser", name="unfollow_user", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function unFollowUser(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $username = $data['username'];
        $unfollow_user = $data['unfollow_user'];

        $errors = [];

        if(empty($username) ||
            empty($unfollow_user)
        ){
            $errors[] = "Expecting mandatory parameters!";
        }

        $followingByUser = $this->followingRepository->findOneBy(['user_email' => $username]);
        $currentUsers = $followingByUser->getUsers();
        $usersArray = preg_split("/[\s,]+/", $currentUsers);
        $flag = false;

        foreach ($usersArray as $user){
            if($user == $unfollow_user){
                $flag = true;
            }
        }

        if($flag == false){
            $errors[] = "User is not followed yet.";
        }

        if(!$errors){
            $newFollowingUser = str_replace($unfollow_user." ", "", $currentUsers);
            $this->followingRepository->deleteUser($followingByUser, $newFollowingUser);
            return new JsonResponse(["Status" => "User unfollowed"]);
        }
        return new JsonResponse($errors);
    }

    /**
     * @Route("/following/unfollowhashtag", name="unfollow_hash", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function unFollowHashtag(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $errors = [];

        if(empty($data['username']) ||
            empty($data['unfollow_hashtag'])
        ){
            $errors[] = "Expecting mandatory parameters!";
        }

        $username = $data['username'];
        $unfollow_hash = $data['unfollow_hashtag'];

        $followingByUser = $this->followingRepository->findOneBy(['user_email' => $username]);
        $currentHashtags = $followingByUser->getHashtags();
        $hashtagsArray = preg_split("/[\s,]+/", $currentHashtags);
        $flag = false;

        foreach ($hashtagsArray as $hashtag){
            if($hashtag == $unfollow_hash){
                $flag = true;
            }
        }

        if($flag == false){
            $errors[] = "Hashtag is not followed yet.";
        }

        if(!$errors){
            $newFollowingHashtag = str_replace($unfollow_hash." ", "", $currentHashtags);
            $this->followingRepository->deleteHashtag($followingByUser, $newFollowingHashtag);

            return new JsonResponse(["Status" => "Hashtag unfollowed."]);
        }
        return new JsonResponse($errors);
    }
}