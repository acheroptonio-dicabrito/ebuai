<?php

use \ebuai\PageAdmin;
use \ebuai\Model\User;
use \ebuai\Model\Category;  

//building page categories panel admin
$app->get('/admin/categories', function() {

	//verifying an user session
	User::verifyLogin();

	$categories = Category::listAll();

	$page = new PageAdmin();

	$page->setTpl('categories', [
		'categories'=>$categories
	]);

});

//building page categories create
$app->get('/admin/categories/create', function() {

	//verifying an user session
	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl('categories-create');

});

//route create a new category panel admin
$app->post('/admin/categories/create', function() {

	//verifying an user session
	User::verifyLogin();

	$category = new Category();

	$category->setData($_POST);

	$category->save();

	header('Location: /admin/categories');
	exit;

});

//route delete a category panel admin
$app->get('/admin/categories/:idcategory/delete', function($idcategory) {

	//verifying an user session
	User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$category->delete();

	header('Location: /admin/categories');
	exit;

});

//route page update a category panel admin
$app->get('/admin/categories/:idcategory', function($idcategory) {

	//verifying an user session
	User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$page = new PageAdmin();

	$page->setTpl('categories-update', [
		'category'=>$category->getValues()
	]);

});

//route page update category panel admin
$app->post('/admin/categories/:idcategory', function($idcategory) {

	//verifying an user session
	User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$category->setData($_POST);

	$category->save();

	header('Location: /admin/categories');
	exit;

});

//building page category
$app->get('/categories/:idcategory', function($idcategory) {

	$category = new Category();

	$category->get((int)$idcategory);

	$page = new Page();

	$page->setTpl('category', [
		'category'=>$category->getValues(),
		'products'=>[]
	]);

});



?>