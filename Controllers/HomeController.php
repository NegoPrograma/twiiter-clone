<?php


class HomeController extends Controller {

    public function __construct(){
        parent::__construct();
        
        $userModel  =  new UserModel();
        
        if($userModel->hasLoginSession() == false){
            header("location: login");
        }
    }
    
    private $data = array();

    
    public function index(){
        $userModel = new UserModel($_SESSION['login_data']);

        $this->data['name'] = $userModel->getName();
        $this->data['followers'] = $userModel->countFollowers();
        $this->data['following'] = $userModel->countFollowing();
        $this->data['suggestions'] = $userModel->suggestUsers(rand(1,5));

        $this->loadTemplate("home",$this->data);
    }

    public function follow($id){
        
    }



    
    
};