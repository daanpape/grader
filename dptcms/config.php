<?php
/*
 * DPTechnics CMS
 * Framework configuration 
 * Author: Daan Pape
 * Date: 18-08-2014
 */
 
 class Config {
 
    /* Site configuration */
    public static $siteURL	= 'http://dptknokke.ns01.info:9000';

    /* Database configuration */
    public static $dbServer = 'localhost';
    public static $dbPort 	= '3306';
    public static $dbName 	= 'grader';
    public static $dbUser 	= 'grader-site';
    public static $dbPass 	= 'YEpKuhq25fMY4xUG';

    /* Pagination settings */
    public static $pageCount	= 20;

    /**
     * Controls the destination of the logging. Set to syslog or file.
     * When set to file, define public static $logfile.
     * @var string Either 'syslog' or 'file'
     */
    public static $logDestination = 'file';
    /**
     * When $logDestination is set to 'file', this variable controls which file
     * logging goes to.
     * @var string A filepath
     */
     public static $logfile = './logfile.log';
     
   /*
    * Image upload settings
    */
    public static $fileImgSupport          = array("image/gif", "image/jpeg", "image/jpg", "image/pjpeg", "image/x-png", "image/png", "application/vnd.ms-excel","text/plain", "text/csv", "text/tsv", "application/octet-stream", "");
    public static $fileFriendlySupport     = 'GIF, JPEG, PNG, CSV';
    public static $fileMaxSize             = 4096;
    public static $fileDestination	  = 'upload';
 }
?>