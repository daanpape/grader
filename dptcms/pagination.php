<?php

/*
 * DPTechnics CMS
 * Pager module
 * Author: Daan Pape
 * Date: 04-09-2014
 */

// Load required files
require_once('config.php');

class Pager {
	
	/*
	 * Convert a page number and itemcount to start and count for sql pagination
	 * @page: the page number
	 * @itemcount: the number of items on a page
	 */
	public static function pageToStartStop($page, $itemcount = -1)
	{
		// Use default pagecount when none is specified
		if($itemcount == -1) {
			$itemcount = Config::$pageCount;
		}
		
		// Save result in standard object
		$result = new stdClass();
		$result->start = ($page - 1) * $itemcount;
		$result->count = $itemcount;
		
		return $result;
	}
}