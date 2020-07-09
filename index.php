<?php
//starting session  
session_start();
//settings loading
require_once('vendor/autoload.php');

//calling slim class
use \Slim\Slim;

$app = new Slim();

$app->config('debug', true);

require_once('site.php');
require_once('admin.php');
require_once('admin-users.php');
require_once('admin-categories.php');
require_once('admin-products.php');

$app->run();

 ?>