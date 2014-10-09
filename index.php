<?php
require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();

/* Instatiate application */
$app = new \Slim\Slim(array(
	'cookies.encrypt' => true
));
$app->setName('Assesment Tool');

// GET routes
$app->get('/', 						function () use ($app) { $app->render('home.php');});
$app->get('/home', 					function () use ($app) { $app->render('home.php');});

/* Run the application */
$app->run();
