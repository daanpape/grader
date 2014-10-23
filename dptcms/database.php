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
    public static function getAllProjectTypes($start, $count) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT * FROM projecttype LIMIT :start,:count");
            $stmt->bindValue(':start', (int) $start, PDO::PARAM_INT);
            $stmt->bindValue(':count', (int) $count, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $err) {
            Logger::logError('could not select all projecttypes', $err);
            return null;
        }
    }

    /*
     * Delete a project type from the database
     * @id the projectttype id to delete
     */
    public static function deleteProjectType($id) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("DELETE FROM projecttype WHERE id = :id");
            $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $err) {
            Logger::logError('Could not delete projecttype', $err);
            return null;
        }
    }

    /*
     * Insert a new projecttype in the database 
     * @code the projecttype code
     * @name the name of the projecttype
     * @description a description about the project
     */
    public static function insertProjectType($code, $name, $description) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("INSERT INTO projecttype (code, name, description) VALUES (?, ?, ?)");
            $stmt->execute(array($code, $name, $description));

            // Return the id of the newly inserted item on success.
            return $conn->lastInsertId();
        } catch (PDOException $err) {
            Logger::logError('Could not create new projecttype', $err);
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
    public static function updateProjectType($id, $code, $name, $description) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("UPDATE projecttype SET code = ?, name = ?, description = ? WHERE id = ?");
            $stmt->execute(array($code, $name, $description, $id));
            return true;
        } catch (PDOException $err) {
            Logger.logError('Could not update projecttype', $err);
            return false;
        }
    }
}

?>