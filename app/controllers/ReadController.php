<?php

require_once __DIR__ . '/../TwigEnvironmentLoader.php';
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../models/Comment.php';



class ReadController{
    static function index(){
        $posts = Post::fetch_all_posts(Database::getInstance());
        echo self::render('read_index.html.twig',array('posts' => $posts));
    }
    
    static function show($id){
        $post = Post::fetch_post_by_id(Database::getInstance(),$id);
        echo self::render('read_show.html.twig',array('post' => $post));
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
