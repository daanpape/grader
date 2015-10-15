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

$app->get('/worksheetrapporten', function () use ($app) {
    $app->render('templatesrapport/worksheetrapporten.php');
});

$app->get('/studentmanagementrapporten', function () use ($app) {
    $app->render('templatesrapport/studentmanagementrapporten.php');
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

$app->get('/api/worksheet/:id/:name/:courseid', function($id, $name, $courseid) use ($app) {
    $app->render('templatesrapport/worksheetpropertiesrapporten.php', array('sheetid' => $id, 'sheetname' => $name, 'courseid' => $courseid, 'edit' => false));
});

$app->get('/api/worksheetedit/:id/:name/:courseid', function($id, $name, $courseid) use ($app) {
    $app->render('templatesrapport/worksheetpropertiesrapporten.php', array('sheetid' => $id, 'sheetname' => $name, 'courseid' => $courseid, 'edit' => true));
});

$app->get('/api/worksheetassess/:worksheetid/:worksheetname/:courseid/:userid', function($workid, $workname, $courseid, $userid) use ($app) {
    $app->render('templatesrapport/worksheetassess.php', array('workid' => $workid, 'workname' => $workname, 'courseid' => $courseid, 'userid' => $userid));
});

$app->get('/api/adminUsersCourse', function () use($app) {
    $app->render('templatesrapport/studentcoursesrapport.php');
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
    // Get total number of courses in the database
    $pagedata = RapportAPI::getAllCourses($pg->start, $pg->count);
    $totalcourses = RapportAPI::getCourseCount();
    // Get the page
    echo json_encode(Pager::genPaginatedAnswer($pagenr, $pagedata, $totalcourses));
});
$app->get('/api/worksheets/page/:pagenr/:courseid', function ($pagenr, $courseid) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    // Calculate start and count
    $pg = Pager::pageToStartStop($pagenr);
    $pagedata = RapportAPI::getAllWorksheets($courseid, $pg->start, $pg->count);
    $totalWorksheets = RapportAPI::getWorksheetCount();
    // Get the page
    echo json_encode(Pager::genPaginatedAnswer($pagenr, $pagedata, $totalWorksheets));
});
$app->get('/api/worksheets/:courseid', function ($courseid) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    $data = RapportAPI::getAllWorksheetsNoPager($courseid);
    echo json_encode($data);
});
$app->get('/api/worksheetdata/:wid', function ($wid) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    $data = RapportAPI::getWorksheetData($wid);
    echo json_encode($data);
});
//get all student form a selected course with pages
$app->get('/api/studentscourse/page/:pagenr', function ($pagenr) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    // Calculate start and count
    $pg = Pager::pageToStartStop($pagenr);
    $pagedata = RapportAPI::getStudentsFromCourse($pg->start, $pg->count);
    $totalstudents = RapportAPI::getStudentsCountFromCourse();
 //Get the page
  echo json_encode(Pager::genPaginatedAnswer($pagenr, $pagedata, $totalstudents));
});
//get all combination teacher and studentlist with pages
$app->get('/api/getStudentGroupTeacherByCourseID/page/:pagenr/:course', function ($pagenr, $course) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    // Calculate start and count
    $pg = Pager::pageToStartStop($pagenr);
    $pagedata = RapportAPI::getStudentGroupTeacherByCourseID($pg->start, $pg->count, $course);
    $totalstudents = RapportAPI::getStudentGroupTeacherByCourseCount($course);
    // Get the page
    echo json_encode(Pager::genPaginatedAnswer($pagenr, $pagedata, $totalstudents));
});
//get all worksheets from a specific user and course
$app->get('/api/getWorkficheCourseUser/page/:pagenr/:user/:course', function ($pagenr, $userid, $course) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    // Calculate start and count
    $pg = Pager::pageToStartStop($pagenr);
    $pagedata = RapportAPI::getWorkficheCourseUser($pg->start, $pg->count, $userid, $course);
    $totalworksheets = RapportAPI::getWorkficheCourseUserCount($userid, $course);
    // Get the page
    echo json_encode(Pager::genPaginatedAnswer($pagenr, $pagedata, $totalworksheets));
});
//get module from course
$app->get('/api/coursesrapport/:courseId', function ($courseid) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    // Get all modules by course
    $pagedata = RapportAPI::getmoduleByCourse($courseid);
    echo json_encode($pagedata);
});
//getdoelstelling from module
$app->get('/api/doelstellingrapport/:moduleId', function ($moduleid) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    // Get all competences by module
    $pagedata = RapportAPI::getdoelstellingBymodule($moduleid);
    echo json_encode($pagedata);
});
//getcriterias from doelstelling
$app->get('/api/criteriarapport/:doelstellingId', function ($compid) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    // Get all criteria by competence
    $pagedata = RapportAPI::getcriteriaBydoelstelling($compid);
    echo json_encode($pagedata);
});
//get all modules
$app->get('/api/coursestructure/:id', function($id) use ($app) {
    $app->response->headers->set('Content-Type', 'application/json');
    echo json_encode(RapportAPI::getAllDataFromCourse($id));
});
$app->get('/api/coursedrop', function () use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    // Get all courses
    $pagedata = RapportAPI::getAllCourse();
    echo json_encode($pagedata);
});
$app->get('/api/coursefromteacher/:userid', function ($userid) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    // Get all courses
    $pagedata = RapportAPI::getAllCourseFromTeacher($userid);
    echo json_encode($pagedata);
});
//get teacher from database
$app->get('/api/getteacherrapport', function () use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    // Get all teachers
    $pagedata = RapportAPI::getTeacher();
    echo json_encode($pagedata);
});
//add teacher to dropdown
$app->get('/api/teacherrapport/:id', function ($courseid) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    $pagedata = RapportAPI::addTeacher($courseid);
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
$app->get('/api/studentdrop/:id', function ($id) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    // Get all students by courseid
    $pagedata = RapportAPI::getStudentsFromStudentList($id);
    echo json_encode($pagedata);
});

