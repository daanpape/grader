<?php
class rapportenDAO {
    public static function getAllCourses($start, $count) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT * FROM course_rapport WHERE active = '1' LIMIT :start,:count  ");
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
    /*
     * Get all competence by course
     * @id the course
     */
    public static function getCompetenceByCourse($id) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT * FROM competence_rapport WHERE course = :course");
            $stmt->bindValue(':course', (int) $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $err) {
            Logger::logError('Could not get competences', $err);
            return false;
        }
    }
    /**
     * Get a list of doelstelling associated with a cometenxe.
     * @param type $id the module id to get the submodule information from.
     */
    public static function getCoursesByTraining($id) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT * FROM doelstelling_rapport WHERE competence = $id");
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
    
    /**
     * Get a list of goals associated with a doelstelling.
     * @param type $id the module id to get the goal information from.
     */
    public static function getGoalsBydoelstelling($id) {
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
          /*  $stmt = $conn->prepare("INSERT INTO course_rapport(code,name,description,leerkracht,active,studentlistid)
SELECT code,name,description,leerkracht,active,studentlistid FROM course_rapport WHERE id = :id
");*/

            $stmt2= $conn->prepare(	"INSERT INTO competence_rapport(name,description,course)
 SELECT (select name  FROM  competence_rapport  WHERE  competence = :id) as name,
 (select description  FROM  competence_rapport  WHERE  competence = :id) as decription,
 (select id from course_rapport ORDER BY id DESC LIMIT     1  ) AS course"
);

            $stmt2->bindValue(':id', (int) $id, PDO::PARAM_INT);
           /* $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
            $stmt->execute();*/
            $stmt2->execute();
            return true;
        } catch (PDOException $err) {
            Logger::logError('Could not delete project', $err);
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
            $stmt = $conn->prepare("SELECT competence_rapport.id cid, competence_rapport.name cname, competence_rapport.description cdescription, doelstelling_rapport.id sid, doelstelling_rapport.name sname, doelstelling_rapport.description sdescription, criteria_rapport.id iid, criteria_rapport.name iname, criteria_rapport.description idescription FROM competence_rapport
                                    LEFT JOIN doelstelling_rapport ON competence_rapport.id = doelstelling_rapport.competence
                                    LEFT JOIN criteria_rapport ON doelstelling_rapport.id = criteria_rapport.doelstelling
                                    WHERE competence_rapport.course = :courseid
                                    ORDER BY cid, sid, iid ASC");
            $stmt->bindValue(':courseid', (int) $id, PDO::PARAM_INT);
            $stmt->execute();
            $dataFromDb = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $data = array();
            foreach ($dataFromDb as $row) {
                if (!array_key_exists($row['cid'], $data)) {
                    $competence = new stdClass();
                    $competence->id = $row['cid'];
                    $competence->name = $row['cname'];
                    $competence->description = $row['cdescription'];
                    $competence->doelstellingen = array();
                    $data[$row['cid']] = $competence;
                }
                if (!array_key_exists($row['sid'], $competence->doelstellingen)) {
                    $doelstelling = new stdClass();
                    $doelstelling->id = $row['sid'];
                    $doelstelling->name = $row['sname'];
                    $doelstelling->description = $row['sdescription'];
                    $doelstelling->criterias = array();
                    $competence->doelstellingen[$row['sid']] = $doelstelling;
                }
                if (!array_key_exists($row['iid'], $doelstelling->criterias)) {
                    $criteria = new stdClass();
                    $criteria->id = $row['iid'];
                    $criteria->name = $row['iname'];
                    $criteria->description = $row['idescription'];
                    $doelstelling->criterias[$row['iid']] = $criteria;
                }
            }
            return $data;
        } catch (PDOException $err) {
            Logger::logError('Could not get all data from course with id ' . $id, $err);
            return null;
        }
    }
    public static function putNewCompetence($name, $description, $course) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("INSERT INTO competence_rapport (name, description, course) VALUES (?, ?, ?)");
            $stmt->execute(array($name, $description, $course));
            $pid = $conn->lastInsertId();
            return $pid;
        } catch (PDOException $err) {
            echo $err;
            return null;
        }
    }

    public static function updateCompetence($id, $name, $description, $course) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("UPDATE competence_rapport SET name = ?, description = ?, course = ? WHERE id = ?");
            $stmt->execute(array($name, $description, $course, $id));
            return true;
        } catch (PDOException $err) {
            echo $err;
            return false;
        }
    }

    public static function putNewdoelstelling($name, $description, $competenceid) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("INSERT INTO doelstelling_rapport (name, description, competence) VALUES (?, ?, ?)");
            $stmt->execute(array($name, $description, $competenceid));
            $sid = $conn->lastInsertId();
            return $sid;
        } catch (PDOException $err) {
            echo $err;
            return null;
        }
    }

    public static function updatedoelstelling($id, $name, $description, $competenceid) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("UPDATE doelstelling_rapport SET name = ?, description = ?, competence = ? WHERE id = ?");
            $stmt->execute(array($name, $description, $competenceid, $id));
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
    public static function saveDropdownChoice($course, $courseid, $module, $moduleid, $submodule, $submoduleid, $goal, $goalid, $user) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("INSERT INTO lastdropdownRapport (user, course, courseid, module, moduleid, submodule, submoduleid, goal, goalid) VALUES (?,?,?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE course = ?, courseid = ?, module = ?, moduleid = ?, submodule = ?, submoduleid = ?, goal = ?, goalid = ?");
            $stmt->execute(array($user, $course, $courseid, $module, $moduleid, $submodule, $submoduleid, $goal, $goalid, $course, $courseid, $module, $moduleid, $submodule, $submoduleid, $goal, $goalid));
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
}
?>
