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
    
    /*
     * Construct an array with current data, and links to current and 
     * next pages. 
     * @curpage: the current page number. 
     * @data: the data for the table
     * @totalrows: the total number of data
     */
    public static function genPaginatedAnswer($curpage, $data, $totalrows, $itemcount = -1)
    {
        // Use default pagecount when none is specified
        if($itemcount == -1) {
            $itemcount = Config::$pageCount;
        }
        
        /* First add data */
        $array["data"] = $data;
        
        /* Calculate total pagecount */
        $nrpages = ceil($totalrows/$itemcount);
        
        /* Add total pagecount for rendering */
        $array["pagecount"] = $nrpages;
        
        /* Add current page */
        $array["current"] = (integer) $curpage;
        
        /* Calculate link to previous page */
        if($curpage <= 1) {
            $array["prev"] = "none";
        } else {
            $array["prev"] = ($curpage - 1);
        }
        
        /* Calculate link to next page */
        if($curpage >= $nrpages) {
            $array["next"] = "none";
        } else {
            $array["next"] = ($curpage + 1);
        }

        return $array;
    }
}