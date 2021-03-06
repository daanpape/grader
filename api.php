<?php

/*
 * Grader API functions 
 */

// Load required files
require_once('dptcms/database.php');
require_once('grading_engine/gradingengine.php');

// Database class for connection handling
class GraderAPI {
    /*
     * Get a page from currently stored projecttypes. 
     * @start: the item start with
     * @count: the number of items on the page 
     */
    public static function getProjects($start, $count) {
        /* Return the requested pages */
        return ClassDAO::getAllProjects($start, $count);
    }

    public static function saveDocumentsForProject($project,$data)
    {
        return ClassDAO::saveProjectDocuments($project,$data);
    }

    public static function getProjectByCourseId($courseid, $start, $count) {
        return ClassDAO::getProjectsByCourseId($courseid, $start, $count);
    }
    
    public static function getProjectCount() {
        /* Return the number of projecttypes currently in the database */
        return ClassDAO::getAllProjectCount();
    }

    public static function getStudentListWithNrOfAssessed($pid)
    {
        return UserDAO::getStudentListWithNrOfAssessed($pid);
    }

    public static function getNrOfAssessingFromProject($pid)
    {
        return ClassDAO::getNrOfAssessingFromProject($pid);
    }

    public static function getProjectCountByCourseId($courseid) {
        return ClassDAO::getProjectCountByCourseId($courseid);
    }

    public static function getProjectById($id) {
        return ClassDAO::getProjectById($id);
    }

    public static function getAllDataFromProject($id) {
        return ClassDAO::getAllDataFromProject($id);
    }

    public static function getStudentListsFromUser($id)
    {
        return ClassDAO::getStudentListsFromUser($id);
    }
    public static function getLastDropdownFromUser($id) {
        return ClassDAO::getLastDropdownFromUser($id);
    }

    public static function getStudentListsFromProject($id) {
        return ClassDAO::getStudentListsFromProject($id);
    }
    public static function getDocumentsFromProject($id) {
        return ClassDAO::getDocumentsFromProject($id);
    }
    public static function getCoupledListsFromProject($id) {
        return ClassDAO::getCoupledListsFromProject($id);
    }
    public static function getProjectRules($id)
    {
        return ClassDAO::getProjectRules($id);
    }

    public static function removeProjectRule($id)
    {
        return ClassDAO::removeProjectRule($id);
    }

    public static function getScoresForStudentByUser($projectid,$studentid,$userid)
    {
        return ClassDAO::getScoresForStudentByUser($projectid,$studentid,$userid);
    }

    public static function removeUser($userid)
    {
        return UserDAO::removeUser($userid);
    }

    public static function gradeProjectForStudent($projectid, $userid)
    {
        return GradingEngine::gradeProjectForStudent(ClassDAO::getAllDataFromProject($projectid),ClassDAO::getAllScoresForStudentByProject($projectid,$userid),
            ClassDAO::getProjectRules($projectid), ClassDAO::getAllDocumentData($projectid,$userid), ClassDAO::getUserDocumentData($projectid,$userid));
    }

    public static function getUserDataForDocument($projectid, $userid)
    {
        return ClassDAO::getUserDataForDocument($projectid, $userid);
    }

    public static function saveDocumentsForUser($projectid, $studentid, $structure)
    {
        return ClassDAO::saveDocumentsForUser($projectid, $studentid, $structure);
    }

    public static function getUsersAssessStudent($projectid,$userid)
    {
        return ClassDAO::getUsersAssessStudent($projectid,$userid);
    }

    public static function getNrOfAssessing($projectid)
    {
        return ClassDAO::getNrOfAssessing($projectid);
    }

    public static function getDocumentScoreForStudent($projectid,$studentid)
    {
        return ClassDAO::getDocumentScoreForStudent($projectid,$studentid);
    }

    /*
     * Delete a projecttype from the database
     */
    public static function deleteProject($id) {
        if (ClassDAO::deleteProject($id) === true) {
            return true;
        } else {
            return false;
        }
    }

