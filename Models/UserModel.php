<?php

class UserModel extends Model
{
	private $user_id;

	public function __construct($id = ''){
		parent::__construct();//necessário pois se você define um padrão de construtor aqui, ele passa a ignorar o construtor de model, pois ocorre uma sobreescrita
		if(!empty($id)){
			$this->user_id = $id;
		}
	}

	public function getName(){
		$stmt = "SELECT * FROM users WHERE id = '{$this->user_id}'";
		$sql = $this->db->query($stmt);
		$sql = $sql->fetch();

		return $sql['name'];

	}

	public function countFollowing(){
		$stmt = "SELECT * FROM relationships WHERE id_follower = {$this->user_id}";
		$sql = $this->db->query($stmt);
		return $sql->rowCount();
	}

	public function countFollowers(){
		$stmt = "SELECT * FROM relationships WHERE id_followed = {$this->user_id}";
		$sql = $this->db->query($stmt);
		return $sql->rowCount();
	}

	public function suggestUsers($limit){
		$stmt = "SELECT *,
		(SELECT count(*) FROM relationships
		WHERE relationships.id_follower = {$this->user_id} 
		AND relationships.id_followed = users.id) AS followed
		FROM users WHERE id != {$this->user_id} ORDER BY RAND() LIMIT {$limit}";

		$sql = $this->db->query($stmt);
		if($sql->rowCount() > 0){
			return $sql->fetchAll();
		}
		return [];

	}



    public function hasLoginSession()
    {
        if (isset($_SESSION["login_data"]) && !empty($_SESSION["login_data"])) {
            return true;
        }
        return false;
    }

    public function signUp($name, $email, $pass)
    {
        $message = "";
        if (!empty($email) && !empty($pass)) { //name was checked b4 on logincontroller

            if ($this->checkDuplicateEmail($email)) {
                $message = "Esse e-mail já foi usado!";
            } else {
                $stmt = "INSERT INTO users (name, email, password) VALUES ('{$name}', '{$email}', '{$pass}')";
                $this->db->query($stmt);
                $message = "Seja bem vindo ao twiiter!";
            }

        } else {
            $message = "Por favor, preencha todos os dados!";
        }
        return $message;
    }

    public function getLastUserId()
    {
        return $this->db->lastInsertId();

    }

    public function checkDuplicateEmail($email)
    {
        $stmt = "SELECT * FROM users WHERE email  =  '{$email}'";
        $query = $this->db->query($stmt);
        if ($query->rowCount() > 0) {
            return true;
        }
        return false;
    }

    public function login($email, $pass)
    {
        $result;
        $email = addslashes($email);
        $pass = md5($pass);
        if (!empty($email) && !empty($pass)) {

            $stmt = "SELECT * FROM users WHERE email = '{$email}' AND password = '{$pass}'";
            $sql = $this->db->query($stmt);
            $result = $sql->fetch();
            if (!$result) {
                return null;
            } else {
                return $result["id"];
            }

        }
        return null;

    }
}
