<?php


class HomeController extends Controller
{

    public function __construct()
    {
        parent::__construct();

        $userModel  =  new UserModel();

        if ($userModel->hasLoginSession() == false) {
            header("location: login");
        }
    }

    private $data = array();


    public function index()
    {
        $userModel = new UserModel($_SESSION['login_data']);
        $tweetModel = new TweetModel();
        $user_id = $userModel->getUserId();
        if (isset($_POST['tweet']) && !empty($_POST['tweet'])) {
            $tweet = $_POST['tweet'];
            $tweetModel->postTweet($tweet, $user_id);
        }
        $feedUsers = $userModel->getListOfFollowed();
        $feedUsers[] = $user_id;
        $this->data['tweets'] = $tweetModel->getTweets($feedUsers, 10);
        $this->data['name'] = $userModel->getName();
        $this->data['followers'] = $userModel->countFollowers();
        $this->data['following'] = $userModel->countFollowing();
        $this->data['suggestions'] = $userModel->suggestUsers(rand(1, 5));

        $this->loadTemplate("home", $this->data);
    }

    public function follow($id)
    {
        $userModel = new UserModel($_SESSION['login_data']);
        $userModel->follow($userModel->getUserId(), $id);
        header("location: ../../");
    }

    public function unfollow($id)
    {
        $userModel = new UserModel($_SESSION['login_data']);
        $userModel->unfollow($userModel->getUserId(), $id);
        header("location:  ../../");
    }
};
