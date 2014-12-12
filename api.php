<?php

/*
 * Grader API functions 
 */

// Load required files
require_once('dptcms/database.php');

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

    public static function getProjectByCourseId($courseid, $start, $count) {
        return ClassDAO::getProjectsByCourseId($courseid, $start, $count);
    }
    
    public static function getProjectCount() {
        /* Return the number of projecttypes currently in the database */
        return ClassDAO::getAllProjectCount();
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

    /*
     * Create a new projecttype and put it in the database
     * @return -1 on error;
     */
    public static function createProject($courseid, $code, $name, $description) {
        $id = ClassDAO::insertProject($courseid, $code, $name, $description);

        if ($id != null) {
            return array(
                "id" => $id,
                "code" => $code,
                "name" => $name,
                "description" => $description);
        } else {
            return -1;
        }
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

    public static function saveDropdownChoice($location, $training, $course, $courseid, $user) {
        $id = ClassDAO::saveDropdownChoice($location, $training, $course, $courseid, $user);

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
    public static function updateProject($id, $code, $name, $description) {
        if(ClassDAO::updateProject($id, $code, $name, $description)){
            return array(
                "id" => $id,
                "code" => $code,
                "name" => $name,
                "description" => $description);
        } else {
            return -1;
        }
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
}
