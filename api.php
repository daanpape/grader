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
    
    public static function getProjectCount() {
        /* Return the number of projecttypes currently in the database */
        return ClassDAO::getAllProjectCount();
    }

    /*
     * Delete a projecttype from the database
     */
    public static function deleteProject($id) {
        if (ClassDAO::deleteProjectType($id) === true) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * Create a new projecttype and put it in the database
     * @return -1 on error;
     */
    public static function createProject($code, $name, $description) {
        $id = ClassDAO::insertProject($code, $name, $description);

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

    public static function getLocationsTrainingsAndCourses($locationId, $trainingId) {
        $result[] = array();

        $locations = ClassDAO::getAllLocations();
        $trainings = ClassDAO::getTrainingsByLocation($locationId);
        $courses = ClassDAO::getCoursesByTraining($trainingId);

        array_push($result, $locations, $trainings, $courses);

        return $result;
    }

    public static function getLocationsTrainingsAndCoursesByLocation($locationId) {
        $result[] = array();

        $locations = ClassDAO::getAllLocations();
        $trainings = ClassDAO::getTrainingsByLocation($locationId);
        $courses = ClassDAO::getCourseByTraining($trainings[1]);

        array_push($result, $locations, $trainings, $courses);

        return $result;
    }

    public static function test($locationId) {
        return ClassDAO::getTrainingsByLocation($locationId[0].'id');

    }
}
