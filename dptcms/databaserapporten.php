<?php
class rapportenDAO {
    public static function getAllCourses($start, $count) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT * FROM course_rapport WHERE active = '1' LIMIT :start,:count");
            $stmt->bindValue(':start', (int) $start, PDO::PARAM_INT);
            $stmt->bindValue(':count', (int) $count, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $err) {
            Logger::logError('could not select all courses', $err);
            return null;
        }
    }
    public static function getStudentsFromCourse($start, $count) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT * FROM students LIMIT :start,:count  ");
            $stmt->bindValue(':start', (int) $start, PDO::PARAM_INT);
            $stmt->bindValue(':count', (int) $count, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $err) {
            Logger::logError('could not select all courses', $err);
            return null;
        }
    }
    
    public static function addWorksheetToCourse($name, $courseid) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("INSERT INTO werkfiche_rapport (Name, Course)
                                    VALUES (:name, :courseid)");
            $stmt->bindValue(':name', (string) $name, PDO::PARAM_STR);
            $stmt->bindValue(':courseid', (int) $courseid, PDO::PARAM_INT);
            $stmt->execute();
            return $conn->lastInsertId();
        } catch (PDOException $err) {
            Logger::logError('could not insert into worksheets table', $err);
            return null;
        }
    }

    public static function getAllStudents() {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT firstname, lastname FROM users");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $err) {
            Logger::logError('could not select all students', $err);
            return null;
        }
    }

    public static function insertCourse($code, $name, $description) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("INSERT INTO course_rapport (code, name, description) VALUES (?, ?, ?)");
            $stmt->execute(array($code, $name, $description));
            // Return the id of the newly inserted item on success.
            return $conn->lastInsertId();
        } catch (PDOException $err) {
            Logger::logError('Could not create new course', $err);
            return null;
        }
    }

    public static function insertStudentList($name, $ownerid) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("INSERT INTO studentlist_rapport (owner, name, Active) VALUES (?, ?, 1)");
            $stmt->execute(array($ownerid, $name));
            // Return the id of the newly inserted item on success.
            return $conn->lastInsertId();
        } catch (PDOException $err) {
            Logger::logError('Could not create new list', $err);
            return null;
        }
    }
    
    public static function insertWorksheetModule($id, $modid) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("INSERT INTO werkfiche_module_rapport (werkfiche, module) VALUES (?, ?)");
            $stmt->execute(array($id, $modid));
        } catch (PDOException $err) {
            Logger::logError('Could not create new list', $err);
        }
    }
    
    public static function insertWorksheetCompetence($id, $compid) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("INSERT INTO werkfiche_competence_rapport (werkfiche, competence) VALUES (?, ?)");
            $stmt->execute(array($id, $compid));
        } catch (PDOException $err) {
            Logger::logError('Could not create new list', $err);
        }
    }
    
    public static function insertWorksheetCriteria($id, $critid) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("INSERT INTO werkfiche_criteria_rapport (werkfiche, criteria) VALUES (?, ?)");
            $stmt->execute(array($id, $critid));
        } catch (PDOException $err) {
            Logger::logError('Could not create new list', $err);
        }
    }
    
    //Get all courses
    public static function getAllCourse() {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT * FROM course_rapport WHERE  active = '1' ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $err) {
            Logger::logError('Could not get courses', $err);
            return false;
        }
    }

    //Makes it possible to show a Teacher only the courses he teach
    public static function getAllCourseFromTeacher($userid) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT DISTINCT(course_rapport.id), course_rapport.name
                                        FROM course_studentlist_teacher_rapport LEFT JOIN course_rapport
                                        ON course_studentlist_teacher_rapport.course = course_rapport.id
                                        WHERE course_studentlist_teacher_rapport.active =  '1' AND course_rapport.active =  '1'
                                        AND teacher =  :teacher");
            $stmt->bindValue(':teacher', (int) $userid, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $err) {
            Logger::logError('Could not get courses', $err);
            return false;
        }
    }
    
    public static function getAllWorksheets($courseid, $start, $count) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT * FROM werkfiche_rapport WHERE Course = :courseid AND Active = '1' LIMIT :start, :count");
            $stmt->bindValue(':courseid', (int) $courseid, PDO::PARAM_INT);
            $stmt->bindValue(':start', (int) $start, PDO::PARAM_INT);
            $stmt->bindValue(':count', (int) $count, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $err) {
            Logger::logError('could not select all worksheets', $err);
            return null;
        }
    }

    public static function getAllWorksheetsNoPager($courseid) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT * FROM werkfiche_rapport WHERE Course = :courseid AND Active = '1'");
            $stmt->bindValue(':courseid', (int) $courseid, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $err) {
            Logger::logError('could not select all worksheets', $err);
            return null;
        }
    }

    public static function getStudentListsFromUser($id) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT * FROM studentlist_rapport WHERE owner = :owner AND Active ='1'");
            $stmt->bindValue(':owner', (int) $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $err) {
            Logger::logError('Could not get studentlists from ower with id' . $id, $err);
            return null;
        }
    }
    
    public static function getStudentlistFromCourseID($cid, $uid) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT studentlist_rapport.id, studentlist_rapport.owner, studentlist_rapport.name FROM studentlist_rapport
                                    JOIN course_studentlist_teacher_rapport ON studentlist_rapport.id = course_studentlist_teacher_rapport.studentlist
                                    WHERE course_studentlist_teacher_rapport.teacher = :uid
                                    AND course_studentlist_teacher_rapport.course = :cid
                                    AND studentlist_rapport.Active = 1 AND course_studentlist_teacher_rapport.Active = 1");
            $stmt->bindValue(':cid', (int) $cid, PDO::PARAM_INT);
            $stmt->bindValue(':uid', (int) $uid, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $err) {
            Logger::logError('Could not get studentlists from owner with id' .  $err);
            return null;
        }
    }

    /*
     * Get all module by course
     * @id the course
     */
    public static function getmoduleByCourse($id) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT * FROM module_rapport WHERE course = :course");
            $stmt->bindValue(':course', (int) $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $err) {
            Logger::logError('Could not get modules', $err);
            return false;
        }
    }
    /**
     * Get a list of doelstelling associated with a cometenxe.
     * @param type $id the module id to get the doelstelling information from.
     */
    public static function getCoursesByTraining($id) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT * FROM doelstelling_rapport WHERE module = $id");
            $stmt->bindValue(':training', (int) $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $err) {
            Logger::logError('Could not get doelstellingen', $err);
            return null;
        }
    }
    
    public static function getStudentListInfoFromListId($listid) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT * FROM studentlist_rapport where id = :id ");
            $stmt->bindValue(':id', (int) $listid, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $err) {
            Logger::logError('Could not get data', $err);
            return null;
        }
    }
    
    public static function getStudentsFromStudentList($id) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT users.id, users.username, users.firstname, users.lastname FROM users JOIN studentlist_students_rapport ON users.id = studentlist_students_rapport.user WHERE studentlist_students_rapport.studentlist = :id ");
            $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $err) {
            Logger::logError('could not select studentlist by id ' . $id, $err);
            return null;
        }
    }
    
    /**
     * Get a list of modules associated with a doelstelling.
     * @param type $id the module id to get the module information from.
     */
    public static function getmodulesBydoelstelling($id) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT * FROM criteria_rapport WHERE doelstelling = $id");
            $stmt->bindValue(':training', (int) $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $err) {
            Logger::logError('Could not get doelstellingen', $err);
            return null;
        }
    }
    public static function getTeacher() {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT * FROM users");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $err) {
            Logger::logError('Could not find teacher', $err);
            return null;
        }
    }


    public static function addTeacher($id) {
        /*try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT * FROM users");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $err) {
            Logger::logError('Could not find teacher', $err);
            return null;
        }*/
    }
    
    public static function addStudentToList($name, $listid) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("INSERT INTO studentlist_students_rapport (studentlist, user)
                                    SELECT :list, users.id FROM users
                                    WHERE CONCAT(firstname, ' ', lastname) = :name LIMIT 1");
            $stmt->bindValue(':list', (int) $listid, PDO::PARAM_INT);
            $stmt->bindValue(':name', (string) $name, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $err) {
            Logger::logError('Could not add student to list', $err);
            return null;
        }
    }

    public static function getLastDropdownFromUser($id) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT * FROM lastdropdownRapport WHERE user = :id");
            $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $err) {
            Logger::logError('Could not get last dropdowns from the database', $err);
            return null;
        }
    }
    
    public static function getCourseCount() {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT COUNT(*) FROM course_rapport");
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (PDOException $err) {
            Logger::logError('Could not count all courses in the database', $err);
            return 0;
        }
    }
    
    public static function getWorksheetCount() {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT COUNT(*) FROM werkfiche_rapport");
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (PDOException $err) {
            Logger::logError('Could not count all worksheets in the database', $err);
            return 0;
        }
    }
    
    public static function getStudentsCountFromCourse() {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT COUNT(*) FROM students");
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (PDOException $err) {
            Logger::logError('Could not count all courses in the database', $err);
            return 0;
        }
    }

    public static function getStudentGroupTeacherByCourseID($start, $count, $course) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT studentlist_rapport.id as 'studid', studentlist_rapport.name, users.id as 'userid', users.firstname, users.lastname,course_studentlist_teacher_rapport.id
                                        FROM course_studentlist_teacher_rapport
                                        LEFT JOIN studentlist_rapport ON course_studentlist_teacher_rapport.studentlist = studentlist_rapport.id
                                        LEFT JOIN users ON course_studentlist_teacher_rapport.teacher = users.id
                                        WHERE course_studentlist_teacher_rapport.active =  '1'
                                        AND course =  :course
                                        ORDER BY studentlist_rapport.name, users.firstname, users.lastname
                                        LIMIT :start,:count");
            $stmt->bindValue(':start', (int) $start, PDO::PARAM_INT);
            $stmt->bindValue(':count', (int) $count, PDO::PARAM_INT);
            $stmt->bindValue(':course', (int) $course, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $err) {
            Logger::logError('could not select all connections between an studentlist an teachers', $err);
            return null;
        }
    }

    public static function getStudentGroupTeacherByCourseCount($course) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT count(*)
                                      FROM course_studentlist_teacher_rapport
                                        LEFT JOIN studentlist_rapport ON course_studentlist_teacher_rapport.studentlist = studentlist_rapport.id
                                        LEFT JOIN users ON course_studentlist_teacher_rapport.teacher = users.id
                                        WHERE course_studentlist_teacher_rapport.active =  '1'
                                        AND course =  :course");
            $stmt->bindValue(':count', (int) $course, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (PDOException $err) {
            Logger::logError('Could not count all connections between an studentlist an teachers', $err);
            return 0;
                }
    }

    public static function getWorkficheCourseUser($start, $count, $userid, $course) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT werkfiche_rapport.id, werkfiche_rapport.Name, werkfiche_user_rapport.datum,
                                        werkfiche_user_rapport.score
                                        FROM werkfiche_user_rapport
                                        LEFT JOIN werkfiche_rapport ON werkfiche_user_rapport.werkfiche = werkfiche_rapport.id
                                        WHERE werkfiche_rapport.course = :course
                                        AND werkfiche_user_rapport.user = :userid
                                        ORDER BY werkfiche_user_rapport.datum,werkfiche_rapport.Name
                                        LIMIT :start,:count");
            $stmt->bindValue(':start', (int) $start, PDO::PARAM_INT);
            $stmt->bindValue(':count', (int) $count, PDO::PARAM_INT);
            $stmt->bindValue(':course', (int) $course, PDO::PARAM_INT);
            $stmt->bindValue(':userid', (int) $userid, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $err) {
            Logger::logError('could not select all worksheets from a student for a specific course', $err);
            return null;
        }
    }

    public static function getWorkficheCourseUserCount($userid, $course) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT count(werkfiche_rapport.id)
                                        FROM werkfiche_user_rapport
                                        LEFT JOIN werkfiche_rapport ON werkfiche_user_rapport.werkfiche = werkfiche_rapport.id
                                        WHERE werkfiche_rapport.course = :course
                                        AND werkfiche_user_rapport.user = :userid");
            $stmt->bindValue(':count', (int) $course, PDO::PARAM_INT);
            $stmt->bindValue(':userid', (int) $userid, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (PDOException $err) {
            Logger::logError('Could not count all worksheets from a student for a specific course', $err);
            return 0;
        }
    }

    /*
     * Koppelingen maken tussen studentenlijst ,Course & Teacher
     * Maar Course moet meerdere studentlijsen
     */
    public static function insertCourseStudlistCouple($courseid, $studlistid, $teacherid) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("INSERT INTO course_studentlist_teacher_rapport (course, studentlist, teacher) VALUES (?,?,?)");

            $stmt->execute(array($courseid, $studlistid, $teacherid));

            return $conn->lastInsertId();
        } catch (PDOException $err) {
            Logger::logError('Could not create new coupling between a course, studentlist and a teacher', $err);
            return null;
        }
    }
    public static function insertWorksheetStudentCouple($worksheetid, $studid) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("INSERT INTO werkfiche_user_rapport (werkfiche, user) VALUES (?,?)");

            $stmt->execute(array($worksheetid, $studid));

            return $conn->lastInsertId();
        } catch (PDOException $err) {
            Logger::logError('Could not create new coupling between a worksheet and student', $err);
            return null;
        }
    }

    public static function insertWorksheetStudentListCouple($worksheetid, $studlijstid) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("INSERT INTO werkfiche_user_rapport (werkfiche, user)
                                      SELECT ?, user FROM studentlist_students_rapport
                                        WHERE studentlist = ?");

            $stmt->execute(array($worksheetid, $studlijstid));

            return $conn->lastInsertId();
        } catch (PDOException $err) {
            Logger::logError('Could not create new coupling between a worksheet and the students in a studentlist', $err);
            return null;
        }
    }

    public static function updateCourse($id, $code, $name, $description) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("UPDATE course_rapport SET code = ?, name = ?, description = ? WHERE id = ?");
            $stmt->execute(array($code, $name, $description, $id));
            return true;
        } catch (PDOException $err) {
            Logger::logError('Could not update course', $err);
            return false;
        }
    }
    
    public static function updateWorksheet($id, $name) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("UPDATE werkfiche_rapport SET Name = ? WHERE id = ?");
            $stmt->execute(array($name, $id));
            return true;
        } catch (PDOException $err) {
            Logger::logError('Could not update worksheet', $err);
            return false;
        }
    }
    
    public static function updateWorksheetProperties($id, $equip, $method, $assess) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("UPDATE werkfiche_rapport SET equipment = ?, method = ?, assessment = ? WHERE id = ?");
            $stmt->execute(array($equip, $method, $assess, $id));
            return true;
        } catch (PDOException $err) {
            Logger::logError('Could not update worksheet', $err);
            return false;
        }
    }
    
    public static function assessWorksheet($wid, $userid, $date, $score) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("UPDATE werkfiche_user_rapport SET datum = ?, score = ? WHERE werkfiche = ? AND user = ?");
            $stmt->execute(array($date, $score, $wid, $userid));
            return true;
        } catch (PDOException $err) {
            Logger::logError('Could not update worksheet', $err);
            return false;
        }
    }
    
    public static function assessModules($sheetmodule, $user, $score) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("INSERT INTO werkfiche_module_score_rapport(werkfiche_module, werkfiche_user, score)
                                    VALUES (?,?,?)");
            $stmt->execute(array($sheetmodule, $user, $score));
            $sid = $conn->lastInsertId();
            return $sid;
        } catch (PDOException $err) {
            Logger::logError('Could not insert score for module', $err);
            return null;
        }
    }
    
    public static function assessCompetences($sheetcompetence, $user, $score) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("INSERT INTO werkfiche_competence_score_rapport(werkfiche_competence, werkfiche_user, score)
                                    VALUES (?,?,?)");
            $stmt->execute(array($sheetcompetence, $user, $score));
            $sid = $conn->lastInsertId();
            return $sid;
        } catch (PDOException $err) {
            Logger::logError('Could not insert score for competence', $err);
            return null;
        }
    }
    
    public static function assessCriteria($sheetcriteria, $user, $score) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("INSERT INTO werkfiche_criteria_score_rapport(werkfiche_criteria, werkfiche_user, score)
                                    VALUES (?,?,?)");
            $stmt->execute(array($sheetcriteria, $user, $score));
            $sid = $conn->lastInsertId();
            return $sid;
        } catch (PDOException $err) {
            Logger::logError('Could not insert score for criteria', $err);
            return null;
        }
    }
    
    public static function getWorksheetData($wid) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT equipment, method, assessment FROM werkfiche_rapport
                                    WHERE id = :wid");
            $stmt->bindValue(':wid', (int) $wid, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $err) {
            Logger::logError('could not select worksheetdata by id ' . $wid, $err);
            return null;
        }
    }
    
    public static function getWorksheetModule($wid, $modid) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT id FROM werkfiche_module_rapport
                                    WHERE werkfiche = :wid AND module = :modid");
            $stmt->bindValue(':wid', (int) $wid, PDO::PARAM_INT);
            $stmt->bindValue(':modid', (int) $modid, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $err) {
            Logger::logError('could not select worksheetdata by id ' . $wid, $err);
            return null;
        }
    }
    
    public static function getWorksheetCompetence($wid, $compid) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT id FROM werkfiche_competence_rapport
                                    WHERE werkfiche = :wid AND competence = :compid");
            $stmt->bindValue(':wid', (int) $wid, PDO::PARAM_INT);
            $stmt->bindValue(':compid', (int) $compid, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $err) {
            Logger::logError('could not select worksheetdata by id ' . $wid, $err);
            return null;
        }
    }
    
    public static function getWorksheetCriteria($wid, $critid) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT id FROM werkfiche_criteria_rapport
                                    WHERE werkfiche = :wid AND criteria = :critid");
            $stmt->bindValue(':wid', (int) $wid, PDO::PARAM_INT);
            $stmt->bindValue(':critid', (int) $critid, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $err) {
            Logger::logError('could not select worksheetdata by id ' . $wid, $err);
            return null;
        }
    }

    public static function deleteCourse($id) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("UPDATE course_rapport SET active = '0' WHERE id = :id");
            $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $err) {
            Logger::logError('Could not delete project', $err);
            return null;
        }
    }
    
    public static function deleteWorksheet($id) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("UPDATE werkfiche_rapport SET Active = '0' WHERE id = :id");
            $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $err) {
            Logger::logError('Could not delete worksheet', $err);
            return null;
        }
    }
    
    public static function deleteWorksheetFromUser($id, $userid) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("DELETE FROM werkfiche_user_rapport
                                    WHERE werkfiche = :id AND user = :userid");
            $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
            $stmt->bindValue(':userid', (int) $userid, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $err) {
            Logger::logError('Could not delete worksheet from user with id ' + $userid, $err);
            return null;
        }
    }

    //set link course - teacher - studlist inactive
    public static function setInactiveCourseStudlistCouple($course, $studentlist, $teacher) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("UPDATE course_studentlist_teacher_rapport SET active = '0' WHERE course = :course AND studentlist = :studentlist AND teacher = :teacher");
            $stmt->bindValue(':course', (int) $course, PDO::PARAM_INT);
            $stmt->bindValue(':studentlist', (int) $studentlist, PDO::PARAM_INT);
            $stmt->bindValue(':teacher', (int) $teacher, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $err) {
            Logger::logError('Could not delete project', $err);
            return null;
        }
    }

    public static function copyCourse($id) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("INSERT INTO course_rapport(code,name,description,leerkracht,active,studentlistid)
                                    SELECT code,name,description,leerkracht,active,studentlistid FROM course_rapport WHERE id = :id");
            $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
            $stmt->execute();

            return true;
        } catch (PDOException $err) {
            Logger::logError('Could not copy course', $err);
            return null;
        }
    }


    public static function deleteStudentList($id) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("UPDATE studentlist_rapport SET active = '0' WHERE id = :id");
            $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
            $stmt->execute();
            /*$stmt2 = $conn->prepare("DELETE FROM studentlist_students WHERE studentlist = :id");
            $stmt2->bindValue(':id', (int) $id, PDO::PARAM_INT);
            $stmt2->execute();*/
            /*$stmt3 = $conn->prepare("DELETE FROM project_studentlist WHERE studentlist =:id");
            $stmt3->bindValue(':id', (int) $id, PDO::PARAM_INT);
            $stmt3->execute();*/
            return true;
        } catch (PDOException $err) {
            Logger::logError('Could not delete studentlist', $err);
            return null;
        }
    }
    
    public static function removeCriteriaFromDatabase($id)
    {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("UPDATE criteria_rapport SET active = '0' WHERE id = :id");
            $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $err) {
            echo $err;
            return false;
        }
    }
    
        public static function removeDoelstellingFromDatabase($id)
    {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("UPDATE doelstelling_rapport SET active = '0' WHERE id = :id");
            $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $err) {
            echo $err;
            return false;
        }
    }
    
            public static function removeModuleFromDatabase($id)
    {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("UPDATE module_rapport SET active = '0' WHERE id = :id");
            $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $err) {
            echo $err;
            return false;
        }
    }

    public static function getAllDataFromCourse($id) {
        try {
            
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT module_rapport.id mid, module_rapport.name mname, module_rapport.description mdescription, module_rapport.Active mac, doelstelling_rapport.id did, doelstelling_rapport.name dname, doelstelling_rapport.description ddescription, doelstelling_rapport.Active dac, criteria_rapport.id cid, criteria_rapport.name cname, criteria_rapport.description cdescription, criteria_rapport.Active cac FROM module_rapport
                                    LEFT JOIN doelstelling_rapport ON module_rapport.id = doelstelling_rapport.module
                                    LEFT JOIN criteria_rapport ON doelstelling_rapport.id = criteria_rapport.doelstelling
                                    WHERE module_rapport.course = :courseid
                                    ORDER BY mid, did, cid ASC");
            $stmt->bindValue(':courseid', (int) $id, PDO::PARAM_INT);
            $stmt->execute();
            $dataFromDb = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $data = array();
            foreach ($dataFromDb as $row) {
                if (!array_key_exists($row['mid'], $data) && $row['mac'] != 0) {      //NEW
                    $module = new stdClass();
                    $module->id = $row['mid'];
                    $module->name = $row['mname'];
                    $module->description = $row['mdescription'];
                    $module->doelstellingen = array();
                    $data[$row['mid']] = $module;
                }
                if (!array_key_exists($row['did'], $module->doelstellingen) && $row['mac'] != 0 && $row['dac'] != 0) {    //NEW
                    $doelstelling = new stdClass();
                    $doelstelling->id = $row['did'];
                    $doelstelling->name = $row['dname'];
                    $doelstelling->description = $row['ddescription'];
                    $doelstelling->criterias = array();
                    $module->doelstellingen[$row['did']] = $doelstelling;
                }
                if (!array_key_exists($row['cid'], $doelstelling->criterias) && $row['mac'] != 0 && $row['dac'] != 0 && $row['cac'] != 0) {     //NEW
                    $criteria = new stdClass();
                    $criteria->id = $row['cid'];
                    $criteria->name = $row['cname'];
                    $criteria->description = $row['cdescription'];
                    $doelstelling->criterias[$row['cid']] = $criteria;
                }
            }
            return $data;
        } catch (PDOException $err) {
            Logger::logError('Could not get all data from course with id ' . $id, $err);
            return null;
        }
    }
    
    public static function putNewmodule($name, $description, $course) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("INSERT INTO module_rapport (name, description, course, active) VALUES (?, ?, ?, 1)");
            $stmt->execute(array($name, $description, $course));
            $pid = $conn->lastInsertId();
            return $pid;
        } catch (PDOException $err) {
            echo $err;
            return null;
        }
    }

    public static function updatemodule($id, $name, $description, $course) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("UPDATE module_rapport SET name = ?, description = ?, course = ? WHERE id = ?");
            $stmt->execute(array($name, $description, $course, $id));
            return true;
        } catch (PDOException $err) {
            echo $err;
            return false;
        }
    }

    public static function putNewdoelstelling($name, $description, $moduleid) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("INSERT INTO doelstelling_rapport (name, description, module, active) VALUES (?, ?, ?, 1)");
            $stmt->execute(array($name, $description, $moduleid));
            $sid = $conn->lastInsertId();
            return $sid;
        } catch (PDOException $err) {
            echo $err;
            return null;
        }
    }

    public static function updatedoelstelling($id, $name, $description, $moduleid) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("UPDATE doelstelling_rapport SET name = ?, description = ?, module = ? WHERE id = ?");
            $stmt->execute(array($name, $description, $moduleid, $id));
            return true;
        } catch (PDOException $err) {
            echo $err;
            return false;
        }
    }

    public static function putNewcriteria($name, $description, $doelstellingid) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("INSERT INTO criteria_rapport (name, description, doelstelling, active) VALUES (?, ?, ?, 1)");
            $stmt->execute(array($name, $description, $doelstellingid));
            $iid = $conn->lastInsertId();
            return $iid;
        } catch (PDOException $err) {
            echo $err;
            return null;
        }
    }

    public static function updatecriteria($id, $name, $description, $doelstellingid) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("UPDATE criteria_rapport SET name = ?, description = ?, doelstelling = ? WHERE id = ?");
            $stmt->execute(array($name, $description, $doelstellingid, $id));
            return true;
        } catch (PDOException $err) {
            echo $err;
        }
    }
    public static function saveDropdownChoice($user, $course, $courseid, $studentlist, $studentlistid, $student, $studentid) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("INSERT INTO lastdropdownRapport (user, course, courseid, studentlist, studentlistid, student, studentid) VALUES (?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE course = ?, courseid = ?, studentlist = ?, studentlistid = ?, student = ?, studentid = ?");
            $stmt->execute(array($user, $course, $courseid, $studentlist, $studentlistid, $student, $studentid, $course, $courseid, $studentlist, $studentlistid, $student, $studentid));
            return true;
        } catch (PDOException $err) {
            Logger::logError('Could not save dropdown list', $err);
            return false;
        }
    }
    public static function saveDropdownChoiceWorksheet($user, $course, $courseid) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("INSERT INTO lastdropdownRapport (user, courseworksheet, courseidworksheet) VALUES (?,?,?) ON DUPLICATE KEY UPDATE courseworksheet = ?, courseidworksheet = ?");
            $stmt->execute(array($user, $course, $courseid));
            return true;
        } catch (PDOException $err) {
            Logger::logError('Could not save dropdown list', $err);
            return false;
        }
    }

    //update/edit studentlist
    public static function updateStudentList($id, $code) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("UPDATE studentlist_rapport SET name = ? WHERE id = ?");
            $stmt->execute(array($code, $id));
            return true;
        } catch (PDOException $err) {
            Logger::logError('Could not update course', $err);
            return false;
        }
    }
    
    public static function updateStudent($id, $firstname, $lastname, $username) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("UPDATE users SET firstname = ?, lastname = ?, username = ? WHERE id = ?");
            $stmt->execute(array($firstname, $lastname, $username, $id));
            return true;
        } catch (PDOException $err) {
            Logger::logError('Could not update student', $err);
            return false;
        }
    }
    
    public static function deleteStudentFromStudentList($studlistid, $studid) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("DELETE FROM studentlist_students_rapport WHERE studentlist = :studlist AND user = :user");
            $stmt->bindValue(':studlist', (int) $studlistid, PDO::PARAM_INT);
            $stmt->bindValue(':user', (int) $studid, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $err) {
            Logger::logError('Could not delete student', $err);
            return null;
        }
    }
}
?>
