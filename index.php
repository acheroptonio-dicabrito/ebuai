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
//calling category class
use \ebuai\Model\Category;

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
		//disable header footer page login
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

$app->get('/admin/forgot', function() {

	$page = new PageAdmin([
		//disable header footer page forgot
		'header'=>false,	
		'footer'=>false	
	]);

	$page->setTpl('forgot');

});

$app->post('/admin/forgot', function() {

	$user = User::getForgot($_POST['email']);

	header('Location: /admin/forgot/sent');
	exit;

});

$app->get('/admin/forgot/sent', function() {

	$page = new PageAdmin([
		//disable header footer page forgot sent
		'header'=>false,	
		'footer'=>false	
	]);

	$page->setTpl('forgot-sent');

});

$app->get('/admin/forgot/reset', function() {

	$user = User::validForgotDecrypt($_GET['code']);

	$page = new PageAdmin([
		//disable header footer page forgot reset
		'header'=>false,	
		'footer'=>false	
	]);

	$page->setTpl('forgot-reset', array(
		'name'=>$user['desperson'],
		'code'=>$_GET['code']
	));	

});

$app->post('/admin/forgot/reset', function() {

	$forgot = User::validForgotDecrypt($_POST['code']);

	User::setForgotUsed($forgot['idrecovery']);

	$user = new User();

	$user->get((int)$forgot['iduser']);

	$password = password_hash($_POST['password'], PASSWORD_DEFAULT, [
		'cost' => 12,
	]);

	$user->setPassword($password);

	$page = new PageAdmin([
		//disable header footer page forgot success
		'header'=>false,	
		'footer'=>false	
	]);

	$page->setTpl('forgot-reset-success');	

});

$app->get('/admin/categories', function() {

	//verify user session
	User::verifyLogin();

	$categories = Category::listAll();

	$page = new PageAdmin();

	$page->setTpl('categories', [
		'categories'=>$categories
	]);

});

$app->get('/admin/categories/create', function() {

	//verify user session
	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl('categories-create');

});

$app->post('/admin/categories/create', function() {

	//verify user session
	User::verifyLogin();

	$category = new Category();

	$category->setData($_POST);

	$category->save();

	header('Location: /admin/categories');
	exit;

});

$app->get('/admin/categories/:idcategory/delete', function($idcategory) {

	//verify user session
	User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$category->delete();

	header('Location: /admin/categories');
	exit;

});

$app->get('/admin/categories/:idcategory', function($idcategory) {

	//verify user session
	User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$page = new PageAdmin();

	$page->setTpl('categories-update', [
		'category'=>$category->getValues()
	]);

});

$app->post('/admin/categories/:idcategory', function($idcategory) {

	//verify user session
	User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$category->setData($_POST);

	$category->save();

	header('Location: /admin/categories');
	exit;

});

$app->run();

 ?>