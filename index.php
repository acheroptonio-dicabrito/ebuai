<?php
//starting session  
session_start();
//settings loading
require_once('vendor/autoload.php');

//calling slim class
use \Slim\Slim;
//calling page class
use \ebuai\Page;
//calling pageadmin class
use \ebuai\PageAdmin;
//calling user class
use \ebuai\Model\User;

$app = new Slim();

$app->config('debug', true);

//building page main
$app->get('/', function() {
    
	$page = new Page();

	$page->setTpl('index');

});

//building page admin
$app->get('/admin', function() {

	//verify user session
	User::verifyLogin();
    
	$page = new PageAdmin();

	$page->setTpl('index');

});

//building page login admin
$app->get('/admin/login', function(){

	$page = new PageAdmin([
		'header'=>false,	
		'footer'=>false	
	]);

	$page->setTpl('login');

});

//route login panel admin
$app->post('/admin/login', function(){

	//verify user session
	User::login($_POST['login'], $_POST['password']);

	header('Location: /admin');

	exit;

});

//route logout panel admin
$app->get('/admin/logout', function() {

	//set null user session
	User::logout();

	header('Location: /admin/login');
	exit;

});

//route list users panel admin
$app->get('/admin/users', function(){

	//verify user session
	User::verifyLogin();

	$users = User::listAll();
    
	$page = new PageAdmin();

	$page->setTpl('users', array(
		'users'=>$users
	));

});

//route page users create panel admin
$app->get('/admin/users/create', function(){

	//verify user session
	User::verifyLogin();
    
	$page = new PageAdmin();

	$page->setTpl('users-create');

});

//route delete users panel admin
$app->get('/admin/users/:iduser/delete', function($iduser){

	//verify user session
	User::verifyLogin();

	$user = new User();

	$user->get((int)$iduser);

	$user->delete();

	header('Location: /admin/users');
	exit;

});

//route page users update panel admin
$app->get('/admin/users/:iduser', function($iduser){

	//verify user session
	User::verifyLogin();

	$user = new User();

	$user->get((int)$iduser);
    
	$page = new PageAdmin();

	$page->setTpl('users-update', array(
		'user'=>$user->getValues()
	));

});

//route create new user panel admin
$app->post('/admin/users/create', function(){

	//verify user session
	User::verifyLogin();

	$user = new User();

	//verify user level
	$_POST['inadmin'] = (isset($_POST['inadmin']))?1:0;

	$user->setData($_POST);

	$user->save();

	header('Location: /admin/users');
	exit;

});

//route page update user panel admin
$app->post('/admin/users/:iduser', function($iduser){

	//verify user session
	User::verifyLogin();

	$user = new User();

	//verify user level
	$_POST['inadmin'] = (isset($_POST['inadmin']))?1:0;

	$user->get((int)$iduser);

	$user->setData($_POST);

	$user->update();

	header('Location: /admin/users');
	exit;

});


$app->run();

 ?>