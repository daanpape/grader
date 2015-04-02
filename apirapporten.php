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
        return rapportenDAO::getmoduleByCourse($id);
    }
    public static function getSubCompetenceByCompetence($id) {
        /* Return module from selected course */
        return rapportenDAO::getCoursesByTraining($id);
    }
    public static function getGoalBySubCompetence($id) {
        /* Return module from selected course */
        return rapportenDAO::getGoalsBydoelstelling($id);
    }

    public static function getTeacher($id) {
        /* get teacher from database */
        return rapportenDAO::getTeacher($id);
    }
    
    public static function getStudentListInfoFromListId($id) {
        return rapportenDAO::getStudentListInfoFromListId($id);
    }
    
    public static function getStudentsFromStudentList($id) {
        return rapportenDAO::getStudentsFromStudentList($id);
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
        return rapportenDAO::getStudentsCountFromCourse();
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
    /*
       * copy a course from the database
       */
    public static function copyCourse($id) {
        if (rapportenDAO::copyCourse($id) === true) {
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

        foreach ($data as $module) {
            // Insert a module
            $moduleid = self::putmodule(
                property_exists($module, "id") ? $module->id : -1,
                property_exists($module, "name") ? $module->name : "",
                property_exists($module, "description") ? $module->description : "",
                $courseid);
            // Insert doelstellingen if any
            if (property_exists($module, "doelstellingen")) {
                foreach ($module->doelstellingen as $doelstelling) {
                    // Insert a subcomptence
                    $doelstellingid = self::putdoelstelling(
                        property_exists($doelstelling, "id") ? $doelstelling->id : -1,
                        property_exists($doelstelling, "name") ? $doelstelling->name : "",
                        property_exists($doelstelling, "description") ? $doelstelling->description : "",
                        $moduleid);
                    // Insert criterias if any
                    if (property_exists($doelstelling, "criterias")) {
                        foreach ($doelstelling->criterias as $criteria) {
                            self::putcriteria(
                                property_exists($criteria, "id") ? $criteria->id : -1,
                                property_exists($criteria, "name") ? $criteria->name : "",
                                property_exists($criteria, "description") ? $criteria->description : "",
                                $doelstellingid);
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
            return rapportenDAO::putNewmodule($name, $description, $courseid);
        } else {
            rapportenDAO::updatemodule($id, $name, $description, $courseid);
            return $id;
        }
    }

    public static function putSubCompetence($id = -1, $name, $description, $moduleid) {
        if($id == -1){
            return rapportenDAO::putNewdoelstelling($name, $description, $moduleid);
        } else {
            // Update a doelstelling
            rapportenDAO::updatedoelstelling($id, $name, $description, $moduleid);
            return $id;
        }
    }

    public static function putIndicator($id = -1, $name, $description, $doelstelling) {
        if($id == -1){
            // Insert a new criteria
            return rapportenDAO::putNewcriteria($name, $description, $doelstelling);
        } else {
            // Update an criteria
            rapportenDAO::updatecriteria($id, $name, $description, $doelstelling);
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
