<?php

/*
 * DPTechnics CMS
 * Database module
 * Author: Daan Pape
 * Date: 18-08-2014
 */

// Load required files
require_once('config.php');
require_once('logger.php');

/**
 * Represents an SQL database connection class.
 */
class Db {
    
    /**
     * Get the PDO database connection object
     */
    public static function getConnection() {

        // Construct the PDO adress line
        $host = Config::$dbServer;
        $port = Config::$dbPort;
        $database = Config::$dbName;
        $dsn = "mysql:host=$host;port=$port;dbname=$database";

        // Try to connect to the database
        try {
            $conn = new PDO($dsn, Config::$dbUser, Config::$dbPass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $err) {
            Logger::logError('could not connect to database', $err);
            return null;
        }
    }

}

/**
 * Database Access Object for manipulating projecttypes, competencetypes, ...
 */
class ClassDAO {

    /**
     * Get part of the projects, ready for pagination.
     * @param type $start the start row offset.
     * @param type $count the number of projects to fetch.
     * @return type an object containing the projects or null on error.
     */
    public static function getAllProjects($start, $count) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT * FROM project LIMIT :start,:count");
            $stmt->bindValue(':start', (int) $start, PDO::PARAM_INT);
            $stmt->bindValue(':count', (int) $count, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $err) {
            Logger::logError('could not select all projects', $err);
            return null;
        }
    }

