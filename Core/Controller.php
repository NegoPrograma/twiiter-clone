<?php

class Controller
{

    public function  __construct()
    {
    }

    public function loadView($viewName, $viewData = array())
    {

        include_once './Views/' . $viewName . '.php';
    }

    public function loadTemplate($viewName, $viewData = array())
    {
        include_once "./views/template.php";
    }
}
