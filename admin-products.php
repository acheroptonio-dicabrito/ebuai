<?php  

use \ebuai\PageAdmin;
use \ebuai\Model\User;
use \ebuai\Model\Product;

//building page products panel admin
$app->get('/admin/products', function() {

	//verifying an user session
	User::verifyLogin();

	$products = Product::listAll();

	$page = new PageAdmin();

	$page->setTpl('products', [
		'products'=>$products
	]);

});

$app->get('/admin/products/create', function() {

	//verifying an user session
	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl('products-create');

});

$app->post('/admin/products/create', function() {

	User::verifyLogin();

	$product = new Product();

	$product->setData($_POST);

	$product->save();

	header('Location: /admin/products');
	exit;

});

$app->get('/admin/products/:idproduct', function($idproduct) {

	User::verifyLogin();

	$product = new Product();

	$product->get((int)$idproduct);

	$page = new PageAdmin();

	$page->setTpl('products-update', [
		'product'=>$product->getValues()
	]);	

});

$app->post('/admin/products/:idproduct', function($idproduct) {

	User::verifyLogin();

	$product = new Product();

	$product->get((int)$idproduct);

	$product->setData($_POST);

	$product->save();

	$product->setPhoto($_FILES['file']);

	header('Location: /admin/products');
	exit;	

});

$app->get('/admin/products/:idproduct/delete', function($idproduct) {

	User::verifyLogin();

	$product = new Product();

	$product->get((int)$idproduct);

	$product->delete();

	header('Location: /admin/products');
	exit;	

});

?>