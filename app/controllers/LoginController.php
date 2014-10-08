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
        $username = null;
        if ($app->request()->isPost()) {
            $username = $app->request->post('user');
            $password = $app->request->post('password');
            $result = $app->authenticator->authenticate($username, $password);
            if ($result->isValid()) {
                $app->redirect('/posts');
            } else {
                $messages = $result->getMessages();
                $app->redirect('/');
                //$app->flash('error', $messages[0]);
            }
        }
    }
    
    static function logout($app)
    {
        if ($app->auth->hasIdentity()) {
            $app->auth->clearIdentity();
        }
        $app->redirect('/');
        /*
        $hasIdentity = $app->auth->hasIdentity();
        $identity = $app->auth->getIdentity();
        $role = ($hasIdentity) ? $identity['role'] : 'guest';
        */
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
