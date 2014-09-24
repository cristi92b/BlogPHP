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
        echo "calling index method";
        TwigEnvironmentLoader::getInstance()->getEnvironment()->display('posts_index.html.twig',array(
            'table' => '<table><tr><td>1</td><td>2</td></tr></table>',
            'title' => 'blog',
            'posts' => Post::fetch_all_posts(Database::getInstance())
        ));
    }
    
    static function show($id){
        echo "calling show method with id=" + $id;
        View::display('../Views/posts_index.twig', array(
            'table' => '<table><tr><td>1</td><td>2</td></tr></table>',
            'title' => 'blog'
        ));
    }
    
    static function _new(){
        echo "calling new method ";
        View::display('../Views/posts_index.twig', array(
            'table' => '<table><tr><td>1</td><td>2</td></tr></table>',
            'title' => 'blog'
        ));
    }
    
    static function create($title,$content){
        echo "calling create method";
        View::display('../Views/posts_index.twig', array(
            'table' => '<table><tr><td>1</td><td>2</td></tr></table>',
            'title' => 'blog'
        ));
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
