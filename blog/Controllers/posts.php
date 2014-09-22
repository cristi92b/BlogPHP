<?php
class PostsController{
    static function index(){
        View::display('posts_index.twig', array(
            'table' => '<table><tr><td>1</td><td>2</td></tr></table>',
            'title' => 'blog'
        ));
    }
}
?>