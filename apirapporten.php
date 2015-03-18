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
    
    public static function createCourse($code, $name, $description) {
        $id = rapportenDAO::insertCourse($code, $name, $description);

        //if ($id != null) {
            return array(
                "id" => $id,
                "code" => $code,
                "name" => $name,
                "description" => $description);
        //} else {
        //    return -1;
        //}
    }
    
}
