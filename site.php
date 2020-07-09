<?php 

use \ebuai\Page;
use \ebuai\Model\Category; 
use \ebuai\Model\Product; 

//building page main
$app->get('/', function() {

	$products = Product::listAll();
    
	$page = new Page();

	$page->setTpl('index', [
		'products'=>Product::checkList($products)
	]);

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