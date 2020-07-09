<?php 

use \ebuai\Page;
use \ebuai\Model\Category; 

//building page main
$app->get('/', function() {
    
	$page = new Page();

	$page->setTpl('index');

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