    public static function uncoupleProjectStudentlist($projectid, $studentlistid) {
        if (ClassDAO::uncoupleProjectStudentlist($projectid, $studentlistid) === true) {
            return true;
        } else {
            return false;
        }
    }

    public static function deleteStudentFromStudentList($studlistid, $studid) {
        if(ClassDao::deleteStudentFromStudentList($studlistid, $studid) == true) {
            return true;
        } else {
            return false;
        }
    }

    public static function deleteStudentList($id) {
        if(ClassDao::deleteStudentList($id) == true) {
            return true;
        } else {
            return false;
        }
    }

    public static function deleteDocumentTypeFromProject($id) {
        if(ClassDao::deleteDocumentType($id) == true) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * Create a new projecttype and put it in the database
     * @return -1 on error;
     */
    public static function createProject($courseid, $code, $name, $description,$nrOfAssessing,$projectPercent,$documentPercent) {
        $id = ClassDAO::insertProject($courseid, $code, $name, $description,$nrOfAssessing,$projectPercent,$documentPercent);

        if ($id != null) {
            return array(
                "id" => $id,
                "code" => $code,
                "name" => $name,
                "description" => $description,
                "nrOfAssessing" => $nrOfAssessing,
                "projectPercent" => $projectPercent,
                "documentPercent" => $documentPercent);
        } else {
            return -1;
        }
    }

    public static function putStudent($id, $mail, $firstname, $lastname) {
        $studentid = ClassDAO::putStudent($mail, $firstname, $lastname);
        $listid = ClassDAO::putStudentlist_Student($studentid, $id);
        if ($listid != -1) {
            return array(
                "id" => $studentid,
                "username" => $mail,
                "firstname" => $firstname,
                "lastname" => $lastname);
        } else {
            return -1;
        }
    }

    public static function createStudentAndCoupleToListId($listid, $mail, $firstname, $lastname) {
        $studentid = ClassDao::insertStudent($mail, $firstname, $lastname);
        $listid2 = ClassDao::insertStudentlist_Student($studentid, $listid);

    }

    public static function createProjectStudentlistCouple($projectid, $studlistid) {
        $id = ClassDAO::insertProjectStudlistCouple($projectid, $studlistid);

        if($id != null) {
            return array(
                "projectid" => $projectid,
                "studentlistid" => $studlistid
            );
        } else {
            return -1;
        }
    }

    public static function saveDropdownChoice($location, $locationid, $training, $trainingid, $course, $courseid, $user) {
        $id = ClassDAO::saveDropdownChoice($location, $locationid, $training, $trainingid, $course, $courseid, $user);

        if($id != false) {
            return array(
                "location" => $location,
                "training" => $training,
                "course" => $course,
                "courseid" => $courseid,
                "user" => $user
            );
        } else {
            return -1;
        }
    }

    /*
     * Update a projecttype in the database
     */
    public static function updateProject($id, $code, $name, $description,$nrOfAssessing,$documentPercent, $projectPercent) {
        if(ClassDAO::updateProject($id, $code, $name, $description,$nrOfAssessing, $documentPercent, $projectPercent)){
            return array(
                "id" => $id,
                "code" => $code,
                "name" => $name,
                "description" => $description,
                "nrOfAssessing" => $nrOfAssessing,
                "documentPercent" => $documentPercent,
                "projectPercent" => $projectPercent);
        } else {
            return -1;
        }
    }

    public static function updateStudentListName($id, $name) {
        if(ClassDAO::updateStudentListName($id, $name)) {
            return array(
                "id" => $id,
                "name" => $name
            );
        } else {
            return -1;
        }
    }

    public static function updateStudent($id, $username, $firstname, $lastname) {
        if(ClassDAO::updateStudent($id, $username, $firstname, $lastname)) {
            return array(
                "id" => $id,
                "mail" => $username,
                "firstname" => $firstname,
                "lastname" => $lastname
            );
        } else {
            return -1;
        }
    }

    public static function Documents($array) {
        if(ClassDAO::updateDocuments($array)) {
            return $array;
        } else {
            return -1;
        }
    }

    public static function insertDocuments($projectid, $array) {
        if(ClassDAO::insertDocuments($projectid, $array)) {
            return $array;
        } else {
            return -1;
        }
    }

    public static function updateProfilePicture($pictureid) {
        $userid = Security::getLoggedInId();
        return UserDAO::updateUserProfilePicture($userid, $pictureid);
    }

    public static function getLoggedInId() {
        return Security::getLoggedInId();

    }

    /*
     * Get all courses from database
     */
    public static function getLocations() {
    /* Return the requested pages */
    return ClassDAO::getAllLocations();
}

    public static function getTrainingsByLocation($id) {
        return ClassDAO::getTrainingsByLocation($id);
    }

    public static function getCoursesByTraining($id) {
        return ClassDAO::getCoursesByTraining($id);
    }

    public static function getStudentListInfoFromListId($id) {
        return ClassDAO::getStudentListInfoFromListId($id);
    }

    public static function getStudentsFromStudentList($id) {
        return ClassDAO::getStudentsFromStudentList($id);
    }

    public static function putProjectRules($id,$projectrules)
    {
        return ClassDAO::saveProjectRules($id,$projectrules);
    }

    public static function saveScoresForStudentByUser($projectid,$studentid,$userid, $scores)
    {
        return ClassDAO::saveScoresForStudentByUser($projectid,$studentid,$userid, $scores);
    }

    public static function getLocationsTrainingsAndCourses($locationId, $trainingId) {
        $result[] = array();

        $locations = ClassDAO::getAllLocations();
        $trainings = ClassDAO::getTrainingsByLocation($locationId);
        $courses = ClassDAO::getCoursesByTraining($trainingId);

        array_push($result, $locations, $trainings, $courses);

        return $result;
    }

    /*
     * Get user information given a username
     */
    public static function getUserData($username) {
        return UserDAO::getUserByUsername($username, true);
    }

    /*
     * Get user information given a id
     */
    public static function getEditUserDataById($uid) {
        return UserDAO::getEditUserById($uid);
    }

    /*
     * Get all users
     */
    public static function getAllUsersData() {
        return UserDAO::getAllUsers();
    }

    /*
     * Get all users with roles
     */
    public static function getAllUsersWithRolesData() {
        return UserDAO::getAllUsersWithRoles();
    }


    /*
     * Update user status
     */
    public static function updateUserStatus($uid, $status) {
        return UserDAO::updateUserStatus($uid, $status);
    }

    /*
     * Update user
     */
    public static function updateUser($id, $firstname, $lastname, $username, $status) {
        return UserDAO::updateUser($id, $firstname, $lastname, $username, $status);
    }

    /*
     * remove user roles
     */
    public static function removeUserRoles($id) {
        return UserDAO::removeUserRoles($id);
    }

    /*
     * get user  by id
     */
    public static function getUserRolesById($id) {
        return UserDAO::getUserRolesById($id);
    }

    /*
     * Add user role
     */
    public static function addUserRole($id, $role) {
        return UserDAO::addUserRole($id, $role);
    }


    /**
     * Put a project structure into the database.
     * @param type $projectid the projectid to save the structure for.
     * @param type $projectStructure the JSON data containing the project structure.
     */
    public static function putProjectStructure($projectid, $projectStructure) {
        $data = json_decode($projectStructure);
        
        foreach ($data as $competence) {
            // Insert a competence
            $competenceid = self::putCompetence(
                property_exists($competence, "code") ? $competence->code : "",
                property_exists($competence, "name") ? $competence->name : "",
                property_exists($competence, "max") ? $competence->max : 20,
                property_exists($competence, "weight") ? $competence->weight : 100,
                $projectid,
                property_exists($competence, "id") ? $competence->id : -1);

            // Insert subcompetences if any
            if (property_exists($competence, "subcompetences")) {
                foreach ($competence->subcompetences as $subcompetence) {
                    // Insert a subcomptence
                    $subcompetenceid = self::putSubCompetence(
                        property_exists($subcompetence, "code") ? $subcompetence->code : "",
                        property_exists($subcompetence, "name") ? $subcompetence->name : "",
                        property_exists($subcompetence, "weight") ? $subcompetence->weight : 100,
                        property_exists($subcompetence, "max") ? $subcompetence->max : 20,
                        property_exists($subcompetence, "min_required") ? $subcompetence->min_required : 10,
                        $competenceid,
                        property_exists($subcompetence, "id") ? $subcompetence->id : -1);

                    // Insert indicators if any
                    if (property_exists($subcompetence, "indicators")) {
                        foreach ($subcompetence->indicators as $indicator) {
                            self::putIndicator(
                                property_exists($indicator, "name") ? $indicator->name : "",
                                property_exists($indicator, "description") ? $indicator->description : "",
                                property_exists($indicator, "max") ? $indicator->max : 20,
                                property_exists($indicator, "weight") ? $indicator->weight : 100,
                                $subcompetenceid,
                                property_exists($indicator, "id") ? $indicator->id : -1,
                                property_exists($indicator, "pointType") ? $indicator->pointType : "");
                        }

                    }
                }
            }
        }
        
        // Return saved data
        return self::getAllDataFromProject($projectid);
    }

    public static function putCompetence($code, $description, $max, $weight, $project, $id = -1) {
        if($id == -1) {
            return ClassDAO::putNewCompetence($code, $description, $max, $weight, $project);
        } else {
            ClassDAO::updateCompetence($id, $code, $description, $max, $weight, $project);
            return $id;
        }
    }
    
    public static function putSubCompetence($code, $description, $weight, $max, $min_required, $competence, $id = -1) {
        if($id == -1){
            return ClassDAO::putNewSubCompetence($code, $description, $max, $weight, $min_required, $competence);
        } else {
            // Update a subcompetence
            ClassDAO::updateSubCompetence($id, $code, $description, $max, $weight, $min_required, $competence);
            return $id;
        }
    }
    
    public static function putIndicator($name, $description, $max, $weight, $subcompetence, $id = -1,$pointType) {
        if($id == -1){
            // Insert a new indicator
            return ClassDAO::putNewIndicator($name, $description, $max, $weight, $subcompetence,$pointType);
        } else {
            // Update an indicator
            ClassDAO::updateIndicator($id, $name, $description, $max, $weight, $subcompetence,$pointType);
            return $id;
        }
    }
    
    public static function addProjectDocumentType($projectId, $description, $amount_required, $weight)
    {
        try
        {
            ClassDAO::addProjectDocumentType($projectId, $description, $amount_required, $weight);
            return array('success' => true);
        }
        catch (\Exception $ex)
        {
            return array(
                'success'   => false,
                'error'     => $ex->getMessage()
            );
        }
    }
    

    public static function deleteProjectIndicator($id)
    {
        if(!is_numeric($id))
        {
            return array(
                'success'   => false,
                'error'     => 'The supplied ID argument must be numeric'
            );
        }
        try
        {
            ClassDAO::deleteProjectIndicator($id);
            return array('success' => true);
        }
        catch (\Exception $ex)
        {
            return array(
                'success'   => false,
                'error'     => $ex->getMessage()
            );
        }
    }
    
    public static function deleteProjectSubCompentence($id)
    {
        if(!is_numeric($id))
        {
            return array(
                'success'   => false,
                'error'     => 'The supplied ID argument must be numeric'
            );
        }
        try
        {
            ClassDAO::deleteProjectSubCompetence($id);
            return array('success' => true);
        }
        catch (\Exception $ex)
        {
            return array(
                'success'   => false,
                'error'     => $ex->getMessage()
            );
        }
    }
    
    public static function deleteProjectCompetence($id)
    {
        if(!is_numeric($id))
        {
            return array(
                'success'   => false,
                'error'     => 'The supplied ID argument must be numeric'
            );
        }
        try
        {
            ClassDAO::deleteProjectCompetence($id);
            return array('success' => true);
        }
        catch (\Exception $ex)
        {
            return array(
                'success'   => false,
                'error'     => $ex->getMessage()
            );
        }
    }
}
