<?php
/*
 * DPTechnics CMS
 * Logging page for warnings, info and error
 * Author: Daan Pape
 * Date: 04-09-2014
 */

// Load required files
require_once('config.php');

/**
 * @notes This is a messy class. It should be refactored.
 */
class Logger {

    public static function logInfo($nice, $raw = '')
    {
        if(Config::$logDestination == 'syslog')
        {
            error_log('['.date("Y-m-d H:i:s")."][INFO] ".$nice." ".$raw."\r\n");
        }
        else
        {
            error_log('['.date("Y-m-d H:i:s")."][INFO] ".$nice." ".$raw."\r\n", 3, Config::$logfile);
        }
    }

    public static function logWarning($nice, $raw = '')
    {
        if(Config::$logDestination == 'syslog')
        {
            error_log('['.date("Y-m-d H:i:s")."][WARNING] ".$nice." ".$raw."\r\n");
        }
        else
        {
            error_log('['.date("Y-m-d H:i:s")."][WARNING] ".$nice." ".$raw."\r\n", 3, Config::$logfile);
        }
    }

    public static function logError($nice, $raw = '')
    {
        if(Config::$logDestination == 'syslog')
        {
            error_log('['.date("Y-m-d H:i:s")."][ERROR] ".$nice." ".$raw."\r\n");
        }
        else
        {
            error_log('['.date("Y-m-d H:i:s")."][ERROR] ".$nice." ".$raw."\r\n", 3, Config::$logfile);
        }
    }
}

?>