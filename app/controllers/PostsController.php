<?php

require_once __DIR__ . '/../TwigEnvironmentLoader.php';
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../models/Comment.php';



class PostsController{
    static function index(){
        
        //TwigEnvironmentLoader::getInstance()->getEnvironment()->display('posts_index.html.twig',array(
        //    'posts' => Post::fetch_all_posts(Database::getInstance())
        //));
        $posts = Post::fetch_all_posts(Database::getInstance());
        echo self::render('posts_index.html.twig',array('posts' => $posts));
    }
    
    static function show($id){
        $post = Post::fetch_post_by_id(Database::getInstance(),$id);
        echo self::render('posts_show.html.twig',array('post' => $post));
        //TwigEnvironmentLoader::getInstance()->getEnvironment()->display('posts_show.html.twig',array(
        //    'post' => Post::fetch_post_by_id(Database::getInstance(),$id)
        //));
    }
    
    static function _new(){
        echo self::render('posts_new.html.twig',array());
    }
    
    static function create($app){
        Post::insert_record(Database::getInstance(),$app->request()->post('title'),$app->request()->post('content'));
        $app->response->redirect("/posts");
    }
    
    static function update($app){
        //validation required
        $flag = Post::update_record(Database::getInstance(),$app->request()->post('id'),$app->request()->post('title'),$app->request()->post('content'));
        //ladybug_dump($flag);
        $app->response->redirect("/posts");
        //$post = Post::fetch_post_by_id(Database::getInstance(),$app->request()->post('id'));
        //echo self::render('posts_update.html.twig',array(
        //        'post' => $post
        //    ));
        //TwigEnvironmentLoader::getInstance()->getEnvironment()->display('posts_update.html.twig',array(
        //    'post' => Post::fetch_post_by_id(Database::getInstance(),$app->request()->post('id'))
        //));
    }
    
    static function delete($id){
        Post::delete_record(Database::getInstance(),$id);
        $app->response->redirect("/posts");
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
