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

$app->get('/api/coursemodule/:id/:name', function ($id, $name) use($app) {
    $app->render('templatesrapport/modulerapporten.php', array('courseid' => $id, 'coursename' => $name));
});
$app->get('/account/admin', function () use($app) {
    $app->render('templatesrapport/adminrapporten.php');
});

$app->get('/account/studentlistsrapporten', function () use($app) {
    $app->render('templatesrapport/accountstudentlistsrapporten.php');
});

$app->get('/account/studentlistsrapporten/edit/:id/:name', function($id, $name) use($app) {
    $app->render('templatesrapport/editstudentlistrapporten.php', array('studentlistid' => $id, 'studentlistname' => $name));
});

$app->get('/api/coursestudents/:id/:name', function($id, $name) use ($app) {
    $app->render('templatesrapport/coursestudentsrapporten.php', array('coursestudentsid' => $id, 'coursestudentsname' => $name));
});

$app->get('/api/studentlistrapport/info/:id', function($id) use ($app) {
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    $data = RapportAPI::getStudentListInfoFromListId($id);

    echo json_encode($data);
});

$app->get('/api/studentlistrapporten/students/:id', function($id) use($app) {
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    $data = RapportAPI::getStudentsFromStudentList($id);

    echo json_encode($data);
});

//get all courses with pages
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
//get all student form a selected course with pages
$app->get('/api/studentscourse/page/:pagenr', function ($pagenr) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    // Calculate start and count
    $pg = Pager::pageToStartStop($pagenr);
    // Get total number of projecttypes in the database
    //$pagedata = RapportAPI::getAllCourses($pg->start, $pg->stop);
    $pagedata = RapportAPI::getStudentsFromCourse($pg->start, $pg->count);
    $totalcourses = RapportAPI::getStudentsCountFromCourse();
    // Get the page
    echo json_encode(Pager::genPaginatedAnswer($pagenr, $pagedata, $totalcourses));
});
//get module from course
$app->get('/api/coursesrapport/:courseId', function ($locationId) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    // Get all trainings by locationsid
    $pagedata = RapportAPI::getmoduleByCourse($locationId);
    echo json_encode($pagedata);
});
//getdoelstelling from module
$app->get('/api/doelstellingrapport/:moduleId', function ($trainingId) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    // Get all courses by the trainingsid
    $pagedata = RapportAPI::getdoelstellingBymodule($trainingId);
    echo json_encode($pagedata);
});
//getcriterias from doelstelling
$app->get('/api/criteriarapport/:doelstellingId', function ($trainingId) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    // Get all courses by the trainingsid
    $pagedata = RapportAPI::getcriteriaBydoelstelling($trainingId);
    echo json_encode($pagedata);
});
//get all doelstellingen
$app->get('/api/coursestructure/:id', function($id) use ($app) {
    $app->response->headers->set('Content-Type', 'application/json');
    echo json_encode(RapportAPI::getAllDataFromCourse($id));
});
$app->get('/api/courserapportdrop', function () use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    // Get all courses
    $pagedata = RapportAPI::getAllCourse();
    echo json_encode($pagedata);
});
//get teacher from database
$app->get('/api/getteacherrapport', function () use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    // Get all courses by the trainingsid
    $pagedata = RapportAPI::getTeacher();
    echo json_encode($pagedata);
});
//add teacher to dropdown
$app->get('/api/teacherrapport/:id', function ($trainingId) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    // Get all courses by the trainingsid
    $pagedata = RapportAPI::addTeacher($trainingId);
    echo json_encode($pagedata);
});
//get last selected dropdown list
$app->get('/api/lastdropdownrapporten/:id', function($id) use ($app) {
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    $data = RapportAPI::getLastDropdownFromUser($id);
    echo json_encode($data);
});
$app->get('/api/studentlistsrapporten/:id', function($id) use($app) {
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    $data = RapportAPI::getStudentListsFromUser($id);
    echo json_encode($data);
});

//GET all students from a course
$app->get('/api/coursesstudents/:id', function ($Id) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    // Get all students bij the id of a course
    $pagedata = RapportAPI::getStudentFromCourseID($Id);
    echo json_encode($pagedata);
});

//get all students
$app->get('/api/allstudents', function () use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    
    $data = RapportAPI::getAllStudents();
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
        $app->request->post('student'), $app->request->post('studentid'), $app->request->post('user')));
});
$app->post('/api/savemodules/:id', function($id) use ($app) {
    $app->response->headers->set('Content-Type', 'application/json');
    echo json_encode(RapportAPI::updateCoursemodules($id, file_get_contents('php://input')));
});
$app->post('/api/addcourseteacher/:courseid', function ($courseid) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    // Insert the data
    echo json_encode(RapportAPI::addTeacherToCourse($app->request->post('teachername'), $courseid));
});
$app->post('/api/newstudentlistrapport/:userid', function ($userid) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    // Add list
    echo json_encode(RapportAPI::createStudentList($app->request->post('name'), $userid));    //null moet nog ingelogde userid worden!
});
$app->post('/api/project/:projectid/studentlist/:studlistid', function($courseid, $studlistid) use($app) {
    //Use json header
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    //Insert the data
    echo json_encode(RapportAPI::createCourseStudentlistCouple($courseid, $studlistid));
});
// API DELETE routes
$app->delete('/api/coursedelete/:id', function ($id) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    echo json_encode(RapportAPI::deleteCourse($id));
});

$app->delete('/api/studentlistdelete/:id', function($id) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    echo json_encode(RapportAPI::deleteStudentList($id));
});

$app->delete('/api/studentlistrapport/:studlistid/delete/student/:studid', function ($studlistid, $studid) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    echo json_encode(RapportAPI::deleteStudentFromStudentList($studlistid, $studid));
});

$app->put('/api/studentlistupdate/:id', function($id) use ($app){
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    // Update the existing resource
    echo json_encode(RapportAPI::updateStudentList(
        $id, $app->request->post('name')));
});

$app->put('/api/studentrapport/:id', function($id) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    // Update the existing resource
   echo json_encode(RapportAPI::updateStudent(
        $id, $app->request->post('firstname'), $app->request->post('lastname'), $app->request->post('username')));
});

$app->post('/api/coursecopy/:id', function ($id) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    echo json_encode(RapportAPI::copyCourse($id));
});

?>
