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

//function login
$app->post('/admin/login', function(){

	User::login($_POST['login'], $_POST['password']);

	header('Location: /admin');

	exit;

});

$app->get('/admin/logout', function() {

	User::logout();

	header('Location: /admin/login');
	exit;

});

$app->run();

 ?>