    /**
     * Get the projects corresponding to a course.
     * @param type $courseid the course ID to get the associated projects from.
     * @param type $start the start row offset.
     * @param type $count the number of projects to fetch.
     * @return type an object containing the projects or null on error.
     */
    public static function getProjectsByCourseId($courseid, $start, $count) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT * FROM project WHERE course = :courseid LIMIT :start,:count");
            $stmt->bindValue(':courseid', (int) $courseid, PDO::PARAM_INT);
            $stmt->bindValue(':start', (int) $start, PDO::PARAM_INT);
            $stmt->bindValue(':count', (int) $count, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $err) {
            Logger::logError('could not select projects from courseid ' . $courseid, $err);
            return null;
        }
    }

    /**
     * Fetch a project from the database, based on its ID. 
     * @param type $id the id of the project.
     * @return type an object containing the project information or null on error.
     */
    public static function getProjectById($id) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT * FROM project WHERE id = :projectid");
            $stmt->bindValue(':projectid', (int) $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $err) {
            Logger::logError('could not select project by projectid ' . $id, $err);
            return null;
        }
    }

    /**
     * Get student list metadata about a list associated with a tutor user-ID.
     * @param type $id the id of the tutor user.
     * @return type an object containing the student list metadata or null on error. 
     */
    public static function getStudentListsFromUser($id) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT * FROM studentlist WHERE owner = :owner");
            $stmt->bindValue(':owner', (int) $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $err) {
            Logger::logError('Could not get studentlists from ower with id' . $id, $err);
            return null;
        }
    }
    
    /**
     * Get student list metadata based on it's id. 
     * @param type $listid the ID of the student list.
     * @return type an object containing the student list metadata or null on error.   
     */
    public static function getStudentListInfoFromListId($listid) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT * FROM studentlist where id = :id ");
            $stmt->bindValue(':id', (int) $listid, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $err) {
            Logger::logError('Could not get data', $err);
            return null;
        }
    }

    public static function getCoupledListsFromProject($id) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT studentlist.id, studentlist.name FROM studentlist join project_studentlist on studentlist.id = project_studentlist.studentlist where project_studentlist.project = :id ");
            $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $err) {
            Logger::logError('Could not get data', $err);
            return null;
        }
    }
    
    /**
     * Get a list of students in a student list. 
     * @param type $id the ID of the student list.
     * @return type an object containing a list of students in this studentlist or null on error.
     */
    public static function getStudentsFromStudentList($id) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT students.id, students.mail, students.firstname, students.lastname FROM students JOIN studentlist_students ON students.id = studentlist_students.student WHERE studentlist_students.studentlist = :id ");
            $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $err) {
            Logger::logError('could not select project by projectid ' . $id, $err);
            return null;
        }
    }
    
    /**
     * Get a list of students associated with a project.
     * @param type $id the ID of the project.
     * @return type an object containing a list of students associated with a project.
     */
    public static function getStudentListsFromProject($id) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT students.id, students.mail, students.firstname, students.lastname FROM students JOIN studentlist_students ON students.id = studentlist_students.student JOIN project_studentlist ON studentlist_students.studentlist = project_studentlist.studentlist WHERE project_studentlist.project = :id");
            $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $err) {
            Logger::logError('Could not select students from project', $err);
            return null;
        }
    }

    public static function getLastDropdownFromUser($id) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT * FROM lastdropdown WHERE user = :id");
            $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $err) {
            Logger::logError('Could not get last dropdowns from the database', $err);
            return null;
        }
    }

    public static function getDocumentsFromProject($id) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT * FROM documenttype WHERE project = :id");
            $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $err) {
            Logger::logError('Could not get last dropdowns from the database', $err);
            return null;
        }
    }

    /**
     * Get the number of projecttypes currently in the database 
     */
    public static function getAllProjectCount() {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT COUNT(*) FROM project");
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (PDOException $err) {
            Logger::logError('Could not count all projects in the database', $err);
            return 0;
        }
    }

    public static function getProjectCountByCourseId($courseid) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT COUNT(*) FROM project WHERE course = :courseid");
            $stmt->bindValue(':courseid', (int) $courseid, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (PDOException $err) {
            Logger::logError('Could not count all projects in the database', $err);
            return 0;
        }
    }

    /*
     * Delete a project type from the database
     * @id the projectttype id to delete
     */

    public static function deleteProject($id) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("DELETE FROM project WHERE id = :id");
            $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $err) {
            Logger::logError('Could not delete project', $err);
            return null;
        }
    }

    public static function uncoupleProjectStudentlist($projectid, $studentlistid) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("DELETE FROM project_studentlist WHERE project = :projectid AND studentlist = :studentlistid");
            $stmt->bindValue(':projectid', (int) $projectid, PDO::PARAM_INT);
            $stmt->bindValue(':studentlistid', (int) $studentlistid, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $err) {
            Logger::logError('Could not delete project', $err);
            return null;
        }
    }

    public static function deleteStudentFromStudentList($studlistid, $studid) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("DELETE FROM studentlist_students WHERE studentlist = :studlist AND student = :student");
            $stmt->bindValue(':studlist', (int) $studlistid, PDO::PARAM_INT);
            $stmt->bindValue(':student', (int) $studid, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $err) {
            Logger::logError('Could not delete project', $err);
            return null;
        }
    }

    public static function deleteStudentList($id) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("DELETE FROM studentlist WHERE id = :id");
            $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
            $stmt->execute();

            $stmt2 = $conn->prepare("DELETE FROM studentlist_students WHERE studentlist = :id");
            $stmt2->bindValue(':id', (int) $id, PDO::PARAM_INT);
            $stmt2->execute();

            $stmt3 = $conn->prepare("DELETE FROM project_studentlist WHERE studentlist =:id");
            $stmt3->bindValue(':id', (int) $id, PDO::PARAM_INT);
            $stmt3->execute();
            return true;
        } catch (PDOException $err) {
            Logger::logError('Could not delete project', $err);
            return null;
        }
    }

    public static function deleteDocumentType($id) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("DELETE FROM documenttype WHERE id = :id");
            $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $err) {
            Logger::logError('Could not delete documenttype', $err);
            return null;
        }
    }

    /*
     * Insert a new projecttype in the database 
     * @code the projecttype code
     * @name the name of the projecttype
     * @description a description about the project
     */

    public static function insertProject($courseid, $code, $name, $description) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("INSERT INTO project (code, name, description, course) VALUES (?, ?, ?, ?)");
            $stmt->execute(array($code, $name, $description, $courseid));

            // Return the id of the newly inserted item on success.
            return $conn->lastInsertId();
        } catch (PDOException $err) {
            Logger::logError('Could not create new project', $err);
            return null;
        }
    }

    public static function insertProjectStudlistCouple($projectid, $studlistid) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("INSERT INTO project_studentlist (project, studentlist) VALUES (?,?)");

            $stmt->execute(array($projectid, $studlistid));

            return $conn->lastInsertId();
        } catch (PDOException $err) {
            Logger::logError('Could not create new coupling between a project and a studentlist', $err);
            return null;
        }
    }

    public static function saveDropdownChoice($location, $locationid, $training, $trainingid, $course, $courseid, $user) {
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

    /*
     * Update projecttype in the database 
     * @param type $id the id of the projecttype to update
     * @param type $code the new projecttype code
     * @param type $name the new projecttype name
     * @param type $description the new projecttype description
     */

    public static function updateProject($id, $code, $name, $description) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("UPDATE project SET code = ?, name = ?, description = ? WHERE id = ?");
            $stmt->execute(array($code, $name, $description, $id));
            return true;
        } catch (PDOException $err) {
            Logger::logError('Could not update project', $err);
            return false;
        }
    }

    public static function updateStudentListName($id, $name) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("UPDATE studentlist SET name = ? WHERE id = ?");
            $stmt->execute(array($name, $id));
            return true;
        } catch (PDOException $err) {
            Logger::logError('Could not update project', $err);
            return false;
        }
    }
    public static function updateStudent($id, $username, $firstname, $lastname) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("UPDATE students SET mail = ?, firstname = ?, lastname = ? WHERE id = ?");
            $stmt->execute(array($username, $firstname, $lastname, $id));
            return true;
        } catch (PDOException $err) {
            Logger::logError('Could not update project', $err);
            return false;
        }
    }

    public static function updateDocuments($array) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("UPDATE documenttype SET description = ?, amount_required = ?, weight = ? WHERE id = ?");
            foreach ($array as $document) {
                $stmt->execute(array((string) $document->description, (int) $document->amount_required, (int) $document->weight, (int) $document->id));
            }
            return true;
        } catch (PDOException $err) {
            Logger::logError('Could not update project', $err);
            return false;
        }
    }

    public static function insertDocuments($projectid, $array) {
        try {
            // Insert the user
            $conn = Db::getConnection();
            $stmt = $conn->prepare("INSERT INTO documenttype (description, amount_required, weight, project) VALUES (?, ?, ?,?)");
            foreach ($array as $document) {
                $stmt->execute(array((string) $document->description, (int) $document->amount_required, (int) $document->weight, (int) $projectid));
            }
            return true;
        } catch (PDOException $err) {
            Logger::logError('Could not get locations', $err);
            return false;
        }
    }

    /*
     * Get all the locations
     */

    public static function getAllLocations() {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT * FROM location");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $err) {
            Logger::logError('Could not get locations', $err);
            return false;
        }
    }

    /*
     * Get all trainings by locationId
     * @id the locationId
     */
    public static function getTrainingsByLocation($id) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT * FROM training WHERE location = :location");
            $stmt->bindValue(':location', (int) $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $err) {
            Logger::logError('Could not get locations', $err);
            return false;
        }
    }

    /**
     * Get a list of courses associated with a training.
     * @param type $id the trainings id to get the courses information from.
     * @return stdClass an object containing courses information
     */
    public static function getCoursesByTraining($id) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT * FROM course WHERE training = :training");
            $stmt->bindValue(':training', (int) $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $err) {
            Logger::logError('Could not get courses', $err);
            return null;
        }
    }

    /**
     * Get's all the data associated with a project. 
     * @param type $id the project id to get the data from. 
     * @return stdClass an object containing all project information or null on error. 
     */
    public static function getAllDataFromProject($id) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT competence.id cid, competence.code ccode, competence.description cdescription, competence.max cmax, competence.weight cweight, subcompetence.id sid, subcompetence.code scode, subcompetence.description sdescription, subcompetence.weight sweight, subcompetence.max smax, subcompetence.min_required smin_required, indicator.id iid, indicator.name iname, indicator.description idescription, indicator.max imax, indicator.weight iweight
                                    FROM competence JOIN subcompetence ON competence.id = subcompetence.competence
                                    JOIN indicator ON subcompetence.id = indicator.subcompetence WHERE project = :projectid ORDER BY cid, sid, iid ASC");
            $stmt->bindValue(':projectid', (int) $id, PDO::PARAM_INT);
            $stmt->execute();
            $dataFromDb = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $data = array();
            foreach ($dataFromDb as $row) {
                if (!array_key_exists($row['cid'], $data)) {
                    $competence = new stdClass();
                    $competence->subcompetences = array();
                    $competence->id = $row['cid'];
                    $competence->code = $row['ccode'];
                    $competence->description = $row['cdescription'];
                    $competence->max = $row['cmax'];
                    $competence->weight = $row['cweight'];

                    $data[$row['cid']] = $competence;
                }

                if (!array_key_exists($row['sid'], $competence->subcompetences)) {
                    $subcompetence = new stdClass();
                    $subcompetence->indicators = array();
                    $subcompetence->id = $row['sid'];
                    $subcompetence->code = $row['scode'];
                    $subcompetence->description = $row['sdescription'];
                    $subcompetence->weight = $row['sweight'];
                    $subcompetence->max = $row['smax'];
                    $subcompetence->minRequired = $row['smin_required'];

                    $competence->subcompetences[$row['sid']] = $subcompetence;
                }

                if (!array_key_exists($row['iid'], $subcompetence->indicators)) {
                    $indicator = new stdClass();
                    $indicator->id = $row['iid'];
                    $indicator->name = $row['iname'];
                    $indicator->description = $row['idescription'];
                    $indicator->max = $row['imax'];
                    $indicator->weight = $row['iweight'];

                    $subcompetence->indicators[$row['iid']] = $indicator;
                }
            }


            return $data;
        } catch (PDOException $err) {
            Logger::logError('Could not get all data from project with id ' . $id, $err);
            return null;
        }
    }
    
    
    /**
     * Insert a new competence in the database.
     * @param type $code
     * @param type $description 
     * @param type $max
     * @param type $weight
     * @param type $projectid
     * @return type the id of the newly inserted competence or null on error.
     */
    public static function putNewCompetence($code, $description, $max, $weight, $projectid) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("INSERT INTO competence (code, description, max, weight, project) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute(array($code, $description, $max, $weight, $projectid));
            $pid = $conn->lastInsertId();

            return $pid;
        } catch (PDOException $err) {
            echo $err;
            return null;
        }
    }
    
    /**
     * Update an existing competence in the database
     * @param type $id
     * @param type $code
     * @param type $description
     * @param type $max
     * @param type $weight
     * @param type $projectid
     * @return boolean true on success, false on error.
     */
    public static function updateCompetence($id, $code, $description, $max, $weight, $projectid) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("UPDATE competence SET code = ?, description = ?, max = ?, weight = ?, project = ? WHERE id = ?");
            $stmt->execute(array($code, $description, $max, $weight, $projectid, $id));

            return true;
        } catch (PDOException $err) {
            echo $err;
            return false;
        }
    }
    
    /**
     * Insert a new subcompetence in the database.
     * @param type $code
     * @param type $description
     * @param type $max
     * @param type $weight
     * @param type $min_required
     * @param type $competenceid
     * @return type the id of the newly inserted subcompetence or null on error.
     */
    public static function putNewSubCompetence($code, $description, $max, $weight, $min_required, $competenceid) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("INSERT INTO subcompetence (code, description, weight, max, min_required, competence) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute(array($code, $description, $weight, $max, $min_required, $competenceid));
            $sid = $conn->lastInsertId();

            return $sid;
        } catch (PDOException $err) {
            echo $err;
            return null;
        }
    }
    
    /**
     * Update an existing subcompetence in the database.
     * @param type $id
     * @param type $code
     * @param type $description
     * @param type $max
     * @param type $weight
     * @param type $min_required
     * @param type $competenceid
     * @return type true if update is success, false otherways
     */
    public static function updateSubCompetence($id, $code, $description, $max, $weight, $min_required, $competenceid) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("UPDATE subcompetence SET code = ?, description = ?, weight = ?, max = ?, min_required = ?, competence = ? WHERE id = ?");
            $stmt->execute(array($code, $description, $weight, $max, $min_required, $competenceid, $id));

            return true;
        } catch (PDOException $err) {
            echo $err;
            return false;
        }
    }
    
    /**
     * Insert a new indicator in the database
     * @param type $name
     * @param type $description
     * @param type $max
     * @param type $weight
     * @param type $subcompetenceid
     * @return type the id of the newly inserted indicator or null on error.
     */
    public static function putNewIndicator($name, $description, $max, $weight, $subcompetenceid) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("INSERT INTO indicator (name, description, max, weight, subcompetence) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute(array($name, $description, $max, $weight, $subcompetenceid));
            $iid = $conn->lastInsertId();

            return $iid;
        } catch (PDOException $err) {
            echo $err;
            return null;
        }
    }
    
    /**
     * Update an existing indicator in the database
     * @param type $id
     * @param type $name
     * @param type $description
     * @param type $max
     * @param type $weight
     * @param type $subcompetenceid
     * @return boolean true on succes, false on error
     */
    public static function updateIndicator($id, $name, $description, $max, $weight, $subcompetenceid) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("UPDATE indicator SET name = ?, description = ?, max = ?, weight = ?, subcompetence = ? WHERE id = ?");
            $stmt->execute(array($name, $description, $max, $weight, $subcompetenceid, $id));

            return true;
        } catch (PDOException $err) {
            echo $err;
            return false;
        }
    }
    public static function putStudentList($userid, $username) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("INSERT into studentlist (owner, name) VALUES (?, ?)");
            $stmt->execute(array($userid, $username.' - New User List '));
            return $conn->lastInsertId();
        } catch (Exception $ex) {
            return -1;
        }
    }

    public function putStudents($listid, $studentArray) {
            try {
                $conn = Db::getConnection();
                $stmt = $conn->prepare("INSERT into students (firstname, lastname, mail) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id)");
                foreach($studentArray as $student) {
                    if($student[4] != "Titularis") {
                        $stmt->execute(array($student[1], $student[2], $student[3]));
                        $id = $conn->lastInsertId();
                        $stmt2 = $conn->prepare("INSERT into studentlist_students (studentlist, student) VALUES (?, ?)");
                        $stmt2->execute(array($listid, $id));
                    }
                }
                return $conn->lastInsertId();
            } catch (PDOException $ex) {
                /*Logger::logError("could not insert new student".$ex);*/
                return "could not insert new student".$ex;
            }

    }

    public static function putStudent($mail, $firstname, $lastname) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("INSERT into students (firstname, lastname, mail) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id)");
            $stmt->execute(array($firstname, $lastname, $mail));
            return $conn->lastInsertId();
        } catch (PDOException $ex) {
            Logger::logError("could not insert new student".$ex);
        }
    }

    public static function putStudentlist_Student($studentid, $listid) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("INSERT into studentlist_students (student, studentlist) VALUES (?, ?)");
            $stmt->execute(array($studentid, $listid));
            return $conn->lastInsertId();
        } catch (PDOException $ex) {
            Logger::logError("could not insert new student".$ex);
        }
    }

    public static function getProjectRules($id)
    {
        try
        {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT * FROM rules WHERE project = ?");
            $stmt->execute(array($id));
            $dataFromDb = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $data = array();
            foreach ($dataFromDb as $row) {
                if (!array_key_exists($row['id'], $data)) {
                    $rule = new stdClass();
                    $rule->id = $row['id'];
                    $rule->name = $row['name'];
                    $rule->action = $row['action'];
                    $rule->operator = $row['operator'];
                    $rule->value = $row['value'];
                    $rule->result = $row['result'];

                    $data[$row['id']] = $rule;
                }
            }

            return $data;
        }
        catch (PDOException $ex)
        {
            Logger::logError("could not get project rules. ".$ex);
        }
    }

    public static function saveProjectRules($id, $projectrules)
    {
        try
        {
            $conn = Db::getConnection();
            foreach($projectrules as $rule) {
                if(isset($rule['id']))
                {
                    $stmt = $conn->prepare("UPDATE rules SET project=?, name=?, action=?, operator=?, value=?, result=? WHERE id=?");
                    $stmt->execute(array($id,$rule['name'],$rule['action'],$rule['operator'], $rule['value'], $rule['result'], $rule['id']));
                }
                else
                {
                    $stmt = $conn->prepare("INSERT into rules (project, name, action, operator, value, result) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->execute(array($id,$rule['name'],$rule['action'],$rule['operator'], $rule['value'], $rule['result']));
                }
            }

            return true;
        }
        catch (PDOException $ex)
        {
            Logger::logError("could not save project rules. ".$ex);
        }
    }
}

