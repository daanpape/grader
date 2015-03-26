<?php

require_once 'apirapporten.php';

//GET routes

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

$app->get('/coursecompetence/:id/:name', function ($id, $name) use($app) {
    $app->render('templatesrapport/competencerapporten.php', array('courseid' => $id, 'coursename' => $name));
});
$app->get('/account/admin', function () use($app) {
    $app->render('templatesrapport/adminrapporten.php');
});

$app->get('/api/coursesrapport/page/:pagenr', function ($pagenr) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    // Calculate start and count
    $pg = Pager::pageToStartStop($pagenr);

    // Get total number of projecttypes in the database
    //$pagedata = RapportAPI::getAllCourses($pg->start, $pg->stop);
    $pagedata = RapportAPI::getAllCourses($pg->start, $pg->count);
    $totalcourses = RapportAPI::getCourseCount();

    // Get the page
    echo json_encode(Pager::genPaginatedAnswer($pagenr, $pagedata, $totalcourses));
});

//get module from course
$app->get('/api/coursesrapport/:courseId', function ($locationId) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    // Get all trainings by locationsid
    $pagedata = RapportAPI::getCompetenceByCourse($locationId);

    echo json_encode($pagedata);
});

//getsubmodule from module
$app->get('/api/submodulerapport/:moduleId', function ($trainingId) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    // Get all courses by the trainingsid
    $pagedata = RapportAPI::getSubCompetenceByCompetence($trainingId);

    echo json_encode($pagedata);
});

//getgoals from submodule
$app->get('/api/goalrapport/:submoduleId', function ($trainingId) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    // Get all courses by the trainingsid
    $pagedata = RapportAPI::getGoalBySubCompetence($trainingId);

    echo json_encode($pagedata);
});

//get all subcompetences
$app->get('/api/coursestructure/:id', function($id) use ($app) {
    $app->response->headers->set('Content-Type', 'application/json');
    echo json_encode(RapportAPI::getAllDataFromCourse($id));
});


$app->get('/api/courserapportdrop', function () use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    // Get all locations
    $pagedata = RapportAPI::getAllCourse();

    echo json_encode($pagedata);
});

//add teacher to dropdown
$app->get('/api/teacherrapport/:teacherId', function ($trainingId) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    // Get all courses by the trainingsid
    $pagedata = RapportAPI::getTeacher($trainingId);

    echo json_encode($pagedata);
});

//get last selected dropdown list
$app->get('/api/lastdropdownrapporten/:id', function($id) use ($app) {
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    $data = RapportAPI::getLastDropdownFromUser($id);

    echo json_encode($data);
});

//PUT routes
$app->put('/api/courseupdate/:id', function($id) use ($app){
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    
    // Update the existing resource
    echo json_encode(RapportAPI::updateCourse(
    $id, $app->request->post('code'), $app->request->post('name'), $app->request->post('description')));
});

//POST routes
$app->post('/api/courserapport', function () use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    // Insert the data
    echo json_encode(RapportAPI::createCourse($app->request->post('code'), $app->request->post('name'), $app->request->post('description')));
});

$app->post('/api/savedropdownsRapport', function() use ($app) {
    //Use json header
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    //Insert the data
    echo json_encode(RapportAPI::saveDropdownChoice($app->request->post('course'), $app->request->post('courseid'),
        $app->request->post('module'), $app->request->post('moduleid'), $app->request->post('submodule'),
        $app->request->post('submoduleid'), $app->request->post('goal'), $app->request->post('goalid'),
        $app->request->post('user')));
});

$app->post('/api/savecompetences/:id', function($id) use ($app) {
    $app->response->headers->set('Content-Type', 'application/json');
    echo json_encode(RapportAPI::updateCourseCompetences($id, file_get_contents('php://input')));
});

// API DELETE routes
$app->delete('/api/coursedelete/:id', function ($id) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    echo json_encode(RapportAPI::deleteCourse($id));
});

?>
