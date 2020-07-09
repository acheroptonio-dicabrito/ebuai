<?php

use \ebuai\PageAdmin;
use \ebuai\Model\User;
use \ebuai\Model\Category;  
use \ebuai\Model\Product;  

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

$app->get('/admin/categories/:idcategory/products', function($idcategory) {

	User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$page = new PageAdmin();

	$page->setTpl('categories-products', [
		'category'=>$category->getValues(),
		'productsRelated'=>$category->getProducts(),
		'productsNotRelated'=>$category->getProducts(false)
	]);

});

$app->get('/admin/categories/:idcategory/products/:idproduct/add', function($idcategory, $idproduct) {

	User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$product = new Product();

	$product->get((int)$idproduct);

	$category->addProduct($product);

	header('Location: /admin/categories/'.$idcategory.'/products');
	exit;

});

$app->get('/admin/categories/:idcategory/products/:idproduct/remove', function($idcategory, $idproduct) {

	User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$product = new Product();

	$product->get((int)$idproduct);

	$category->removeProduct($product);

	header('Location: /admin/categories/'.$idcategory.'/products');
	exit;

});


?>