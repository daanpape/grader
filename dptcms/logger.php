<?php
/*
 * DPTechnics CMS
 * Logging page for warnings, info and error
 * Author: Daan Pape
 * Date: 04-09-2014
 */

// Load required files
require_once('config.php');

class Logger {

    public static function logInfo($nice, $raw = '')
    {
        error_log(date("Y-m-d H:i:s")." : LOG_LEVEL->info: ".$nice." ".$raw."\r\n", 3, Config::$logfile);
    }

    public static function logWarning($nice, $raw = '')
    {
        error_log(date("Y-m-d H:i:s")." : LOG_LEVEL->warning: ".$nice." ".$raw."\r\n", 3, Config::$logfile);
    }

    public static function logError($nice, $raw = '')
    {
        error_log(date("Y-m-d H:i:s")." : LOG_LEVEL->error: ".$nice." ".$raw."\r\n", 3, Config::$logfile);
    }
}

?>