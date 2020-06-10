<?php
	
	class LoginController extends Controller{
	public $data = array() ;
	public $userModel; 
	public function    __construct( ){
			 
      } 
	
	public function   index( ){


 		$this->loadView("login",$this->data);
     } 
     
     public function   signup( ){
      $userModel = new UserModel();
       if(isset($_POST["name"]) && !empty($_POST["name"])) {
       $name = addslashes($_POST["name"]);
       $email = addslashes($_POST["email"]);
       $password =  md5($_POST["password"]);
       
       $this->data['message'] = $userModel->signUp($name,$email,$password);
       }
     
			$this->loadView("signup",$this->data);
      } 
	
	}
 ?>