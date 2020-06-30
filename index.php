<?php 

require_once("vendor/autoload.php");

use \Slim\Slim;
use \ebuai\Page;
use \ebuai\PageAdmin;

$app = new Slim();

$app->config('debug', true);

$app->get('/', function() {
    
	$page = new Page();

	$page->setTpl("index");

});

$app->get('/optimus_prime', function() {
    
	$page = new PageAdmin();

	$page->setTpl("index");

});

$app->run();

 ?>