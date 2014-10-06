<?php
require_once 'vendor/autoload.php';
require_once 'TwigEnvironmentLoader.php';
require_once 'models/Database.php';
require_once 'models/Post.php';
require_once 'models/Comment.php';
require_once 'controllers/PostsController.php';


$app = new \Slim\Slim();

//for debbuging purposes
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/*
$app->add(new \Slim\Middleware\SessionCookie(array(
    'expires' => '20 minutes',
    'path' => '/',
    'domain' => null,
    'secure' => false,
    'httponly' => false,
    'name' => 'slim_session',
    'secret' => 'CHANGE_ME',
    'cipher' => MCRYPT_RIJNDAEL_256,
    'cipher_mode' => MCRYPT_MODE_CBC
)));
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