//GET all studentlists from a course
$app->get('/api/studentlistdrop/:cid/:uid', function ($cid, $uid) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    // Get all studentlists by courseid
    $pagedata = RapportAPI::getStudentlistFromCourseID($cid, $uid);
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


/*
 *
 * Momenteel niet langer gebruikt!
 *
 *
//get teacher ID with coursename
$app->get('/api/teacherID/:firstname/:lastname', function($firstname, $lastname) use($app) {
    //Use json header
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    $data = RapportAPI::getIDFromTeacherByName($firstname, $lastname);
    echo json_encode($data);
});
*/

/*
 *
 * Momenteel niet langer gebruikt!
 *
 *
//get StudentlistID from a specific owner with the name of the list.
$app->get('/api/studID/:id/:name', function($id, $name) use($app) {
    //Use json header
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    $data = RapportAPI::getIDFromStudentlistByName($id, $name);
    echo json_encode($data);
});
*/

//PUT routes
$app->put('/api/courseupdate/:id', function($id) use ($app){
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    // Update the existing course
    echo json_encode(RapportAPI::updateCourse(
        $id, $app->request->post('code'), $app->request->post('name'), $app->request->post('description')));
});
$app->put('/api/updateworksheet/:id', function($id) use ($app){
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    // Update the existing worksheet
    echo json_encode(RapportAPI::updateWorksheet($id, $app->request->post('name')));
});
$app->put('/api/worksheetproperties/:id/:assess', function($id, $assess) use ($app){
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    // Update the existing worksheetproperties
    echo json_encode(RapportAPI::updateWorksheetProperties($id, $app->request->post('equipment'), $app->request->post('method'), $assess));
});

$app->post('/api/assessworksheet/:wid/:userid', function($wid, $userid) use ($app){
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    echo json_encode(RapportAPI::assessWorksheet($wid, $userid, $app->request->post('date'), $app->request->post('sheetscore'), 
            $app->request->post('modscores'), $app->request->post('compscores'), $app->request->post('critscores')));
});
//POST routes
$app->post('/api/courserapport', function () use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    // Insert the data
    echo json_encode(RapportAPI::createCourse($app->request->post('code'), $app->request->post('name'), $app->request->post('description')));
});
$app->post('/api/addworksheet/:courseid', function ($courseid) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    // Insert the data
    echo json_encode(RapportAPI::addWorksheetToCourse($app->request->post('name'), $courseid));
});
$app->post('/api/savedropdownsRapport', function() use ($app) {
    //Use json header
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    //Insert the data
    echo json_encode(RapportAPI::saveDropdownChoice($app->request->post('user'), $app->request->post('course'), $app->request->post('courseid'),
        $app->request->post('studentlist'), $app->request->post('studentlistid'), $app->request->post('student'), $app->request->post('studentid')));
});
$app->post('/api/savedropdownsRapportWorksheet', function() use ($app) {
    //Use json header
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    //Insert the data
    echo json_encode(RapportAPI::saveDropdownChoiceWorksheet($app->request->post('user'), $app->request->post('course'), $app->request->post('courseid')));
});
$app->post('/api/savemodules/:id', function($id) use ($app) {
    $app->response->headers->set('Content-Type', 'application/json');
    echo json_encode(RapportAPI::updateCoursemodules($id, file_get_contents('php://input')));
});

