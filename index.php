<?php
session_start();

require_once 'Slim/Slim.php';
require_once 'api.php';
require_once 'dptcms/pagination.php';
require_once 'dptcms/logger.php';
require_once 'dptcms/email.php';
require_once 'dptcms/security.php';

\Slim\Slim::registerAutoloader();

/* Instatiate application */
$app = new \Slim\Slim(array(
    'cookies.encrypt' => true
        ));
$app->setName('Grader');

/* Add security middleware */
class DPTSecurityMiddleware extends \Slim\Middleware
{
    /* 
     * This function is called by the slim application for all requests
     */
    public function call()
    {
        // Get the reference to the application
        $app = $this->app;

        // Get the application request without trailing slashes 
        $requesturi = ltrim($app->request->getPathInfo(), '/');

        if($requesturi != 'unauthorized') {
            // Check if the user is authorized to execute this request
            if(!Security::isUserAuthorized($requesturi)) {
                $app->redirect('/unauthorized');
            }
        }

        // Run the inner middleware and application
        $this->next->call();
    }
}
$app->add(new DPTSecurityMiddleware());

// GET routes
$app->get('/', function () use ($app) {
    $app->render('home.php');
});
$app->get('/home', function () use ($app) {
    $app->render('home.php');
});
$app->get('/projects', function () use ($app) {
    $app->render('projects.php');
});
$app->get('/project/:id', function ($id) use($app) {
    $app->render('project.php', array('projectid' => $id));
});
$app->get('/project/students/:id', function($id) use ($app) {
   $app->render('projectstudents.php', array('projectid' => $id));
});
$app->get('/register', function () use ($app) {
    $app->render('register.php');
});
$app->get('/assess', function() use ($app) {
    $app->render('assess.php');
});
$app->get('/assess/project/:id', function($id) use($app) {
   $app->render('assessproject.php', array('projectid' => $id));
});
$app->get('/account', function() use ($app) {
    $app->render('account.php');
});
$app->get('/account/studentlists', function() use ($app) {
    $app->render('accountstudentlists.php');
});
$app->get('/account/studentlist/edit/:id', function($id) use($app) {
    $app->render('editstudentlist.php', array('studentlistid' =>$id));
});
$app->get('/unauthorized', function() use ($app) {
    $app->render('unauthorized.php');
});
$app->get('/activate/:token', function ($token) use ($app) { 
    // Try to activate user 
    $status = Security::activateUser($token);
    $app->render('activate.php', array('status' => $status));
});
$app->get('/logout', function() use ($app) {
    Security::logoutUser();
});

// POST routes
$app->post('/login/:email', function ($email) use($app) {	
    $app->response->headers->set('Content-Type', 'application/json');

    // Try to login the user 
    $response = Security::loginUser($email, $_POST['password']);
    if($response !== true){
        // Login failed
        $app->response->setStatus(401);

        // Send error message
        echo json_encode(array('error' => $response));
    } else {
        // Login success
        echo '{}';
    }
});

$app->post('/checkemail', function() use($app) {
    $app->response->headers->set('Content-Type', 'application/json');

    // Check if the email address is unique
    $unique = Security::isEmailUnique($_POST['email']);
    echo json_encode(array('valid' => $unique));
});

$app->post('/register', function() use($app){
    // Try to register the user
    if(!Security::registerUser($_POST['lang'], $_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['email'], $_POST['pass'], $_POST['passconfirm'])) {
        // Registration failed, bad request
        $app->response->setStatus(400);
    }
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

$app->get('/api/projects/:courseid/page/:pagenr', function ($courseid, $pagenr) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    // Calculate start and count
    $pg = Pager::pageToStartStop($pagenr);

    // Get total number of projecttypes in the database
    $pagedata = GraderAPI::getProjectByCourseId($courseid, $pg->start, $pg->count);
    $totalprojects = GraderAPI::getProjectCountByCourseId($courseid);

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

$app->get('/api/courses/:locationId/:trainingId', function($locationId, $trainingId) use ($app) {
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    // Get all courses by the trainingsid
    $pagedata = GraderAPI::getLocationsTrainingsAndCourses($locationId, $trainingId);

    echo json_encode($pagedata);
});

$app->get('/api/project/:id', function($id) use ($app){
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    // Get all courses by the trainingsid
    $pagedata = GraderAPI::getProjectById($id);

    echo json_encode($pagedata);
});

$app->get('/api/currentuser', function() use ($app) {
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    // Get all courses by the trainingsid
    $userdata = GraderAPI::getUserData(Security::getLoggedInUsername());

    echo json_encode($userdata);
});

$app->get('/api/project/getAllData/:id', function($id) use($app) {
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    $allData = GraderAPI::getAllDataFromProject($id);

    echo json_encode($allData);

});

$app->get('/api/studentlists/:id', function($id) use($app) {
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    $data = GraderAPI::getStudentListsFromUser($id);

    echo json_encode($data);
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
$app->post('/api/project/:id', function ($courseid) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    // Insert the data
    echo json_encode(GraderAPI::createProject(
                    $courseid, $app->request->post('code'), $app->request->post('name'), $app->request->post('description')));
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
