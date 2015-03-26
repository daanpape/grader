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

    public static function getStudentsFromCourse($start, $count) {
        /* Return the requested pages */
        return rapportenDAO::getStudentsFromCourse($start, $count);
    }

    public static function getAllCourse() {
        /* Return the requested pages */
        return rapportenDAO::getAllCourse();
    }

    public static function getCompetenceByCourse($id) {
        /* Return module from selected course */
        return rapportenDAO::getCompetenceByCourse($id);
    }

    public static function getSubCompetenceByCompetence($id) {
        /* Return module from selected course */
        return rapportenDAO::getCoursesByTraining($id);
    }

    public static function getGoalBySubCompetence($id) {
        /* Return module from selected course */
        return rapportenDAO::getGoalsBySubcompetence($id);
    }
    
    public static function getTeacher($id) {
        /* get teacher from database */
        return rapportenDAO::getTeacher($id);
    }
    
    public static function addTeacher($id) {
        /* Return teacher from users */
        return rapportenDAO::addTeacher($id);
    }
    
    public static function getLastDropdownFromUser($id) {
        return rapportenDAO::getLastDropdownFromUser($id);
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
    
    public static function createStudentList($name, $ownerid) {
        $id = rapportenDAO::insertStudentList($name, $ownerid);

        if ($id != null) {
            return array(
                "id" => $id,
                "name" => $name);
        } else {
            return -1;
        }
    }
    
    public static function getCourseCount() {
        return rapportenDAO::getCourseCount();
    }

    public static function getStudentsCountFromCourse() {
        return rapportenDAO::getStudentCountFromCourse();
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
    
    public static function getAllDataFromCourse($id) {
        return rapportenDAO::getAllDataFromCourse($id);
    }
    
    public static function getStudentListsFromUser($id) {
        return rapportenDAO::getStudentListsFromUser($id);
    }
    
    public static function deleteStudentList($id) {
        if(rapportenDAO::deleteStudentList($id) == true) {
            return true;
        } else {
            return false;
        }
    }

   public static function updateCourseCompetences($courseid, $courseStructure) {
        $data = json_decode($courseStructure);
        
        var_dump($data);
        
        foreach ($data as $competence) {
            // Insert a competence
            $competenceid = self::putCompetence(
                property_exists($competence, "id") ? $competence->id : -1,
                property_exists($competence, "name") ? $competence->name : "",
                property_exists($competence, "description") ? $competence->description : "",
                $courseid);

            // Insert subcompetences if any
            if (property_exists($competence, "subcompetences")) {
                foreach ($competence->subcompetences as $subcompetence) {
                    // Insert a subcomptence
                    $subcompetenceid = self::putSubCompetence(
                        property_exists($subcompetence, "id") ? $subcompetence->id : -1,
                        property_exists($subcompetence, "name") ? $subcompetence->name : "",
                        property_exists($subcompetence, "description") ? $subcompetence->description : "",
                        $competenceid);

                    // Insert indicators if any
                    if (property_exists($subcompetence, "indicators")) {
                        foreach ($subcompetence->indicators as $indicator) {
                            self::putIndicator(
                                property_exists($indicator, "id") ? $indicator->id : -1,
                                property_exists($indicator, "name") ? $indicator->name : "",
                                property_exists($indicator, "description") ? $indicator->description : "",
                                $subcompetenceid);
                        }
                    }
                }
            }
        }
        
        // Return saved data
        return self::getAllDataFromCourse($courseid);
    }

    /*
$app->request->post('module'), $app->request->post('moduleid'), $app->request->post('submodule'),
$app->request->post('submoduleid'), $app->request->post('goal'), $app->request->post('goalid'),
$app->request->post('user')));
    */

    //save dropdowns asses
    public static function saveDropdownChoice($course, $courseid, $module, $moduleid, $submodule, $submoduleid, $goal, $goalid, $user) {
        $id = rapportenDAO::saveDropdownChoice($course, $courseid, $module, $moduleid, $submodule, $submoduleid, $goal, $goalid, $user);

        if($id != false) {
            return array(
                "course" => $course,
                "module" => $module,
                "submodule" => $submodule,
                "goal" => $goal,
                "goalid" => $goalid,
                "user" => $user
            );
        } else {
            return -1;
        }
    }

    public static function putCompetence($id = -1, $name, $description, $courseid) {
        if($id == -1) {
            return rapportenDAO::putNewCompetence($name, $description, $courseid);
        } else {
            rapportenDAO::updateCompetence($id, $name, $description, $courseid);
            return $id;
        }
    }
    
    public static function putSubCompetence($id = -1, $name, $description, $competenceid) {
        if($id == -1){
            return rapportenDAO::putNewSubCompetence($name, $description, $competenceid);
        } else {
            // Update a subcompetence
            rapportenDAO::updateSubCompetence($id, $name, $description, $competenceid);
            return $id;
        }
    }
    
    public static function putIndicator($id = -1, $name, $description, $subcompetence) {
        if($id == -1){
            // Insert a new indicator
            return rapportenDAO::putNewIndicator($name, $description, $subcompetence);
        } else {
            // Update an indicator
            rapportenDAO::updateIndicator($id, $name, $description, $subcompetence);
            return $id;
        }
    }
    
    //update/edit Studenlist
    public static function updateStudentList($id, $name) {
        if(rapportenDAO::updateStudentList($id, $name)){
            return array(
                "id" => $id,
                "code" => $name);
        } else {
            return -1;
        }
    }
}
