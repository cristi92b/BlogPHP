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
        TwigEnvironmentLoader::getInstance()->getEnvironment()->display('posts_index.html.twig',array(
            'posts' => Post::fetch_all_posts(Database::getInstance())
        ));
    }
    
    static function show($id){
        TwigEnvironmentLoader::getInstance()->getEnvironment()->display('posts_show.html.twig');
    }
    
    static function _new(){
        TwigEnvironmentLoader::getInstance()->getEnvironment()->display('posts_new.html.twig');
    }
    
    static function create($app){
        Post::insert_record(Database::getInstance(),$app->request()->post('title'),$app->request()->post('content'));
        TwigEnvironmentLoader::getInstance()->getEnvironment()->display('posts_index.html.twig',array(
            'posts' => Post::fetch_all_posts(Database::getInstance())
        ));
        //ladybug_dump($app->request()->post('title'));
        //ladybug_dump($app->request()->post('content'));
    }
    
    static function update($id,$title,$content){
        View::display('../Views/posts_index.twig', array(
            'table' => '<table><tr><td>1</td><td>2</td></tr></table>',
            'title' => 'blog'
        ));
    }
    
    static function delete($id){
        View::display('../Views/posts_index.twig', array(
            'table' => '<table><tr><td>1</td><td>2</td></tr></table>',
            'title' => 'blog'
        ));
    }
}
?>
