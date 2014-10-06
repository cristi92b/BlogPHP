<?php
require_once 'vendor/autoload.php';
require_once 'TwigEnvironmentLoader.php';
require_once 'models/Database.php';
require_once 'models/Post.php';
require_once 'models/Comment.php';
require_once 'controllers/PostsController.php';



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

$app->get('/', function () use ($app){
    $app->response->redirect("/posts");
});
$app->get('/posts', function () {
    PostsController::index();
});

// posts create
$app->post('/', function () use ($app){
    PostsController::create($app);
});
$app->post('/posts/create', function () use ($app) {
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
$app->post('/posts/:id', function() use ($app) {
    PostsController::update($app);
});

// posts delete
$app->post('/posts/:id/delete', function($id){
    PostsController::delete($id);
});



$app->run();
?>
