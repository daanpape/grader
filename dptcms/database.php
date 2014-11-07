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

// Database class for connection handling
class Db {
    /*
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

/*
 * Database Access Object for manipulating projecttypes, competencetypes, ...
 */

class ClassDAO {
    /*
     * Get all projecttypes in pagination form
     * @start: the row number to start with (offset 0)
     * @count: the number of rows to return
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

    /*
     * Insert a new projecttype in the database 
     * @code the projecttype code
     * @name the name of the projecttype
     * @description a description about the project
     */

    public static function insertProject($code, $name, $description) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("INSERT INTO project (code, name, description) VALUES (?, ?, ?)");
            $stmt->execute(array($code, $name, $description));

            // Return the id of the newly inserted item on success.
            return $conn->lastInsertId();
        } catch (PDOException $err) {
            Logger::logError('Could not create new project', $err);
            return null;
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
            Logger . logError('Could not update project', $err);
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

    /*
     * Get all courses by trainingid
     * @id the trainingid
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
            return false;
        }
    }

    public static function getFirstCoursesByLocation($id) {
        try {
//           $conn = Db::getConnection();
//            $stmt1 = $conn->prepare("SELECT TOP 1 id FROM training WHERE location = :location");
//            $stmt1->bindValue(':location', (int) $id, PDO::PARAM_INT);
//            $stmt1->execute();
//
//            $stmt2 = $conn->prepare("SELECT * from course WHERE training = :training");
//            $stmt2->bindValue(':training', (int) $stmt1->fetchAll(PDO::FETCH_CLASS), PDO::PARAM_INT);
//            $stmt2->execute();
//
//            return $stmt2->fetchAll(PDO::FETCH_CLASS);
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT * FROM course WHERE training.location = :location JOIN training on course.training = training.id");
            $stmt->bindValue(':LOCATION', (int) $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);

        } catch (PDOException $err) {
            Logger::logError('Could not get courses', $err);
            return false;
        }
    }
}


/*
 * Database Access Object for accessing account information
 */

class UserDAO {
    /*
     * Get a user given the username.
     */

    public static function getUserByUsername($username) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute(array($username));
            return $stmt->fetchObject();
        } catch (PDOException $err) {
            return null;
        }
    }

    /*
     * Get a user given the token
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

    /*
     * Returns true if the username exists in the database
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

    /*
     * Returns true if the email exists in the database
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

    /*
     * Returns true if the token exists in the database
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

    /*
     * Create a user in the system and return the new UserId. 
     */

    public static function createUser($lang, $email, $username, $firstname, $lastname, $password, $token, $status) {
        try {
            // Insert the user 
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

    /*
     * Searches the activation token in the database and if
     * it is present activates the user account. 
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

    /*
     * Get all the user roles given the username
     */

    public static function getUserRoles($username) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT r.role FROM roles r INNER JOIN user_roles ur ON ur.role_id = r.id INNER JOIN users us ON us.id = ur.user_id WHERE us.username = ?");
            $stmt->execute(array($username));
            return $stmt->fetchAll();
        } catch (PDOException $err) {
            return null;
        }
    }

    /*
     * Return all the permissions for the guest user as an array. 
     */

    public static function getGuestPermissions() {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT p.permission FROM permissions p INNER JOIN role_permissions rp ON p.id = rp.permission_id INNER JOIN roles r ON r.id = rp.role_id WHERE r.role = 'GUEST'");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $err) {
            return null;
        }
    }

    /*
     * Get all the user permissions given the user roles 
     */

    public static function getUserPermissions($roles) {
        //TODO
    }

}

class EmailDAO {
    
    /*
     * Get an email from the database
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

?>