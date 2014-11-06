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

     /* Log file */
     public static $logfile = './logfile.log';
 }
?>