<?php

/*
 * DPTechnics CMS
 * Database module
 * Author: Daan Pape
 * Date: 18-08-2014
 */
 
 // Load required files
 require_once('config.php');
 
 // Database class for connection handling
 class Db 
 {
	/*
	 * Get the PDO database connection object
	 */
	public static function getConnection() 
	{
	
		// Construct the PDO adress line
		$host = Config::$dbServer;
		$port = Config::$dbPort;
		$database = Config::$dbName;
		$dsn = "mysql:host=$host;port=$port;dbname=$database";
		
		// Try to connect to the database
		try
		{
			$conn = new PDO($dsn, Config::$dbUser, Config::$dbPass); 
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $conn;
		}
		catch(PDOException $err)
		{
			//TODO: handle exceptions
			return null;
		}
	}
 }
 
 /*
  * Database Access Object for manipulating projecttypes, competencetypes, ...
  */
 class ClassDAO
 {
	/*
	 * Get all projecttypes in pagination form
	 * @start: the row number to start with (offset 0)
	 * @count: the number of rows to return
	 */
	public static function getAllProjectTypes($start, $count)
	{
		try
		{
			$conn = Db::getConnection();
			$stmt = $conn->prepare("SELECT * FROM projecttype LIMIT :start,:count");
			$stmt->bindValue(':start', (int) $start, PDO::PARAM_INT);
			$stmt->bindValue(':count', (int) $count, PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_CLASS);
		}
		catch(PDOException $err)
		{
			return $err;
		}
	}
 }
?>