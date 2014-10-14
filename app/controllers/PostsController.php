<?php

require_once __DIR__ . '/../TwigEnvironmentLoader.php';
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../models/Comment.php';


class PostsController{
    static function index($app){
        $posts = Post::fetch_all_posts(Database::getInstance());
        echo self::render('posts_index.html.twig',array('posts' => $posts), null, $app);
    }
    
    static function show($app,$id){
        $post = Post::fetch_post_by_id(Database::getInstance(),$id);
        echo self::render('posts_show.html.twig',array('post' => $post), null, $app);
    }
    
    static function _new($app){
        echo self::render('posts_new.html.twig',array(), null , $app);
    }
    
    static function create($app){
        $flag = Post::insert_record(Database::getInstance(),$app->request()->post('title'),$app->request()->post('content'));
        if($flag)
        {
            $app->flash('info', 'Post created successfully!');
        }
        else
        {
            $app->flash('info', 'Failed creating post!');
        }
        $app->response->redirect("/posts");
    }
    
    static function update($app){
        $flag = Post::update_record(Database::getInstance(),$app->request()->post('id'),$app->request()->post('title'),$app->request()->post('content'));
        if($flag)
        {
            $app->flash('info', 'Post updated sucessfully!');
        }
        else
        {
            $app->flash('info', 'Failed to update post!');
        }
        $app->response->redirect("/posts");
    }
    
    static function delete($app,$id){
        $flag = Post::delete_record(Database::getInstance(),$id);
        if($flag)
        {
            $app->flash('info', 'Post deleted sucessfully!');
        }
        else
        {
            $app->flash('info', 'Failed to delete post!');
        }
        $app->response->redirect("/posts");
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
    
    static function set_flash($string)
    {
    	self::$flash = $string;
    	self::$flash_data = true;
    }
    
    static function get_flash()
    {
    	self::$flash_data = false;
    	return self::$flash;
    }
}
?>
