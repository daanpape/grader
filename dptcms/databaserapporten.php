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
 * Get a list of subcompetence associated with a cometenxe.
 * @param type $id the module id to get the submodule information from.
 */
    public static function getCoursesByTraining($id) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT * FROM subcompetence_rapport WHERE competence = $id");
            $stmt->bindValue(':training', (int) $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $err) {
            Logger::logError('Could not get subcompetences', $err);
            return null;
        }
    }

    /**
     * Get a list of goals associated with a subcompetence.
     * @param type $id the module id to get the goal information from.
     */
    public static function getGoalsBySubcompetence($id) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT * FROM indicator_rapport WHERE subcompetence = $id");
            $stmt->bindValue(':training', (int) $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $err) {
            Logger::logError('Could not get subcompetences', $err);
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
    
    public static function getAllDataFromCourse($id) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT competence_rapport.id cid, competence_rapport.name cname, competence_rapport.description cdescription, subcompetence_rapport.id sid, subcompetence_rapport.name sname, subcompetence_rapport.description sdescription, indicator_rapport.id iid, indicator_rapport.name iname, indicator_rapport.description idescription FROM competence_rapport 
                                    LEFT JOIN subcompetence_rapport ON competence_rapport.id = subcompetence_rapport.competence
                                    LEFT JOIN indicator_rapport ON subcompetence_rapport.id = indicator_rapport.subcompetence 
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
                    $competence->subcompetences = array();

                    $data[$row['cid']] = $competence;
                }

                if (!array_key_exists($row['sid'], $competence->subcompetences)) {
                    $subcompetence = new stdClass();
                    $subcompetence->id = $row['sid'];
                    $subcompetence->name = $row['sname'];
                    $subcompetence->description = $row['sdescription'];
                    $subcompetence->indicators = array();

                    $competence->subcompetences[$row['sid']] = $subcompetence;
                }

                if (!array_key_exists($row['iid'], $subcompetence->indicators)) {
                    $indicator = new stdClass();
                    $indicator->id = $row['iid'];
                    $indicator->name = $row['iname'];
                    $indicator->description = $row['idescription'];

                    $subcompetence->indicators[$row['iid']] = $indicator;
                }
            }

            return $data;
        } catch (PDOException $err) {
            Logger::logError('Could not get all data from course with id ' . $id, $err);
            return null;
        }
    }

    public static function saveDropdownChoiceRapport($location, $locationid, $training, $trainingid, $course, $courseid, $user) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("INSERT INTO lastdropdown (user, location, locationid, training, trainingid, course, courseid) VALUES (?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE location = ?, locationid = ?, training = ?, trainingid = ?, course = ?, courseid = ?");
            $stmt->execute(array($user, $location, $locationid, $training, $trainingid, $course, $courseid, $location, $locationid, $training, $trainingid, $course, $courseid));

            return true;
        } catch (PDOException $err) {
            Logger::logError('Could not create new coupling between a project and a studentlist', $err);
            return false;
        }
    }
}

?>
