<?php
require 'vendor/autoload.php';
include 'Controllers/posts.php';
include 'Model/database.php';
include 'Model/post.php';
include 'Model/comment.php';
$app = new \Slim\Slim();

/*
$app->map('/dynamic/:class/:function', function ($class,$function) use ($app) {
if(!isset($_SESSION['myid'])) die("pleaselogin");
require_once('controllers/'.str_replace('.','/',$class).'.php');
$Class=substr($class,strrpos($class,'.')+1);
$controller=new $Class($app);
if(method_exists($controller,$function)) $controller->{$function}();
})->via('GET', 'POST');
*/


// posts index
$app->get('/', function () {
    PostsController::index();
});

$app->get('/posts', function () {
    PostsController::index();
});

// posts show
$app->get('/posts/:id', function ($id) {
    PostsController::show($id);
});


// posts new
$app->get('/posts/new', function () {
    PostsController::_new();
});

// posts create
$app->post('/posts', function ($title,$content) {
    PostsController::create($title,$content);
});

// posts update
$app->put('/posts/:id', function ($id,$title,$content) {
    PostsController::update($id);
});

// posts delete
$app->delete('/posts/:id', function ($id) {
    PostsController::delete($id);
});



$app->run();
?>
