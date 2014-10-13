<?php

require_once __DIR__ . '/../TwigEnvironmentLoader.php';
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../models/Comment.php';



class PostsController{
    static function index($app){
        $posts = Post::fetch_all_posts(Database::getInstance());
        echo self::render('posts_index.html.twig',array('posts' => $posts), $app);
    }
    
    static function show($app,$id){
        $post = Post::fetch_post_by_id(Database::getInstance(),$id);
        echo self::render('posts_show.html.twig',array('post' => $post), $app);
    }
    
    static function _new($app){
        echo self::render('posts_new.html.twig',array(), $app);
    }
    
    static function create($app){
        Post::insert_record(Database::getInstance(),$app->request()->post('title'),$app->request()->post('content'));
        $app->response->redirect("/posts");
    }
    
    static function update($app){
        $flag = Post::update_record(Database::getInstance(),$app->request()->post('id'),$app->request()->post('title'),$app->request()->post('content'));
        $app->response->redirect("/posts");
    }
    
    static function delete($id, $app){
        Post::delete_record(Database::getInstance(),$id);
        //$app->response->setBody(json_encode(array('status'=>'success')));
        $app->response->redirect("/posts");
    }
    
    static function render($viewFile, $viewData, $app = null){
        $twig = TwigEnvironmentLoader::getInstance()->getEnvironment();
        $renderedView = $twig->render($viewFile, $viewData);
        $template = 'default';
        if($app != null){
	        $template = $app->config('app.template');
	      }
        $renderedTemplate = $twig->render("./templates/" . $template . ".html.twig",
            array(
                 'mainContent' => $renderedView 
        ));
        return $renderedTemplate;
    }
}
?>
