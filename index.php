<?php

require_once 'Slim/Slim.php';
require_once 'api.php';
require_once 'dptcms/pagination.php';
require_once 'dptcms/logger.php';

Logger::logInfo("App started from ".$_SERVER['REMOTE_ADDR']);

\Slim\Slim::registerAutoloader();

/* Instatiate application */
$app = new \Slim\Slim(array(
    'cookies.encrypt' => true
        ));
$app->setName('Assesment Tool');

// GET routes
$app->get('/', function () use ($app) {
    $app->render('home.php');
});
$app->get('/home', function () use ($app) {
    $app->render('home.php');
});
$app->get('/projecttypes', function () use ($app) {
    $app->render('projecttypes.php');
});

// API GET routes
$app->get('/api/projecttypes/page/:pagenr', function ($pagenr) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    //Calculate start and count 
    $pg = Pager::pageToStartStop($pagenr);

    // Get the page
    echo json_encode(GraderAPI::getProjectTypes($pg->start, $pg->count));
});

// API PUT routes
$app->put('/api/projecttype/:id', function($id) use ($app){
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    
    // Update the existing resource
    echo json_encode(GraderAPI::updateProjectType(
                    $id, $app->request->post('code'), $app->request->post('name'), $app->request->post('description')));
});

// API POST routes
$app->post('/api/projecttype', function () use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    // Insert the data
    echo json_encode(GraderAPI::createProjectType(
                    $app->request->post('code'), $app->request->post('name'), $app->request->post('description')));
});

// API DELETE routes
$app->delete('/api/projecttypes/:id', function ($id) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    echo json_encode(GraderAPI::deleteProjectType($id));
});

/* Run the application */
$app->run();
