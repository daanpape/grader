<?php

/*
 * Grader API functions 
 */
 
 // Load required files
 require_once('dptcms/database.php');
 
 // Database class for connection handling
 class GraderAPI 
 {
	public static function getProjectTypes($start, $count)
	{
		/* Return the requested pages */
		echo json_encode(ClassDAO::getAllProjectTypes($start, $count));
	}
 }