/*
 * Database Access Object for accessing account information
 */
class UserDAO {

    /**
     * Get account information given the users username.
     * @param type $username the username to get information from.
     * @param type $clean if clean is true the output will be filtered for public use. 
     * @return stdClass an object containing the user or null on error.
     */
    public static function getUserByUsername($username, $clean = true) {
        try {
            $conn = Db::getConnection();
            if (!$clean) {
                $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
            } else {
                $stmt = $conn->prepare("SELECT id, username, avatar, firstname, lastname, created FROM users WHERE username = ?");
            }
            $stmt->execute(array($username));
            $data = $stmt->fetchObject();

            // Fetch an avater when it is not null
            if ($data != null) {
                $file_id = $data->avatar;
                if ($file_id != null) {
                    $data->avatar = FileDAO::getUpload($file_id);
                }
            }

            return $data;
        } catch (PDOException $err) {
            return null;
        }
    }

    /**
     * Get account information based on a user token.
     * @param type $token the users token.
     * @return stdClass the user associated with a token or null on error.
     */
    public static function getUserByToken($token) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT * FROM users WHERE activation_key = ?");
            $stmt->execute(array($token));
            return $stmt->fetchObject();
        } catch (PDOException $err) {
            return null;
        }
    }

    /**
     * Get account information based on a user token.
     * @param type $role the role of the users.
     * @return stdClass the users associated with the roles.
     */
    public static function getUsersByRole($role)
    {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT r.role FROM roles r INNER JOIN user_roles ur ON ur.role_id = r.id INNER JOIN users us ON us.id = ur.user_id WHERE r.role = ?");
            $stmt->execute(array($role));
            return $stmt->fetchObject();
        } catch (PDOException $err) {
            return null;
        }
    }
    
    /**
     * Check if a username exists.
     * @param type $username the username to check.
     * @return boolean true if the user exist, false otherways and null on error.
     */
    public static function doesUserExist($username) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
            $stmt->execute(array($username));
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $err) {
            return null;
        }
    }

    /**
     * Check if an email is registered. 
     * @param type $email the email address to check.
     * @return boolean true if the email address is registered, false otherways and null on error.
     */
    public static function doesEmailExist($email) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT COUNT(*) FROM email WHERE adress = ? AND registration = 1");
            $stmt->execute(array($email));
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $err) {
            return null;
        }
    }

    /**
     * Check if a token is unique. 
     * @param type $token the token to check.
     * @return boolean true if the token exists, false otherways and null on error.
     */
    public static function doesUsertokenExist($token) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE activation_key = ?");
            $stmt->execute(array($token));
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $err) {
            return null;
        }
    }

    /**
     * Create a new user in the database 
     * @param type $lang the users preferred language.
     * @param type $email the users primary email address.
     * @param type $username the users username, may be equal to email.
     * @param type $firstname the firstname of the user.
     * @param type $lastname the lastname of the user.
     * @param type $password the users password, must allready be hashed. 
     * @param type $token the users token if any. 
     * @param type $status the users activation status. 
     * @return type the userid of the newly created user or null on error.
     */
    public static function createUser($lang, $email, $username, $firstname, $lastname, $password, $token, $status) {
        try {
            // the user
            $conn = Db::getConnection();
            $stmt = $conn->prepare("INSERT INTO users (username, lang, firstname, lastname, password, activation_key, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute(array($username, $lang, $firstname, $lastname, $password, $token, $status));
            $uid = $conn->lastInsertId();

            // Insert the email adress
            $stmt = $conn->prepare("INSERT INTO email (user_id, adress, type, registration) VALUES (?, ?, 'PERSONAL', 1)");
            $stmt->execute(array($uid, $email));

            return $uid;
        } catch (PDOException $err) {
            echo $err;
            return null;
        }
    }
    
    /**
     * Update the uers avatar. 
     * @param type $userid the id of the user to update
     * @param type $imageid the id of the imagefile
     * @return boolean true on success false on error
     */
    public static function updateUserProfilePicture($userid, $imageid) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("UPDATE users SET avatar = ? WHERE id = ?");
            $stmt->execute(array($imageid, $userid));
            return true;
        } catch (PDOException $err) {
            Logger::logError('Could not update project', $err);
            return false;
        }
    }

    /**
     * Searches the activation token in the database and if present activates the users account. 
     * @param type $token the token to activate. 
     * @return boolean true if the user could be activated, false otherways and null on error.
     */
    public static function activateUser($token) {
        try {
            // First check if the token exists
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE activation_key = ?");
            $stmt->execute(array($token));

            // Quit when the token cannot be found
            if ($stmt->fetchColumn() == 0) {
                return false;
            }

            // Remove the activation token and set account to activated
            $conn = Db::getConnection();
            $stmt = $conn->prepare("UPDATE users SET activation_key = '', status='ACTIVE' WHERE activation_key = ?");
            $stmt->execute(array($token));

            return true;
        } catch (PDOException $err) {
            echo $err;
            return null;
        }
    }

    /**
     * Get all the roles from a certain user. 
     * @param type $username the username to search the roles from. 
     * @return type an array containing all the roles associated with the username, null on error. 
     */
    public static function getUserRoles($username) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT r.role FROM roles r INNER JOIN user_roles ur ON ur.role_id = r.id INNER JOIN users us ON us.id = ur.user_id WHERE us.username = ?");
            $stmt->execute(array($username));
            return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        } catch (PDOException $err) {
            return null;
        }
    }

    /**
     * Get all permissions associated with role.
     * @param type $role the role you want to get the permissions from.
     * @return type an array of permissions associated with a role.
     */
    public static function getPermissionsFromRole($role) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT p.permission FROM permissions p INNER JOIN role_permissions rp ON p.id = rp.permission_id INNER JOIN roles r ON r.id = rp.role_id WHERE r.role = ?");
            $stmt->execute(array($role));
            return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        } catch (PDOException $err) {
            return null;
        }
    }

}

