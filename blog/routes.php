<?php
require 'vendor/autoload.php';
include 'Controllers/*.php';
include 'Model/*.php';
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
    echo "5";
    PostsController::index();
    echo "6";
});

$app->get('/posts', function () {
    PostsController::index();
});

// posts show
$app->get('/posts/:id', function ($id) {
    PostsController::index();
});


// posts new
$app->get('/posts/new', function () {
    PostsController::index();
});

// posts create
$app->post('/posts', function () {
    PostsController::index();
});

// posts update
$app->put('/posts/:id', function ($id) {
    PostsController::index();
});

// posts delete
$app->delete('/posts/:id', function ($id) {
    PostsController::index();
});



$app->run();
?>
