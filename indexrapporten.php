<?php

require_once 'apirapporten.php';

$app->get('/coursesrapporten', function () use ($app) {
    $app->render('templatesrapport/coursesrapporten.php');
});

$app->get('/homerapporten', function () use ($app) {
    $app->render('templatesrapport/homerapporten.php');
});

$app->get('/assessrapporten', function () use ($app) {
    $app->render('templatesrapport/assessrapporten.php');
});

$app->get('/studentrapportrapporten', function () use ($app) {
    $app->render('templatesrapport/studentrapportrapporten.php');
});

/* API get routes */

$app->get('/rapportapi/courses/page/:pagenr', function ($pagenr) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    // Calculate start and count
    $pg = Pager::pageToStartStop($pagenr);

    // Get total number of projecttypes in the database
    $pagedata = RapportAPI::getAllCourses($pg->start, $pg->stop);
    $totalcourses = RapportAPI::getCourseCount();

    // Get the page
    echo json_encode(Pager::genPaginatedAnswer($pagenr, $pagedata, $totalcourses));
});

$app->post('/api/courserapport', function () use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    // Insert the data
    echo json_encode(RapportAPI::createCourse($app->request->post('code'), $app->request->post('name'), $app->request->post('description')));
});

$app->get('/rapportapi/courses', function () use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    // Get all locations
    $pagedata = RapportAPI::getAllCourse();

    echo json_encode($pagedata);
});
?>
