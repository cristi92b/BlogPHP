<?php

require_once __DIR__ . '/../TwigEnvironmentLoader.php';
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../models/Comment.php';


class LoginController{
    static function index()
    {
        echo self::render('login_index.html.twig',array());
    }
    
    static function login($app)
    {

    }
    
    static function logout()
    {
        
    }
    
    static function render($viewFile, $viewData){
        $twig = TwigEnvironmentLoader::getInstance()->getEnvironment();
        $renderedView = $twig->render($viewFile, $viewData);
        $renderedTemplate = $twig->render("./templates/default.html.twig",
            array(
                 'mainContent' => $renderedView 
        ));
        return $renderedTemplate;
    }
}
?>
