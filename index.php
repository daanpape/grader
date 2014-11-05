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
$app->get('/courses', function () use ($app) {
    $app->render('courses.php');
});
$app->get('/projects', function () use ($app) {
    $app->render('projects.php');
});
$app->get('/assess', function() use ($app) {
    $app->render('assess.php');
});

// API GET routes
$app->get('/api/projects/page/:pagenr', function ($pagenr) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    
    // Calculate start and count 
    $pg = Pager::pageToStartStop($pagenr);
    
    // Get total number of projecttypes in the database
    $pagedata = GraderAPI::getProjects($pg->start, $pg->count);
    $totalprojects = GraderAPI::getProjectCount();
    
    // Get the page
    echo json_encode(Pager::genPaginatedAnswer($pagenr, $pagedata, $totalprojects));
});

$app->get('/api/locations', function () use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    // Get all locations
    $pagedata = GraderAPI::getLocations();

    echo json_encode($pagedata);
});

$app->get('/api/trainings/:locationId', function ($locationId) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    // Get all trainings by locationsid
    $pagedata = GraderAPI::getTrainingsByLocation($locationId);

    echo json_encode($pagedata);
});

$app->get('/api/courses/:trainingId', function ($trainingId) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    // Get all courses by the trainingsid
    $pagedata = GraderAPI::getCoursesByTraining($trainingId);

    echo json_encode($pagedata);
});

// API PUT routes
$app->put('/api/project/:id', function($id) use ($app){
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    
    // Update the existing resource
    echo json_encode(GraderAPI::updateProject(
                    $id, $app->request->post('code'), $app->request->post('name'), $app->request->post('description')));
});

// API POST routes
$app->post('/api/project', function () use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    // Insert the data
    echo json_encode(GraderAPI::createProject(
                    $app->request->post('code'), $app->request->post('name'), $app->request->post('description')));
});

// API DELETE routes
$app->delete('/api/project/:id', function ($id) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    echo json_encode(GraderAPI::deleteProject($id));
});

/* Run the application */
$app->run();
