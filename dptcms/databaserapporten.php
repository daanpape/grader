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
            $stmt = $conn->prepare("INSERT INTO studentlist_rapport (owner, name) VALUES (?, ?)");
            $stmt->execute(array($ownerid, $name));
            // Return the id of the newly inserted item on success.
            return $conn->lastInsertId();
        } catch (PDOException $err) {
            Logger::logError('Could not create new list', $err);
            return null;
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

    public static function getStudentListsFromUser($id) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT * FROM studentlist_rapport WHERE owner = :owner");
            $stmt->bindValue(':owner', (int) $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $err) {
            Logger::logError('Could not get studentlists from ower with id' . $id, $err);
            return null;
        }
    }

    public static function getStudentsFromCourseID($id) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("select user from studentlist_students_rapport where studentlist =
                                          (select studentlistid from course_rapport where id = :id)");
            $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $err) {
            Logger::logError('Could not get studentlists from ower with id' . $id, $err);
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
    public static function getTeacher($id) {
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
    public static function copyCourse($id) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("INSERT INTO course_rapport(code,name,description,leerkracht,active,studentlistid)
SELECT code,name,description,leerkracht,active,studentlistid FROM course_rapport WHERE id = :id
");

            $stmt2= $conn->prepare(	"INSERT INTO module_rapport(name,description,course)

            VALUES (select name from module_rapport where course = :id) as name,
              (select description from module_rapport where course= :id)as description,
              (select course from module_rapport where course = :id ) as course)
         "  );

            $stmt2->bindValue(':id', (int) $id, PDO::PARAM_INT);
           $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
            $stmt->execute();
            $stmt2->execute();
            return true;
        } catch (PDOException $err) {
            Logger::logError('Could not copy course', $err);
            return null;
        }
    }


    public static function deleteStudentList($id) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("DELETE FROM studentlist_rapport WHERE id = :id");
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

    public static function getAllDataFromCourse($id) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT module_rapport.id mid, module_rapport.name mname, module_rapport.description mdescription, doelstelling_rapport.id did, doelstelling_rapport.name dname, doelstelling_rapport.description ddescription, criteria_rapport.id cid, criteria_rapport.name cname, criteria_rapport.description cdescription FROM module_rapport
                                    LEFT JOIN doelstelling_rapport ON module_rapport.id = doelstelling_rapport.module
                                    LEFT JOIN criteria_rapport ON doelstelling_rapport.id = criteria_rapport.doelstelling
                                    WHERE module_rapport.course = :courseid
                                    ORDER BY mid, did, cid ASC");
            $stmt->bindValue(':courseid', (int) $id, PDO::PARAM_INT);
            $stmt->execute();
            $dataFromDb = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $data = array();
            foreach ($dataFromDb as $row) {
                if (!array_key_exists($row['mid'], $data)) {
                    $module = new stdClass();
                    $module->id = $row['mid'];
                    $module->name = $row['mname'];
                    $module->description = $row['mdescription'];
                    $module->doelstellingen = array();
                    $data[$row['mid']] = $module;
                }
                if (!array_key_exists($row['did'], $module->doelstellingen)) {
                    $doelstelling = new stdClass();
                    $doelstelling->id = $row['did'];
                    $doelstelling->name = $row['dname'];
                    $doelstelling->description = $row['ddescription'];
                    $doelstelling->criterias = array();
                    $module->doelstellingen[$row['did']] = $doelstelling;
                }
                if (!array_key_exists($row['cid'], $doelstelling->criterias)) {
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
            $stmt = $conn->prepare("INSERT INTO module_rapport (name, description, course) VALUES (?, ?, ?)");
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
            $stmt = $conn->prepare("INSERT INTO doelstelling_rapport (name, description, module) VALUES (?, ?, ?)");
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
            $stmt = $conn->prepare("INSERT INTO criteria_rapport (name, description, doelstelling) VALUES (?, ?, ?)");
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
    public static function saveDropdownChoice($course, $courseid, $module, $moduleid, $doelstelling, $doelstellingid, $module, $moduleid, $user) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("INSERT INTO lastdropdownRapport (user, course, courseid, module, moduleid, doelstelling, doelstellingid, module, moduleid) VALUES (?,?,?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE course = ?, courseid = ?, module = ?, moduleid = ?, doelstelling = ?, doelstellingid = ?, module = ?, moduleid = ?");
            $stmt->execute(array($user, $course, $courseid, $module, $moduleid, $doelstelling, $doelstellingid, $module, $moduleid, $course, $courseid, $module, $moduleid, $doelstelling, $doelstellingid, $module, $moduleid));
            return true;
        } catch (PDOException $err) {
            Logger::logError('Could not create new coupling between a Course and a studentlist', $err);
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
