<?php
require_once 'vendor/autoload.php';
require_once 'TwigEnvironmentLoader.php';
require_once 'MysqliAdapter.php';
require_once 'Acl.php';
require_once 'models/Database.php';
require_once 'models/Post.php';
require_once 'models/Comment.php';
require_once 'controllers/PostsController.php';
require_once 'controllers/ReadController.php';
require_once 'controllers/LoginController.php';

use JeremyKendall\Password\PasswordValidator;
use JeremyKendall\Slim\Auth\Adapter\Db\PdoAdapter;
use JeremyKendall\Slim\Auth\Bootstrap;
use JeremyKendall\Slim\Auth\Exception\HttpForbiddenException;


$app = new \Slim\Slim(array(
		'cookies.encrypt' => true,
		'cookies.secret_key' => 'FZr2ucE7eu5AB31p73QsaSjSIG5jhnssjgABlxlVeNV3nRjLt',
		'app.template' => 'default',
));

$validator = new PasswordValidator();
$adapter = new MysqliAdapter(Database::getInstance(),'users', 'username', 'password', $validator);
$acl = new Acl();
$authBootstrap = new Bootstrap($app, $adapter, $acl);
$authBootstrap->bootstrap();

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

//-------------------------------------------------------

// login index
$app->get('/login', function (){
    LoginController::index();
})->name('login');

// login authentication
$app->post('/login/auth', function () use($app){
    LoginController::login($app);
});

// login logout
$app->post('/login/logout', function () use($app){
    LoginController::logout($app);
});

//-------------------------------------------------------

// read index
$app->get('/read', function () {
    ReadController::index();
});


// read show
$app->get('/read/:id', function ($id){
    ReadController::show($id);
});


//-------------------------------------------------------

// posts index

$app->get('/', function () use ($app){
    $app->response->redirect("/read");
});
$app->get('/posts', function () use($app){
		$app->config('app.template', 'admin');
    PostsController::index($app);
});

// posts create
$app->post('/', function () use ($app){
    PostsController::create($app);
});


$app->post('/posts/create', function () use ($app) {
    PostsController::create($app);
    
});

// posts new
$app->get('/posts/new', function () use ($app) {
		$app->config('app.template', 'admin');
    PostsController::_new($app);
});

// posts show
$app->get('/posts/:id', function ($id) use($app){
		$app->config('app.template', 'admin');
    PostsController::show($app,$id);
});

// posts update
$app->post('/posts/:id', function() use ($app) {
    PostsController::update($app);
});

// posts delete
$app->post('/posts/:id/delete', function($id) use ($app){
    PostsController::delete($id, $app);
});

$app->run();
?>
