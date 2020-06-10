<?php


class HomeController extends Controller {

    public function __construct(){
        parent::__construct();
        
        $userModel  =  new UserModel();
        
        if($userModel->hasLoginSession() == false){
        header("location: Login");
        }
    }
    
    private $data = array();

    
    public function index(){
        

        $this->loadTemplate("home",$this->data);
    }

    
    
};