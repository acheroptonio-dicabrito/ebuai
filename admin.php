<?php

use \ebuai\PageAdmin;
use \ebuai\Model\User;  

//building page admin
$app->get('/admin', function() {

	//verifying an user session
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

//building page forgot password
$app->get('/admin/forgot', function() {

	$page = new PageAdmin([
		//disable header footer page forgot
		'header'=>false,	
		'footer'=>false	
	]);

	$page->setTpl('forgot');

});

//route sending email forgot password
$app->post('/admin/forgot', function() {

	$user = User::getForgot($_POST['email']);

	header('Location: /admin/forgot/sent');
	exit;

});

//building page forgot sent
$app->get('/admin/forgot/sent', function() {

	$page = new PageAdmin([
		//disable header footer page forgot sent
		'header'=>false,	
		'footer'=>false	
	]);

	$page->setTpl('forgot-sent');

});

//building page forgot reset
$app->get('/admin/forgot/reset', function() {

	//verify code password reset
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

//building page forgot reset success
$app->post('/admin/forgot/reset', function() {

	//verify code password reset
	$forgot = User::validForgotDecrypt($_POST['code']);

	//checking code password reset
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



?>