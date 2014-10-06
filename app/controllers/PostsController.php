<?php

require_once __DIR__ . '/../TwigEnvironmentLoader.php';
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../models/Comment.php';



class PostsController{
    static function index(){
        if (session_status() == PHP_SESSION_ACTIVE) {
            $posts = Post::fetch_all_posts(Database::getInstance());
            echo self::render('posts_index.html.twig',array('posts' => $posts));
        }
        else
        {
            //redirect
        }
    }
    
    static function show($id){
        if (session_status() == PHP_SESSION_ACTIVE) {
            $post = Post::fetch_post_by_id(Database::getInstance(),$id);
            echo self::render('posts_show.html.twig',array('post' => $post));
        }
        else
        {
            //redirect
        }
    }
    
    static function _new(){
        if (session_status() == PHP_SESSION_ACTIVE) {
            echo self::render('posts_new.html.twig',array());
        }
        else
        {
            //redirect
        }
    }
    
    static function create($app){
        if (session_status() == PHP_SESSION_ACTIVE) {
            Post::insert_record(Database::getInstance(),$app->request()->post('title'),$app->request()->post('content'));
            $app->response->redirect("/posts");
        }
        else
        {
            //redirect
        }
    }
    
    static function update($app){
        if (session_status() == PHP_SESSION_ACTIVE) {
            $flag = Post::update_record(Database::getInstance(),$app->request()->post('id'),$app->request()->post('title'),$app->request()->post('content'));
            $app->response->redirect("/posts");
        }
        else
        {
            //redirect
        }
    }
    
    static function delete($id){
        if (session_status() == PHP_SESSION_ACTIVE) {
            Post::delete_record(Database::getInstance(),$id);
            $app->response->redirect("/posts");
        }
        else
        {
            //redirect
        }
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
