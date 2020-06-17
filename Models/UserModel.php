<?php

class UserModel extends Model
{
    private $user_id;

    public function __construct($id = '')
    {
        parent::__construct(); //necessário pois se você define um padrão de construtor aqui, ele passa a ignorar o construtor de model, pois ocorre uma sobreescrita
        if (!empty($id)) {
            $this->user_id = $id;
        }
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getName()
    {
        $stmt = "SELECT * FROM users WHERE id = '{$this->user_id}'";
        $sql = $this->db->query($stmt);
        $sql = $sql->fetch();

        return $sql['name'];
    }

    public function countFollowing()
    {
        $stmt = "SELECT * FROM relationships WHERE id_follower = {$this->user_id}";
        $sql = $this->db->query($stmt);
        return $sql->rowCount();
    }

    public function countFollowers()
    {
        $stmt = "SELECT * FROM relationships WHERE id_followed = {$this->user_id}";
        $sql = $this->db->query($stmt);
        return $sql->rowCount();
    }

    public function getListOfFollowed()
    {
        $stmt = "SELECT * FROM relationships WHERE id_follower = {$this->user_id}";
        $sql = $this->db->query($stmt)->fetchAll();
        $listOfFollowed = array();
        foreach ($sql as $followed) {
            $listOfFollowed[] = $followed['id_followed'];
        }
        return $listOfFollowed;
    }

    public function suggestUsers($limit)
    {
        $stmt = "SELECT *,
		(SELECT count(*) FROM relationships
		WHERE relationships.id_follower = {$this->user_id} 
		AND relationships.id_followed = users.id) AS followed
		FROM users WHERE id != {$this->user_id} ORDER BY RAND() LIMIT {$limit}";

        $sql = $this->db->query($stmt);
        if ($sql->rowCount() > 0) {
            return $sql->fetchAll();
        }
        return [];
    }

    public function follow($id_follower, $id_followed)
    {
        $stmt = "INSERT INTO relationships SET id_follower = {$id_follower}, id_followed = {$id_followed}";
        $sql = $this->db->query($stmt);
    }

    public function unfollow($id_follower, $id_followed)
    {
        $stmt = "DELETE FROM relationships WHERE id_follower = {$id_follower} AND id_followed = {$id_followed}";

        $sql = $this->db->query($stmt);
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
                $stmt = "INSERT INTO users (name, email, password,confirmed_email) VALUES ('{$name}', '{$email}', '{$pass}',0)";
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

    public function sendConfirmationEmail($id)
    {
        $stmt = "SELECT * FROM users WHERE id = {$id}";
        $result = $this->db->query($stmt)->fetch();
        $receiver = $result['email'];
        $title = "Please, confirm your e-mail!";
        $url = "https://ismstwiiterclone.000webhostapp.com/login/confirm?id=" . md5($result['id']);
        $message = "In order to confirm your e-mail and start using twiiter, click the link below:\n\n{$url}";
        $php_version = phpversion();
        $headers = [
            "From" => "isaacsms@id.uff.br",
            "Reply-To" => "isaacde2012@gmail.com",
            "X-Mailer" => "PHP/{$php_version}"
        ];
        mail($receiver, $title, $message, $headers);
    }

    public function confirm($id)
    {
        $stmt = "UPDATE users SET confirmed_email = 1 WHERE MD5(id) = '{$id}'";
        $sql = $this->db->query($stmt);
        if ($sql->rowCount() == 1) {
            return $sql->fetch();
        }
        return null;
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

            $stmt = "SELECT * FROM users WHERE email = '{$email}' AND password = '{$pass}' AND confirmed_email = 1";
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