$app->delete('/api/removecriteria/:id', function($id) use ($app) {
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    echo json_encode(RapportAPI::removeCriteriaFromDatabase($id));
});

$app->delete('/api/removedoelstelling/:id', function($id) use ($app) {
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    echo json_encode(RapportAPI::removeDoelstellingFromDatabase($id));
});

$app->delete('/api/removemodule/:id', function($id) use ($app) {
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    echo json_encode(RapportAPI::removeModuleFromDatabase($id));
});


$app->post('/api/newstudentlistrapport/:userid', function ($userid) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    // Add list
    echo json_encode(RapportAPI::createStudentList($app->request->post('name'), $userid));
});
$app->post('/api/coursecouple/:courseid/:studlistid/:teacherid', function($courseid, $studlistid, $teacherid) use($app) {
    //Use json header
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    //Insert the data
    echo json_encode(RapportAPI::createCourseStudentlistCouple($courseid, $studlistid, $teacherid));
});
$app->post('/api/worksheetstudentcouple', function() use($app) {
    //Use json header
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    //Insert the data
    echo json_encode(RapportAPI::createWorksheetStudentCouple($app->request->post('worksheetid'), $app->request->post('studid')));
});
$app->post('/api/worksheetstudentListcouple', function() use($app) {
    //Use json header
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    //Insert the data
    echo json_encode(RapportAPI::createWorksheetStudentListCouple($app->request->post('worksheetid'), $app->request->post('studlistid')));
});
$app->post('/api/newstudent', function() use($app) {
    //Use json header
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    //Insert the data
    echo json_encode(RapportAPI::addStudentToList($app->request->post('name'), $app->request->post('list')));
});
$app->post('/api/worksheetmodules', function() use($app) {
    //Use json header
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    //Insert the data
    echo json_encode(RapportAPI::addWorksheetModules($app->request->post('id'), $app->request->post('modules'), 
            $app->request->post('competences'), $app->request->post('criteria')));
});
// API DELETE routes
$app->delete('/api/coursedelete/:id', function ($id) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    echo json_encode(RapportAPI::deleteCourse($id));
});

$app->delete('/api/deleteworksheet/:id', function ($id) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    echo json_encode(RapportAPI::deleteWorksheet($id));
});

$app->delete('/api/deleteworksheetfromuser/:id/:userid', function ($id, $userid) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    echo json_encode(RapportAPI::deleteWorksheetFromUser($id, $userid));
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

//set link course - teacher - studlist inactive
$app->delete('/api/setInactiveCourseStudlistCouple/:course/:studentlist/:teacher', function ($course, $studentlist, $teacher) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');
    echo json_encode(RapportAPI::setInactiveCourseStudlistCouple($course, $studentlist, $teacher));
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
