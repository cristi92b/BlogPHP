<?php

require_once __DIR__ . '/../TwigEnvironmentLoader.php';
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../models/Comment.php';



class ReadController{
    static function index($app){
        $posts = Post::fetch_all_posts(Database::getInstance());
        echo self::render('read_index.html.twig',array('posts' => $posts),array('loggedin' => self::status($app)));
    }
    
    static function show($app,$id){
        $post = Post::fetch_post_by_id(Database::getInstance(),$id);
        $comments = Comment::fetch_all_comments(Database::getInstance(),$id);
        echo self::render('read_show.html.twig',array('post' => $post , 'comments' => $comments),array('loggedin' => self::status($app)));
    }
    /*
    static function _new($app){
        
    }
    */
    static function create($app){
        $flag = Comment::insert_record(Database::getInstance(),$app->request()->post('name'),$app->request()->post('content'),$app->request()->post('id'));
        if($flag)
        {
            $app->flash('info', 'Comment created successfully!');
        }
        else
        {
            $app->flash('info', 'Failed creating comment!');
        }
        $app->response->redirect("/read/" . $app->request()->post('id'));
    }
    
    static function render($viewFile, $viewData,$templateData = null,$app = null){
        $twig = TwigEnvironmentLoader::getInstance()->getEnvironment();
        $renderedView = $twig->render($viewFile, $viewData);
        $template = 'default';
        if ( array_key_exists('slim.flash', $_SESSION) 
        	&&  array_key_exists('info', $_SESSION['slim.flash']) 
       ) {
        	$templateData['flash'] = $_SESSION['slim.flash']['info'];
        }
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
