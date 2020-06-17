<?php

class LoginController extends Controller
{
    public $data = array();

    public function __construct()
    {
    }

    public function index()
    {
        if (isset($_POST["email"]) && !empty($_POST["email"])) {
            $userModel = new UserModel();
            $email = $_POST["email"];
            $pass = $_POST["password"];
            $responseId = $userModel->login($email, $pass);

            if ($responseId != null) {
                $_SESSION["login_data"] = $responseId;
                header("location: home");
            } else {
                $this->data["message"] = "Os dados preenchidos estão incorretos ou você ainda não confirmou o e-mail de registro.";
            }
        }

        $this->loadView("login", $this->data);
    }

    public function signup()
    {
        $userModel = new UserModel();
        if (isset($_POST["name"]) && !empty($_POST["name"])) {
            $name = addslashes($_POST["name"]);
            $email = addslashes($_POST["email"]);
            $password = md5($_POST["password"]);

            $this->data['message'] = $userModel->signUp($name, $email, $password);
            if ($this->data['message'] == "Seja bem vindo ao twiiter!") {
                //$_SESSION["login_data"]  = $userModel->getLastUserId();
                $userModel->sendConfirmationEmail($userModel->getLastUserId());
                //header("location: ../home");
                echo "<h4>Parabéns! Você já é praticamente um membro da comunidade! Para completar totalmente sua inscrição, por favor confirme seu E-mail.<h4/>";
            }
        }

        $this->loadView("signup", $this->data);
    }

    public function confirm()
    {
        $id = $_GET['id'];
        if ($id != null) {
            $userModel = new UserModel();
            $user = $userModel->confirm($id);
            $_SESSION['login_data'] = $user['id'];
            header("../home");
        }
    }

    public function logout()
    {
        unset($_SESSION["login_data"]);
        header("location: ../home");
    }
}
