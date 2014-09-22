<?php
require 'vendor/autoload.php';
include 'Controllers/*.php';
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
    echo "7";
    PostsController::index();
    echo "8";
});
$app->run();
?>
