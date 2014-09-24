<?php
require 'vendor/autoload.php';
require_once 'twig.php';
include 'Model/database.php';
include 'Model/post.php';
include 'Model/comment.php';
include 'Controllers/posts.php';



$app = new \Slim\Slim();

//$twigView = new \Slim\Extras\Views\Twig();

/*
$app->config(array(
'debug' => true,
'templates.path' => './Views/',
'view' => $twig
));
*/

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

// posts create
$app->post('/', function () use ($app){
    PostsController::create($app);
});
$app->post('/posts', function () use ($app) {
    PostsController::create($app);
});

// posts new
$app->get('/posts/new', function () {
    PostsController::_new();
});

// posts show
$app->get('/posts/:id', function ($id) {
    PostsController::show($id);
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