/**
 * Class mananging all email based transactions. 
 */
class EmailDAO {
    
    /**
     * Get an email in a specified language from the database.
     * @param type $tag the email tag. 
     * @param type $lang the required email language.
     * @return type an object containing email information from the database or null on error.
     */
    public static function getEmail($tag, $lang) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT * FROM emailtemplates WHERE tag = ? AND lang = ?");
            $stmt->execute(array($tag, $lang));
            return $stmt->fetchObject();
        } catch (PDOException $err) {
            return null;
        }
    }

}

/**
 * Class managing all file upload information
 */
class FileDAO {

    /**
     * Get the name of an uploaded file based on it's ID. 
     * @param type $id the ID of the uploaded file.
     * @return type the name of an uploaded file or null on error.
     */
    public static function getUpload($id) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT filename FROM uploads WHERE id = ?");
            $stmt->execute(array($id));
            return $stmt->fetchColumn();
        } catch (Exception $ex) {
            return null;
        }
    }
    
    /**
     * Put a new upload in the database.
     * @param type $name the name of the newly uploaded file.
     * @return type the ID of the new file or -1 on error.
     */
    public static function putUpload($name) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("INSERT into uploads (filename) VALUES (?)");
            $stmt->execute(array($name));
            return $conn->lastInsertId();
        } catch (Exception $ex) {
            return -1;
        }
    }
}

?>