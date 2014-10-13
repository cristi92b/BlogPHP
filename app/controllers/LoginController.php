<?php

require_once __DIR__ . '/../TwigEnvironmentLoader.php';
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../models/Comment.php';


class LoginController{
    static function index($app)
    {
        echo self::render('login_index.html.twig',array('loggedin' => self::status($app)),array('loggedin' => self::status($app)));
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
    
    static function render($viewFile, $viewData,$templateData = null,$app = null){
        $twig = TwigEnvironmentLoader::getInstance()->getEnvironment();
        $renderedView = $twig->render($viewFile, $viewData);
        $template = 'default';
        if($app != null){
	        $template = $app->config('app.template');
	      }
        if($templateData==null)
        {
		      $renderedTemplate = $twig->render("./templates/" . $template . ".html.twig",
		          array('mainContent' => $renderedView));
        }
        else
        {
        	$renderedTemplate = $twig->render("./templates/" . $template . ".html.twig",
		          array_merge($templateData,array('mainContent' => $renderedView)));
        }
        return $renderedTemplate;
    }
    
    static function status($app)
    {
			if($app->auth->hasIdentity())
			{
				$loggedin = true;
			}
			else
			{
				$loggedin = false;
			}
			return $loggedin;
    }
}
?>
