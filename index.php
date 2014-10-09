<?php
require 'Slim/Slim.php';
require 'api.php';
require 'dptcms/pagination.php';

\Slim\Slim::registerAutoloader();

/* Instatiate application */
$app = new \Slim\Slim(array(
	'cookies.encrypt' => true
));
$app->setName('Assesment Tool');

// GET routes
$app->get('/', 						function () use ($app) { $app->render('home.php');});
$app->get('/home', 					function () use ($app) { $app->render('home.php');});
$app->get('/projecttypes', 			function () use ($app) { $app->render('projecttypes.php');});

// API GET routes
$app->get('/api/projecttypes/page/:pagenr',		function ($pagenr) use ($app){
	// Use json headers
	$response = $app->response();
	$response->header('Content-Type', 'application/json');

	//Calculate start and count 
	$pg = Pager::pageToStartStop($pagenr);
	
	// Get the page
	GraderAPI::getProjectTypes($pg->start, $pg->count);
});

/* Run the application */
$app->run();
