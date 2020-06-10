<?php

class UserModel extends Model {
     public function  hasLoginSession( ){
				if(isset($_SESSION["login_data"]) &&	!empty($_SESSION["login_data"])) {
				return true;
				} 
				return false;
		}
		
		
		public function  signUp($name, $email, $pass){
		$message = "";
		if(!empty($email) && !empty($pass)){//name was checked b4 on logincontroller
		
		if($this->checkDuplicateEmail($email)){
		   $message = "Esse e-mail já foi usado!";
		}
		else{
		   $stmt = "INSERT INTO users (name, email, password) VALUES ('{$name}', '{$email}', '{$pass}')";
		   $this->db->query($stmt);
		   $message = "Seja bem vindo ao twiiter!";
		}
		
		}
		else{
		$message = "Por favor, preencha todos os dados!";
		}
return $message;
      } 
      
      public function    getLastUserId( ){
        return $this->db->lastInsertId();

      } 
      
      public function    checkDuplicateEmail($email){
      $stmt  = "SELECT * FROM users WHERE email  =  '{$email}'";
      $query  =  $this->db->query($stmt);
      if($query->rowCount() > 0){
     		return true;
          }
          return false;
      }
      
      public function login($email,$pass){
      $result;
      $email = addslashes($email);
      $pass = md5($pass);
         if(!empty($email) && !empty($pass)){
         
				 $stmt = "SELECT * FROM users WHERE email = '{$email}', password = '{$pass}' ";
				 $result = $this->db->query($stmt)->fetch();
				 if(!result){
               return null;
  					  }
  				else{
  				     return $result["id"];
  				  }

  			}
  			return null;

      } 
}