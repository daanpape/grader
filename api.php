<?php

/*
 * Grader API functions 
 */
 
 // Load required files
 require_once('dptcms/database.php');
 
 // Database class for connection handling
 class GraderAPI 
 {
	/*
	 * Get a page from currently stored projecttypes. 
	 * @start: the item start with
	 * @count: the number of items on the page 
	 */
	public static function getProjectTypes($start, $count)
	{
		/* Return the requested pages */
		return ClassDAO::getAllProjectTypes($start, $count);
	}
	
	/*
	 * Delete a projecttype from the database
	 */
	public static function deleteProjectType($id)
	{
		if(ClassDAO::deleteProjectType($id) === true) {
			return true;
		} else {
			return false;
		}
	}
 }