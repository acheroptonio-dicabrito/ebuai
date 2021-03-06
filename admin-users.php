<?php 

use \ebuai\PageAdmin;
use \ebuai\Model\User;

//route list users panel admin
$app->get('/admin/users', function(){

	//verifying an user session
	User::verifyLogin();

	$users = User::listAll();
    
	$page = new PageAdmin();

	$page->setTpl('users', array(
		'users'=>$users
	));

});

//route page users create panel admin
$app->get('/admin/users/create', function(){

	//verifying an user session
	User::verifyLogin();
    
	$page = new PageAdmin();

	$page->setTpl('users-create');

});

//route delete users panel admin
$app->get('/admin/users/:iduser/delete', function($iduser){

	//verifying an user session
	User::verifyLogin();

	$user = new User();

	$user->get((int)$iduser);

	$user->delete();

	header('Location: /admin/users');
	exit;

});

//route page users update panel admin
$app->get('/admin/users/:iduser', function($iduser){

	//verifying an user session
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

	//verifying an user session
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

	//verifying an user session
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



?>