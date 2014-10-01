<?php

if(!class_exists('TwigEnvironmentLoader'))
{
    require '../twig.php';
}
if(!class_exists('Database'))
{
    require '../Model/database.php';
}
if(!class_exists('Post'))
{
    require '../Model/post.php';
}
if(!class_exists('Comment'))
{
    require '../Model/comment.php';
}


class PostsController{
    static function index(){
        
        //TwigEnvironmentLoader::getInstance()->getEnvironment()->display('posts_index.html.twig',array(
        //    'posts' => Post::fetch_all_posts(Database::getInstance())
        //));
        $posts = Post::fetch_all_posts(Database::getInstance());
        echo self::render('posts_index.html.twig',array('posts' => $posts));
    }
    
    static function show($id){
        TwigEnvironmentLoader::getInstance()->getEnvironment()->display('posts_show.html.twig',array(
            'post' => Post::fetch_post_by_id(Database::getInstance(),$id)
        ));
    }
    
    static function _new(){
        TwigEnvironmentLoader::getInstance()->getEnvironment()->display('posts_new.html.twig');
    }
    
    static function create($app){
        Post::insert_record(Database::getInstance(),$app->request()->post('title'),$app->request()->post('content'));
        $app->response->redirect("/posts");
    }
    
    static function update($app){
        Post::update_record(Database::getInstance(),$app->request()->post('id'),$app->request()->post('title'),$app->request()->post('content'));
        TwigEnvironmentLoader::getInstance()->getEnvironment()->display('posts_update.html.twig',array(
            'post' => Post::fetch_post_by_id(Database::getInstance(),$app->request()->post('id'))
        ));
    }
    
    static function delete($id){
        Post::delete_record(Database::getInstance(),$id);
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
