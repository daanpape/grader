<?php

class rapportenDAO {
    public static function getAllCourses($start, $count) {
        try {
            $conn = Db::getConnection();
            $stmt = $conn->prepare("SELECT * FROM course_rapport LIMIT :start,:count");
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
            $stmt = $conn->prepare("SELECT * FROM course_rapport");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $err) {
            Logger::logError('Could not get courses', $err);
            return false;
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
}

?>