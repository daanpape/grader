<?php
session_start();

require_once 'Slim/Slim.php';
require_once 'api.php';
require_once 'dptcms/pagination.php';
require_once 'dptcms/logger.php';
require_once 'dptcms/email.php';
require_once 'dptcms/security.php';
require_once 'dptcms/fileupload.php';

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
$app->get('/project/projectrules/:id', function($id) use ($app) {
    $app->render('projectrules.php', array('projectid' => $id));
});
$app->get('/project/:id/completeness', function ($id) use ($app) {
    $app->render('projectcompleteness.php', array('projectid' => $id));
});
$app->get('/register', function () use ($app) {
    $app->render('register.php');
});
$app->get('/assess', function() use ($app) {
    $app->render('assess.php');
});
$app->get('/assess/project/:projectid/student/:studentid/scores', function($projectid, $studentid) use ($app) {
    $app->render('assessscore.php', array('projectid' => $projectid, 'studentid' => $studentid));
});
$app->get('/assess/project/:projectid/student/:studentid/completeness', function($projectid, $studentid) use ($app) {
    $app->render('assesscompletement.php', array('projectid' => $projectid, 'studentid' => $studentid));
});
$app->get('/assess/project/:id/students', function($id) use($app) {
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

$app->get('/api/project/:id/documents', function($id) use ($app) {
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    $data = GraderAPI::getDocumentsFromProject($id);
    echo json_encode($data);
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

$app->get('/api/project/:id/students', function($id) use ($app) {
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    $pagedata = GraderAPI::getStudentListsFromProject($id);

    echo json_encode($pagedata);
});

$app->get('/api/currentuser', function() use ($app) {
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    // Get all courses by the trainingsid
    $userdata = GraderAPI::getUserData(Security::getLoggedInUsername());

    echo json_encode($userdata);
});

$app->get('/api/project/:id/coupledlists', function($id) use ($app) {
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    // Get all courses by the trainingsid
    $studentlists = GraderAPI::getCoupledListsFromProject($id);

    echo json_encode($studentlists);
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
$app->get('/api/studentlist/info/:id', function($id) use ($app) {
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    $data = GraderAPI::getStudentListInfoFromListId($id);

    echo json_encode($data);
});
$app->get('/api/lastdropdownchoice/:id', function($id) use ($app) {
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    $data = GraderAPI::getLastDropdownFromUser($id);

    echo json_encode($data);
});


$app->get('/api/studentlist/students/:id', function($id) use($app) {
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    $data = GraderAPI::getStudentsFromStudentList($id);

    echo json_encode($data);
});

$app->get('/api/projectstructure/:id', function($id) use ($app) {
    $app->response->headers->set('Content-Type', 'application/json');
    echo json_encode(GraderAPI::getAllDataFromProject($id));
});

$app->get('/api/projectrules/:id', function($id) use ($app)
{
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    echo json_encode(GraderAPI::getProjectRules($id));
});

$app->get('/api/projectscore/:projectid/:studentid', function($projectid,$studentid) use ($app)
{
    $response = $app->response();
    $response->headers('Content-Type','application/json');
    echo json_encode(GraderAPI::getScoresForStudentByUser($projectid,$studentid,Security::getLoggedInId()));
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

/**$app->put('/api/project/:projectid/studentlist/:studentlistid', function($projectid, $studentlistid) use ($app){
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    // Update the existing resource
    echo json_encode(GraderAPI::putCoupleProjectAndStudentlist($projectid, $studentlistid));
});**/

$app->put('/api/studentlist/:id', function($id) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    // Update the existing resource
    echo json_encode(GraderAPI::updateStudentListName(
        $id, $app->request->post('name')));
});

$app->put('/api/student/:id', function($id) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    // Update the existing resource
   echo json_encode(GraderAPI::updateStudent(
        $id, $app->request->post('username'), $app->request->post('firstname'), $app->request->post('lastname')));
});
$app->post('/api/newstudent/:id', function($id) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    // Update the existing resource
    echo json_encode(GraderAPI::putStudent(
        $id, $app->request->post('username'), $app->request->post('firstname'), $app->request->post('lastname')));
});

// API POST routes
$app->post('/api/project/:projectid/documents/:lastid', function($projectid, $lastid) use ($app) {
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    $documents = json_decode($_POST['documents']);
    $updateArray = array();
    $insertArray = array();


    foreach($documents as $document) {
        if($document->id <= $lastid) {
            array_push($updateArray, $document);
        } else {
            array_push($insertArray, $document);
        }
    }

    if(!empty($updateArray))
        $updates = GraderAPI::updateDocuments($updateArray);
    if(!empty($insertArray))
        $inserts = GraderAPI::insertDocuments($projectid, $insertArray);
    echo json_encode("success");
});

$app->post('/api/project/:id', function ($courseid) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    // Insert the data
    echo json_encode(GraderAPI::createProject(
                    $courseid, $app->request->post('code'), $app->request->post('name'), $app->request->post('description')));
});

$app->post('/api/student/:id', function ($listid) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    // Insert the data
    echo json_encode(GraderAPI::createStudentAndCoupleToListId(
        $listid, $app->request->post('username'), $app->request->post('firstname'), $app->request->post('lastname')));
});

$app->post('/api/project/:projectid/studentlist/:studlistid', function($projectid, $studlistid) use($app) {
    //Use json header
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    //Insert the data
    echo json_encode(GraderAPI::createProjectStudentlistCouple($projectid, $studlistid));
});

$app->post('/api/account/avatar', function() use ($app) {
    //Use json header
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    
    echo json_encode(GraderAPI::updateProfilePicture($_POST['pictureid']));
});

$app->post('/api/savedropdowns', function() use ($app) {
    //Use json header
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    //Insert the data
    echo json_encode(GraderAPI::saveDropdownChoice($app->request->post('location'), $app->request->post('locationid'), $app->request->post('training'), $app->request->post('trainingid'), $app->request->post('course'), $app->request->post('courseid'), $app->request->post('user')));
});

$app->post('/api/upload', function() use($app){
    $app->response->headers->set('Content-Type', 'application/json');
    echo json_encode(FileUpload::uploadFile());
});

$app->post('/api/projectstructure/:id', function($id) use ($app) {
    $app->response->headers->set('Content-Type', 'application/json');
    echo json_encode(GraderAPI::putProjectStructure($id, file_get_contents('php://input')));
});

$app->post('/api/projectrules/:id', function($id) use ($app)
{
    $app->response->headers->set('Content-Type', 'application/json');
    echo json_encode(GraderAPI::putProjectRules($id, file_get_contents('php://input')));
});

$app->post('api/projectscore/:projectid/:studentid', function($projectid,$studentid) use ($app)
{
    $response = $app->response();
    $response->headers('Content-Type','application/json');
    echo json_encode(/*GraderAPI::getScoresForStudentByUser($projectid,$studentid,*/"Test");//));
});

$app->post('/api/projectrules/:id/remove', function($id) use ($app)
{
    $app->response->headers->set('Content-Type', 'application/json');
    echo json_encode(GraderAPI::removeProjectRule(file_get_contents('php://input')));
});

$app->post('/api/csv/studentlist', function() use ($app) {
    $app->response->headers->set('Content-Type', 'application/json');
    
    //TODO: parse CSV 
    echo json_encode(CSVParser::parseCSV($_POST['fileid']));
});

// API DELETE routes
$app->delete('/api/project/:id', function ($id) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    echo json_encode(GraderAPI::deleteProject($id));
});

$app->delete('/api/studentlist/:studlistid/delete/student/:studid', function ($studlistid, $studid) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    echo json_encode(GraderAPI::deleteStudentFromStudentList($studlistid, $studid));
});

$app->delete('/api/studentlist/delete/:id', function($id) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    echo json_encode(GraderAPI::deleteStudentList($id));
});

$app->delete('/api/delete/document/:id', function($id) use ($app) {
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    echo json_encode(GraderAPI::deleteDocumentTypeFromProject($id));
});

$app->delete('/api/project/:projectid/studentlist/uncouple/:studentlistid', function($projectid, $studentlistid) use ($app) {
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    echo json_encode(GraderAPI::uncoupleProjectStudentlist($projectid, $studentlistid));
});


/* Rapporten routering */
require_once 'indexrapporten.php';

/* Admin router */
require_once 'admin.php';


/* Run the application */
$app->run();