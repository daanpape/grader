<?php
/*
 * Grader API functions for rapporten 
 */
// Load required files
require_once('dptcms/databaserapporten.php');
Class RapportAPI {
    public static function getAllCourses($start, $count) {
        return rapportenDAO::getAllCourses($start, $count);
    }
    
    public static function getStudentsFromCourse($start, $count) {
        return rapportenDAO::getStudentsFromCourse($start, $count);
    }
    
    public static function getAllCourse() {
        return rapportenDAO::getAllCourse();
    }
    
    public static function getAllCourseFromTeacher($userid) {
        return rapportenDAO::getAllCourseFromTeacher($userid);
    }
    
    public static function getAllStudents() {
        return rapportenDAO::getAllStudents();
    }
    
    public static function getmoduleByCourse($id) {
        return rapportenDAO::getmoduleByCourse($id);
    }
    
    public static function getdoelstellingBymodule($id) {
        return rapportenDAO::getCoursesByTraining($id);
    }
    
    public static function getcriteriaBydoelstelling($id) {
        return rapportenDAO::getcriteriasBydoelstelling($id);
    }
    
    public static function addWorksheetToCourse($name, $courseid) {      
        $id = rapportenDAO::addWorksheetToCourse($name, $courseid);
        if ($id != null) {
            return array(
                "id" => $id,
                "name" => $name,
                "course" => $courseid);
        } else {
            return -1;
        }
    }
    
    public static function getAllWorksheets($courseid, $start, $count) {
        return rapportenDAO::getAllWorksheets($courseid, $start, $count);
    }

    public static function getAllWorksheetsNoPager($courseid) {
        return rapportenDAO::getAllWorksheetsNoPager($courseid);
    }
    
    public static function getWorksheetCount() {
        return rapportenDAO::getWorksheetCount();
    }
    
    public static function getWorksheetData($wid) {
        return rapportenDAO::getWorksheetData($wid);
    }
    
    public static function addWorksheetModules($id, $modules, $competences, $criteria) {
        foreach($modules as $mod) {
            rapportenDAO::insertWorksheetModule($id, $mod);
        }
        foreach($competences as $comp) {
            rapportenDAO::insertWorksheetCompetence($id, $comp);
        }
        foreach($criteria as $crit) {
            rapportenDAO::insertWorksheetCriteria($id, $crit);
        }
    }

    public static function getTeacher() {
        return rapportenDAO::getTeacher();
    }

    public static function getStudentlistFromCourseID($cid, $uid) {
        return rapportenDAO::getStudentlistFromCourseID($cid, $uid);
    }

    public static function getStudentListInfoFromListId($id) {
        return rapportenDAO::getStudentListInfoFromListId($id);
    }
    
    public static function getStudentsFromStudentList($id) {
        return rapportenDAO::getStudentsFromStudentList($id);
    }
    
    public static function getCourseCount() {
        return rapportenDAO::getCourseCount();
    }
    
    public static function getStudentsCountFromCourse() {
        return rapportenDAO::getStudentsCountFromCourse();
    }
    
    public static function getStudentGroupTeacherByCourseID($start, $count, $course) {
        return rapportenDAO::getStudentGroupTeacherByCourseID($start, $count, $course);
    }
    
    public static function getStudentGroupTeacherByCourseCount($course) {
        return rapportenDAO::getStudentGroupTeacherByCourseCount($course);
    }
    
    public static function getWorkficheCourseUser($start, $count, $userid, $course) {
        return rapportenDAO::getWorkficheCourseUser($start, $count, $userid, $course);
    }
    
    public static function getWorkficheCourseUserCount($userid, $course) {
        return rapportenDAO::getWorkficheCourseUserCount($userid, $course);
    }

    /*
     *
     * Momenteel niet langer gebruikt.
     *
     *
    public static function getIDFromTeacherByName($firstname, $lastname) {
        return rapportenDAO::getIDFromTeacherByName($firstname, $lastname);
    }
    */

    /*
     *
     * Momenteel niet langer gebruikt.
     *
     *
    public static function getIDFromStudentlistByName($id, $name) {
        return rapportenDAO::getIDFromStudentlistByName($id, $name);
    }
    */

    public static function addTeacher($id) {
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
    
    public static function addStudentToList($name, $listid) {
        rapportenDAO::addStudentToList($name, $listid);
    }

    public static function createCourseStudentlistCouple($courseid, $studlistid, $teacherid) {
        $id = rapportenDAO::insertCourseStudlistCouple($courseid, $studlistid, $teacherid);

        if($id != null) {
            return array(
                "projectid" => $courseid,
                "studentlistid" => $studlistid,
                "teacherid" => $teacherid
            );
        } else {
            return -1;
        }
    }

    public static function createWorksheetStudentCouple($worksheetid, $studid) {
        $id = rapportenDAO::insertWorksheetStudentCouple($worksheetid, $studid);

        if($id != null) {
            return array(
                "worksheetid" => $worksheetid,
                "$studid" => $studid
            );
        } else {
            return -1;
        }
    }

    public static function createWorksheetStudentListCouple($worksheetid, $studlijstid) {
        $id = rapportenDAO::insertWorksheetStudentListCouple($worksheetid, $studlijstid);

        if($id != null) {
            return array(
                "worksheetid" => $worksheetid,
                "$studlijstid" => $studlijstid
            );
        } else {
            return -1;
        }
    }

    public static function deleteCourse($id) {
        return rapportenDAO::deleteCourse($id);
    }

    public static function setInactiveCourseStudlistCouple($course, $studentlist, $teacher) {
        return rapportenDAO::setInactiveCourseStudlistCouple($course, $studentlist, $teacher);
    }

    public static function copyCourse($id) {
        return rapportenDAO::copyCourse($id);
    }

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
    
    public static function updateWorksheet($id, $name) {
        if(rapportenDAO::updateWorksheet($id, $name)){
            return array(
                "id" => $id,
                "name" => $name);
        } else {
            return -1;
        }
    }
    
    public static function updateWorksheetProperties($id, $equip, $method, $assess) {
        if (rapportenDAO::updateWorksheetProperties($id, $equip, $method, $assess)) {
            return array(
                "equipment" => $equip,
                "method" => $method,
                "assess" => $assess);
        } else {
            return -1;
        }
    }
    
    public static function assessWorksheet($wid, $userid, $date, $sheetscore, $modscores, $compscores, $critscores) {
        rapportenDAO::assessWorksheet($wid, $userid, $date, $sheetscore);
    }

    public static function getAllDataFromCourse($id) {
        return rapportenDAO::getAllDataFromCourse($id);
    }
    
    public static function removeCriteriaFromDatabase($id) {
        return rapportenDAO::removeCriteriaFromDatabase($id);
    }
    
    public static function removeDoelstellingFromDatabase($id) {
        return rapportenDAO::removeDoelstellingFromDatabase($id);
    }
    
    public static function removeModuleFromDatabase($id) {
        return rapportenDAO::removeModuleFromDatabase($id);
    }

    public static function getStudentListsFromUser($id) {
        return rapportenDAO::getStudentListsFromUser($id);
    }

    public static function deleteStudentList($id) {
        return rapportenDAO::deleteStudentList($id);
    }
    
    public static function deleteWorksheet($id) {
        return rapportenDAO::deleteWorksheet($id);
    }
    
    public static function deleteWorksheetFromUser($id, $userid) {
        return rapportenDAO::deleteWorksheetFromUser($id, $userid);
    }
    
    public static function updateCoursemodules($courseid, $courseStructure) {
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
                    // Insert a doelstelling
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
    
    public static function saveDropdownChoice($user, $course, $courseid, $studentlist, $studentlistid, $student, $studentid) {
    $id = rapportenDAO::saveDropdownChoice($user, $course, $courseid, $studentlist, $studentlistid, $student, $studentid);
    if($id != false) {
        return array(
            "course" => $course,
            "student" => $student,
            "user" => $user
        );
    } else {
        return -1;
    }
    }

    public static function saveDropdownChoiceWorksheet($user, $course, $courseid) {
        $id = rapportenDAO::saveDropdownChoiceWorksheet($user, $course, $courseid);
        if($id != false) {
            return array(
                "course" => $course,
                "student" => $student,
                "user" => $user
            );
        } else {
            return -1;
        }
    }
    
    public static function putmodule($id = -1, $name, $description, $courseid) {
        if($id == -1) {
            return rapportenDAO::putNewmodule($name, $description, $courseid);
        } else {
            rapportenDAO::updatemodule($id, $name, $description, $courseid);
            return $id;
        }
    }

    public static function putdoelstelling($id = -1, $name, $description, $moduleid) {
        if($id == -1){
            return rapportenDAO::putNewdoelstelling($name, $description, $moduleid);
        } else {
            // Update a doelstelling
            rapportenDAO::updatedoelstelling($id, $name, $description, $moduleid);
            return $id;
        }
    }

    public static function putcriteria($id = -1, $name, $description, $doelstelling) {
        if($id == -1){
            // Insert a new criteria
            return rapportenDAO::putNewcriteria($name, $description, $doelstelling);
        } else {
            // Update an criteria
            rapportenDAO::updatecriteria($id, $name, $description, $doelstelling);
            return $id;
        }
    }

    public static function updateStudentList($id, $name) {
        if(rapportenDAO::updateStudentList($id, $name)){
            return array(
                "id" => $id,
                "code" => $name);
        } else {
            return -1;
        }
    }
    
    public static function updateStudent($id, $firstname, $lastname, $username) {
        if(rapportenDAO::updateStudent($id, $firstname, $lastname, $username)) {
            return array(
                "id" => $id,
                "firstname" => $firstname,
                "lastname" => $lastname,
                "username" => $username,
            );
        } else {
            return -1;
        }
    }
    
    public static function deleteStudentFromStudentList($studlistid, $studid) {
        return rapportenDAO::deleteStudentFromStudentList($studlistid, $studid);
    }
}
