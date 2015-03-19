<?php
/*
 * Grader API functions for rapporten 
 */

// Load required files
require_once('dptcms/databaserapporten.php');

Class RapportAPI {
    public static function getAllCourses($start, $count) {
        /* Return the requested pages */
        return rapportenDAO::getAllCourses($start, $count);
    }

    public static function getAllCourse() {
        /* Return the requested pages */
        return rapportenDAO::getAllCourse();
    }

    public static function getCompetenceByCourse($id) {
        /* Return module from selected course */
        return rapportenDAO::getCompetenceByCourse($id);
    }

    public static function createCourse($code, $name, $description) {
        $id = rapportenDAO::insertCourse($code, $name, $description);

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
    
    public static function getCourseCount() {
        return rapportenDAO::getCourseCount();
    }
    
    /*
     * Delete a course from the database
     */
    public static function deleteCourse($id) {
        if (rapportenDAO::deleteCourse($id) === true) {
            return true;
        } else {
            return false;
        }
    }
    
    /*update a course*/
    public static function updateCourse($id, $code, $name, $description) {
        if(rapportenDAO::updateCourse($id, $code, $name, $description)){
            return array(
                "id" => $id,
                "code" => $code,
                "name" => $name,
                "description" => $description);
        } else {
            return -1;
        }
    }
}
