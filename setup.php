<?php
session_start();

class StepController
{
    private $Steps;
    
    public function __construct()
    {
        
        $this->Steps = array(
            'Step000_sysreq',
            'Step001_database',
            'Step002_dbconnect',
            'Step310_dbcreate',
            'Step311_siteconfig',
            'Step314_createconfig',
            'Step400_complete'
        );
        
        if(!isset($_SESSION['currentStep']))
        {
            $_SESSION['currentStep'] = $this->GetInitialStep();
        }
    }
    
    public function GetCurrentStep()
    {
        return $_SESSION['currentStep'];
    }
    
    public function GetInitialStep()
    {
        return $this->Steps[0];
    }
    
    public function Advance()
    {
        $C = new $_SESSION['currentStep'];
        if($C->OKForNextStep()) {
            $_SESSION['currentStep'] = $this->Steps[array_search($this->GetCurrentStep(), $this->Steps) + 1];
            return $_SESSION['currentStep'];
        }

        throw new \LogicException("Cannot advance to the next step: The requirements of the previous step have not been fulfilled (OKForNextStep = false)");
    }
    
    public function Recede()
    {
        $_SESSION['currentStep'] = $this->Steps[array_search($this->GetCurrentStep(), $this->Steps) - 1];
        return $_SESSION['currentStep'];
    }
}


interface ISetupStep
{
    /**
     * Check if we're OK to advance to the next step.
     * @returns boolean
     */
    public function OKForNextStep();
}

class Step314_createconfig implements ISetupStep
{
    private $configFile;
    
    public function __construct()
    {
        $this->configFile = 'dptcms/config.php';
    }
    
    public function OKForNextStep()
    {
        return true;
    }

    
    public function writeConfig()
    {
        $DBDetails = $_SESSION['Step001_database'];
        $config = <<<EOD
<?php
class Config
{
    /* Site configuration */
    public static \$siteURL	= '{$_SESSION['Step311_siteconfig']['siteURL']}';

    /* Database configuration */
    public static \$dbServer = '{$DBDetails['SQLHost']}';
    public static \$dbPort 	= '3306';
    public static \$dbName 	= '{$DBDetails['SQLDBName']}';
    public static \$dbUser 	= '{$DBDetails['SQLUser']}';
    public static \$dbPass 	= '{$DBDetails['SQLPassword']}';

    /* Pagination settings */
    public static \$pageCount	= 20;

    /* Log file */
    public static \$logfile = './logfile.log';

    /*
     * Image upload settings
     */
    public static \$fileImgSupport      = array("image/gif", "image/jpeg", "image/jpg", "image/pjpeg", "image/x-png", "image/png", "application/vnd.ms-excel","text/plain", "text/csv", "text/tsv", "application/octet-stream", "");
    public static \$fileFriendlySupport = 'GIF, JPEG, PNG, CSV';
    public static \$fileMaxSize         = 4096;
    public static \$fileDestination     = 'upload';
}
?>
EOD;
    
        if(file_exists($this->configFile))
        {
            if(filesize($this->configFile) > 0)
            {
                return array(
                    'success' => false,
                    'error' => "File '{$this->configFile}' already exists and filesize > 0 bytes",
                    'config' => $config
                );
            }
        }
    
        if(is_writable($this->configFile))
        {
            if(file_put_contents($this->configFile, $config) === false)
            {
                $errors = error_get_last();
                return array('success' => false, 'error' => $errors['message'], 'config' => $config);
            }
            else
            {
                if(!@chmod($this->configFile, 0444))
                {
                    $error = "Failed to chmod file to 0444, please adjust manually: chmod 444 {$this->configFile}";
                }
                else
                {
                    $error = null;
                }
                return array('success' => true, 'error' => $error);
            }
        }
        else
        {
            return array(
                'success' => false,
                'error' => "File {$this->configFile} isn't writeable for the webserver",
                'config' => $config
            );
        }
    }
}

class Step311_siteconfig implements ISetupStep
{
    public function __construct()
    {
        if(!isset($_SESSION['Step311_siteconfig']))
        {
            if($_SERVER['SERVER_PORT'] == 80 && $_SERVER['REQUEST_SCHEME'] == 'http')
            {
                $Port = null;
            }
            elseif($_SERVER['SERVER_PORT'] == 443 && $_SERVER['REQUEST_SCHEME'] == 'https')
            {
                $Port = null;
            }
            else
            {
                $Port = $_SERVER['SERVER_PORT'];
            }

            $siteURL = $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["SERVER_NAME"] . $Port;
        
            $_SESSION['Step311_siteconfig']['siteURL'] = $siteURL;
        }
    }
    
    public function OKForNextStep()
    {
        return true;
    }

    public function saveValues()
    {
        $siteConfig = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        foreach($siteConfig as $key => $value)
        {
            $_SESSION['Step311_siteconfig'][$key] = $value;
        }
    }
    
    public function retrieveValues()
    {
        return $_SESSION['Step311_siteconfig'];
    }
}

class Step310_dbcreate implements ISetupStep
{
    public function __construct()
    {
        if(!isset($_SESSION['Step310_dbcreate']['OKForNextStep']))
        {
            $_SESSION['Step310_dbcreate']['OKForNextStep'] = false;
        }
    }
    
    
    public function CreateDB()
    {
        $DBDetails = $_SESSION['Step001_database'];
        
        if($DBDetails['createUserAndDB'] == 'true')
        {
            $RootDB = new \PDO("mysql:host={$DBDetails['SQLHost']}", $DBDetails['SQLRootUser'], $DBDetails['SQLRootPassword']);
            $Log[] = 'Connected to database server';
            $RootDB->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $Query = $RootDB->prepare("SHOW DATABASES;");
            $Query->execute();
            if(!in_array($DBDetails['SQLDBName'], $Query->fetchAll(\PDO::FETCH_COLUMN, 0)))
            {
                $Log[] = "Database {$DBDetails['SQLDBName']} doesn't exist, creating";
                $Query = $RootDB->prepare("CREATE DATABASE `{$DBDetails['SQLDBName']}` CHARACTER SET = 'utf8' COLLATE = 'utf8_unicode_ci';");
                try
                {
                    $Query->execute();
                }
                catch (Exception $ex)
                {
                    $Log[] = "FAIL: Couldn't create database: {$ex->getMessage()}";
                    return $Log;
                }
            }

            $Query = $RootDB->prepare("SELECT User FROM mysql.user WHERE User = :User AND Host = '%';");
            $Query->bindValue(':User', $DBDetails['SQLUser']);
            $Query->execute();
            if(count($Query->fetchAll()) == 0)
            {
                $Log[] = "Database user {$DBDetails['SQLUser']} doesn't exist, creating";
                try
                {
                    $Query = $RootDB->prepare("CREATE USER '{$DBDetails['SQLUser']}'@'%' IDENTIFIED BY '{$DBDetails['SQLPassword']}';");
                    $Query->execute();
                    $Query = $RootDB->prepare("GRANT SELECT, INSERT, UPDATE, DELETE, LOCK TABLES ON `{$DBDetails['SQLDBName']}`.* TO '{$DBDetails['SQLUser']}'@'%';");
                    $Query->execute();
                    $RootDB->exec("FLUSH PRIVILEGES;");
                }
                catch (Exception $ex)
                {
                    $Log[] = "FAIL: Couldn't create user: {$ex->getMessage()}";
                    return $Log;
                }
            }
            
            $DB = $RootDB;
        }
        else
        {
            try
            {
                $DB = new \PDO("mysql:host={$DBDetails['SQLHost']}", $DBDetails['SQLUser'], $DBDetails['SQLPassword']);
                $DB->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            }
            catch(\Exception $ex)
            {
                $Log[] = "FAIL: Couldn't connect to database server: {$ex->getMessage()}";
                return $Log;
            }
        }
        
        $SQL = "USE `{$DBDetails['SQLDBName']}`;\n";
        $SQL .= file_get_contents('grader.sql');
        $Query = $DB->prepare($SQL);
        try
        {
            $Query->execute();
            $Log[] = 'Imported database schema successfully';
        }
        catch (Exception $ex)
        {
            $Log[] = "FAIL: Couldn't import database schema: {$ex->getMessage()}";
            return $Log;
        }
        
        $_SESSION['Step310_dbcreate']['OKForNextStep'] = true;
        return $Log;
    }
    
    public function OKForNextStep()
    {
        return $_SESSION['Step310_dbcreate']['OKForNextStep'];
    }

}



class Step002_dbconnect implements ISetupStep
{
    public function __construct()
    {
        if(!isset($_SESSION['Step002_dbconnect']['OKForNextStep']))
        {
            $_SESSION['Step002_dbconnect']['OKForNextStep'] = false;
        }
    }
    
    public function TestDB()
    {
        $_SESSION['Step002_dbconnect']['OKForNextStep'] = false;
        $tests = array();
        $DBDetails = $_SESSION['Step001_database'];
        
        if($DBDetails['createUserAndDB'] == 'true')
        {
            $tests[0]['Name'] = "Connect to MySQL server (host: {$DBDetails['SQLHost']}) with user {$DBDetails['SQLRootUser']}";
            try
            {
                @$DB = new \PDO("mysql:host={$DBDetails['SQLHost']}", $DBDetails['SQLRootUser'], $DBDetails['SQLRootPassword']);
                $tests[0]['Error'] = null;
            }
            catch (Exception $ex)
            {
                $tests[0]['Error'] = $ex->getMessage();
                return $tests;
            }
        }
        else
        {
            $tests[0]['Name'] = "Connect to MySQL server (host: {$DBDetails['SQLHost']}) with user {$DBDetails['SQLUser']}";
            try
            {
                @$DB = new \PDO("mysql:host={$DBDetails['SQLHost']}", $DBDetails['SQLUser'], $DBDetails['SQLPassword']);
                $DB->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                $tests[0]['Error'] = null;
            }
            catch (Exception $ex)
            {
                $tests[0]['Error'] = $ex->getMessage();
                return $tests;
            }

            $tests[1]['Name'] = "Check for access to database {$DBDetails['SQLDBName']}";
            try
            {
                $Query = $DB->prepare("USE `{$DBDetails['SQLDBName']}`;");
                $Query->execute();
                $tests[1]['Error'] = null;
            }
            catch (Exception $ex)
            {
                $tests[1]['Error'] = $ex->getMessage();
                return $tests;
            }

        }
        
        $_SESSION['Step002_dbconnect']['OKForNextStep'] = true;
        return $tests;
    }

    public function OKForNextStep()
    {
        return $_SESSION['Step002_dbconnect']['OKForNextStep'];
    }

}


class Step001_database implements ISetupStep
{
    public function __construct()
    {
        if(!isset($_SESSION['Step001_database']))
        {
            $_SESSION['Step001_database'] = array(
                'SQLHost' => 'localhost',
                'SQLUser' => '',
                'SQLPassword' => '',
                'SQLDBName' => '',
                'SQLRootUser' => 'root',
                'SQLRootPassword' => '',
                'createUserAndDB' => false
            );
        }
    }
    public function saveValues()
    {
        foreach(json_decode($_GET['dbdetails'], true) as $key => $value)
        {
            $_SESSION['Step001_database'][$key] = $value;
        }
    }
    
    public function retrieveValues()
    {
        return $_SESSION['Step001_database'];
    }
    
    public function OKForNextStep()
    {
        return true;
    }

}

class Step000_sysreq implements ISetupStep
{
    public function GetReqs()
    {
        return $this->CalculateReqs();
    }
    
    private function CalculateReqs()
    {
        $Reqs = array();
        $Reqs['phpver']['displayname'] = 'PHP version';
        $Reqs['phpver']['displaydescr'] = '>= 5.3.0';
        $Reqs['phpver']['value'] = PHP_VERSION;
        $Reqs['phpver']['satisfied'] = version_compare(PHP_VERSION, '5.3.0', '>=');
        

        foreach(array('PDO', 'pdo_mysql', 'session') as $Extension)
        {
            $Reqs[$Extension]['displayname'] = "PHP extension {$Extension} enabled";
            $Reqs[$Extension]['displaydescr'] = 'Yes';
            if(!extension_loaded($Extension))
            {
                $Reqs[$Extension]['value'] = 'No';
                $Reqs[$Extension]['satisfied'] = false;
            }
            else
            {
                $Reqs[$Extension]['value'] = 'Yes';
                $Reqs[$Extension]['satisfied'] = true;
            }
        }
        
        $Reqs['php_timezone']['displayname'] = 'PHP INI date.timezone is configured';
        $Reqs['php_timezone']['displaydescr'] = 'Not undefined';
        if(ini_get('date.timezone') == '')
        {
            $Reqs['php_timezone']['value'] = 'Undefined';
            $Reqs['php_timezone']['satisfied'] = false;
        }
        else
        {
            $Reqs['php_timezone']['value'] = ini_get('date.timezone');
            $Reqs['php_timezone']['satisfied'] = true;
        }
        


        $Reqs['mod_rewrite']['displayname'] = 'Apache mod_rewrite active';
        $Reqs['mod_rewrite']['displaydescr'] = 'Yes';
        if(in_array('mod_rewrite', apache_get_modules()))
        {
            $Reqs['mod_rewrite']['value'] = 'Yes';
            $Reqs['mod_rewrite']['satisfied'] = true;
        }
        else
        {
            $Reqs['mod_rewrite']['value'] = 'No';
            $Reqs['mod_rewrite']['satisfied'] = false;
        }
        
        return $Reqs;
    }
    
    public function OKForNextStep()
    {
        foreach($this->CalculateReqs() as $Req)
        {
            if(!$Req['satisfied'])
            {
                return false;
            }
        }
        
        return true;
    }
}

$filteredGET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);

if(@$filteredGET['mode'] == 'json')
{
    header("Content-Type: application/json; charset=UTF-8");
    $ClassName = $filteredGET['class'];
    $Method = $filteredGET['method'];
    $C = new $ClassName;
    echo json_encode($C->$Method());
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/knockout-3.1.0.js"></script>
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <style type="text/css">
            body { padding-top: 50px; }
            span.rpasslink { font-size: small; }
            span.rpasslink:hover { cursor: pointer; }
            div[id^=Step] { display: none; }
        </style>
    </head>
    
    <body>

        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                   <a class="navbar-brand">Grader</a>
                </div>
                <div id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a>Setup</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>

        <div class="container">
        <h1>Grader setup</h1>
        <div class="col-md-4">
        <ul>
            <li>Step 0: Check system requirements</li>
        </ul>
        </div>
        
        <div class="col-md-8">
        
        <!-- Step 000: System requirements -->
        <div id="Step000_sysreq">
            <p>Setup will check basic system requirements for Grader. Please
            fix all FAILs to continue to the next step.</p>
            <table class="table">
                <thead>
                    <tr>
                        <th>Requirement</th>
                        <th>Current value</th>
                        <th>Expected value</th>
                        <th>Result</th>
                    </tr>
                </thead>
                <tbody data-bind="foreach: reqs">
                    <tr>
                        <td data-bind="text: displayname"></td>
                        <td data-bind="text: value"></td>
                        <td data-bind="text: displaydescr"></td>
                        <td>
                            <span data-bind="if: satisfied" class="text-success">
                                <span class="glyphicon glyphicon-ok"></span> PASS
                            </span>
                            <span data-bind="ifnot: satisfied" class="text-danger">
                                <span class="glyphicon glyphicon-remove"></span> FAIL
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button data-bind="click: retest">Retest</button>
        </div>
        <!-- / Step 000: System requirements -->
        
        <!-- Step 001: Database -->
        <div id="Step001_database">
        <p>Grader requires a MySQL or MariaDB database, please enter the details
        of the database server. You can opt to have a MySQL user & database
        created for you: setup will use the root username & password for that.</p>
            <table>
                <tbody>
                    <tr>
                        <td>SQL host:</td>
                        <td><input data-bind="value: SQLHost" /></td>
                    </tr>
                    <tr>
                        <td>SQL user<span data-bind="visible: createUserAndDB"> (will be created for you)</span>:</td>
                        <td><input data-bind="value: SQLUser" /></td>
                    </tr>
                    <tr>
                        <td>SQL password:</td>
                        <td><input data-bind="value: SQLPassword" /> <span class="rpasslink" data-bind="visible: createUserAndDB, click: genRandPass">(Generate random password)</span></td>
                    </tr>

                    <tr>
                        <td>SQL database<span data-bind="visible: createUserAndDB"> (will be created for you)</span>:</td>
                        <td><input data-bind="value: SQLDBName" /></td>
                    </tr>
                    <tr>
                        <td>Create user & database for me?</td>
                        <td><input type="checkbox" data-bind="checked: createUserAndDB" /></td>
                    </tr>

                    <!-- ko if: createUserAndDB -->
                    <tr>
                        <td>SQL root user:</td>
                        <td><input data-bind="value: SQLRootUser" /></td>
                    </tr>
                    <tr>
                        <td>SQL root password:</td>
                        <td><input data-bind="value: SQLRootPassword" /></td>
                    </tr>
                    <!-- /ko -->
                </tbody>
            </table>
        </div>
        <!-- / Step 001: Database -->
        
        
        <!-- Step 002: dbconnect -->
        
        <div id="Step002_dbconnect">
            <p>Setup will do something basic database server connectivity
            checks. Fix all FAILs to continue.</p>
            <button data-bind="click: testDB">Retest</button>
            <table>
                <thead>
                    <tr>
                        <th>Test</th>
                        <th>Result</th>
                    </tr>
                </thead>
                <tbody data-bind="foreach: tests">
                    <tr>
                        <td data-bind="text: name"></td>
                        <td>
                            <span data-bind="ifnot: error" style="color: green">PASS</span>
                            <span data-bind="if: error" style="color: red">FAIL:<br /><span data-bind="text: error"></span></span>
                        </td>
                    </tr>
                </tbody>
            </table>
            
        </div>
        
        <!-- / Step 002: dbconnect -->
        
        <!-- Step 310: create db -->
        
        <div id="Step310_dbcreate">
            <button data-bind="click: createDB">Create database</button>
            
            <ul data-bind="foreach: resultLog">
                <li><span data-bind="text: message"></span></li>
            </ul>

        </div>
        
        <!-- / Step 310: create db -->

        <div id="Step311_siteconfig">
            Please enter the following configuration details:
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Site URL:</td>
                        <td><input type="text" data-bind="value: siteURL" /></td>
                    </tr>
                </tbody>
            </table>
        </div>


        <!-- Step 314: create config file -->
        
        <div id="Step314_createconfig">
            <p>Setup will now create Grader's configuration file. For this step
                to work, setup needs to be able to write to the file <?php echo getcwd(); ?>/dptcms/config.php.
                If the operation fails, setup will generate the configuration
                for you, but you must manually upload it.
            </p>
            <ol>
                <li>touch <?php echo getcwd(); ?>/dptcms/config.php</li>
                <li>chmod o+rw <?php echo getcwd(); ?>/dptcms/config.php</li>
                <li>chcon -t httpd_user_rw_content_t <?php echo getcwd(); ?>/dptcms/config.php</li>
            </ol>
            <button data-bind="click: writeConfig">Create configuration file</button>
            <div data-bind="if: executed">
                <div data-bind="if: success">

                </div>

                <div data-bind="ifnot: success">
                    Was unable to write config file:<br />
                    <span data-bind="text: error"></span><br />
                    Copy paste this into dptcms/config.php:<br />
                    <textarea data-bind="text: config" rows="35" cols="120"></textarea>
                </div>
            </div>

        </div>
        
        <!-- / Step 314: create config file -->
        
        <!-- Step 400: complete -->
        <div id="Step400_complete">
            Grader setup has now complete. Login at
            <a href="">http://...</a>
        </div>
        <!-- / Step 400: complete -->
        </div>
        <div id="buttons" style="text-align: right;">
            <button name="previousStep" data-bind="click: recede">« Previous step</button>
            <button name="nextStep" data-bind="enable: OKForNextStep, click: advance">Next step »</button>
        </div>
        

        </div>
        
        <script type="text/javascript">
            function stepController()
            {
                self = this;
                
                self.currentStep = "";
                self.OKForNextStep = ko.observable(false);
                
                self.steps = {};
                
                self.steps.Step000_sysreq = new step000_sysreqVM();
                self.steps.Step001_database = new step001_database();
                self.steps.Step002_dbconnect = new step002_dbconnect();
                self.steps.Step310_dbcreate = new step310_dbcreate();
                self.steps.Step311_siteconfig = new step311_siteconfig();
                self.steps.Step314_createconfig = new step314_createconfig();
                self.steps.Step400_complete = new step400_complete();
                
                ko.applyBindings(self.steps.Step000_sysreq, document.getElementById("Step000_sysreq"));
                ko.applyBindings(self.steps.Step001_database, document.getElementById("Step001_database"));
                ko.applyBindings(self.steps.Step002_dbconnect, document.getElementById("Step002_dbconnect"));
                ko.applyBindings(self.steps.Step310_dbcreate, document.getElementById("Step310_dbcreate"));
                ko.applyBindings(self.steps.Step311_siteconfig, document.getElementById("Step311_siteconfig"));
                ko.applyBindings(self.steps.Step314_createconfig, document.getElementById("Step314_createconfig"));
                ko.applyBindings(self.steps.Step400_complete, document.getElementById("Step400_complete"));

            
                function stepControllerViewModel()
                {
                    this.OKForNextStep = self.OKForNextStep;
                    
                    this.advance = function()
                    {
                        self.advance();
                    }
                    
                    this.recede = function()
                    {
                        self.recede();
                    }
                }
                
                this.reevaluateOKForNextStep = function()
                {
                    $.getJSON(
                        "setup.php?mode=json&class=" + this.currentStep + "&method=OKForNextStep",
                        function(data)
                        {
                            self.OKForNextStep(data);
                        }
                    );
                }
            
                ko.applyBindings(new stepControllerViewModel(), document.getElementById("buttons"));


                this.getStep = function (stepName)
                {
                    return self.steps[stepName];
                }

                this.start = function()
                {
                    $.getJSON(
                        "setup.php?mode=json&class=StepController&method=GetCurrentStep",
                        function(allData)
                        {
                            self.currentStep = allData;
                            self.activateCurrentStep();
                        }
                    );
                }
                
                this.activateCurrentStep = function()
                {
                    $("#" + this.currentStep).show();
                    self.steps[this.currentStep].activate && self.steps[this.currentStep].activate();
                    self.reevaluateOKForNextStep();
                }
                
                this.deactivateCurrentStep = function()
                {
                    $("#" + this.currentStep).hide();
                    self.steps[this.currentStep].deactivate && self.steps[this.currentStep].deactivate();
                }
                
                this.advance = function()
                {
                    $.getJSON(
                        "setup.php?mode=json&class=StepController&method=Advance",
                        function(allData)
                        {
                            self.deactivateCurrentStep();
                            self.currentStep = allData;
                            self.activateCurrentStep();
                        }
                    );
                }
                
                this.recede = function()
                {
                    $.getJSON(
                        "setup.php?mode=json&class=StepController&method=Recede",
                        function(allData)
                        {
                            self.deactivateCurrentStep();
                            self.currentStep = allData;
                            self.activateCurrentStep();
                        }
                    );
                }
            }

            /* Step 000: System requirements */
            function step000_sysreqVM()
            {
                var self = this;

                self.reqs = ko.observableArray([]);
        
                this.retest = function()
                {
                    $.getJSON(
                        "setup.php?mode=json&class=Step000_sysreq&method=GetReqs",
                        function(allData)
                        {
                            var mappedReqs = $.map(allData, function(item) { return new sysreq(item) });
                            self.reqs(mappedReqs);
                        }
                    );
                    sc.reevaluateOKForNextStep();
                }
                
                this.activate = function()
                {
                    this.retest();
                }
            }

            function sysreq(data)
            {
                this.displayname = ko.observable(data.displayname);
                this.displaydescr = ko.observable(data.displaydescr);
                this.value = ko.observable(data.value);
                this.satisfied = ko.observable(data.satisfied);
            }
            /* / Step 000: System requirements */

            function step001_database()
            {
                var self = this;
                
                this.SQLHost = ko.observable("");
                this.SQLUser = ko.observable("");
                this.SQLPassword = ko.observable("");
                this.SQLDBName = ko.observable("");
                this.SQLRootUser = ko.observable("");
                this.SQLRootPassword = ko.observable("");
                this.createUserAndDB = ko.observable(false);
                
                this.genRandPass = function()
                {
                    // From http://stackoverflow.com/questions/9719570/generate-random-password-string-with-requirements-in-javascript
                    var randPass = Math.random().toString(36).slice(-9);
                    self.SQLPassword(randPass);
                }
                
                this.activate = function()
                {
                    $.getJSON(
                        "setup.php?mode=json&class=Step001_database&method=retrieveValues",
                        function(values)
                        {
                            self.SQLHost(values.SQLHost);
                            self.SQLUser(values.SQLUser);
                            self.SQLPassword(values.SQLPassword);
                            self.SQLDBName(values.SQLDBName);
                            self.SQLRootUser(values.SQLRootUser);
                            self.SQLRootPassword(values.SQLRootPassword);
                            self.createUserAndDB(values.createUserAndDB);
                        }
                    );
                }
                
                this.deactivate = function()
                {
                    var dbdata =
                    {
                        "SQLHost": self.SQLHost,
                        "SQLUser": self.SQLUser,
                        "SQLPassword": self.SQLPassword,
                        "SQLDBName": self.SQLDBName,
                        "SQLRootUser": self.SQLRootUser,
                        "SQLRootPassword": self.SQLRootPassword,
                        "createUserAndDB": self.createUserAndDB
                    };
                    
                    $.getJSON(
                        "setup.php?mode=json&class=Step001_database&method=saveValues",
                        { "dbdetails" : ko.toJSON(dbdata) }
                    );
                }
            }
            
            function step002_dbconnect()
            {
                var self = this;
                
                self.tests = ko.observableArray([]);
                
                this.test = function(data)
                {
                    this.name = ko.observable(data.Name);
                    this.error = ko.observable(data.Error);
                }
                
                this.activate = function()
                {
                    this.testDB();
                }
                
                this.testDB = function()
                {   
                    $.getJSON(
                        "setup.php?mode=json&class=Step002_dbconnect&method=TestDB",
                        function(allData)
                        {
                            var mappedTests = $.map(allData, function(item) { return new self.test(item) });
                            self.tests(mappedTests);
                            sc.reevaluateOKForNextStep();
                        }
                    );
                }
            }
            
            function step310_dbcreate()
            {
                var self = this;
                
                self.resultLog = ko.observableArray([]);
                
                this.createDB = function()
                {
                    $.getJSON(
                        "setup.php?mode=json&class=Step310_dbcreate&method=CreateDB",
                        function(allData)
                        {
                            var resultLog = $.map(allData, function(item) { return new self.resultLogEntry(item) });
                            self.resultLog(resultLog);
                            sc.reevaluateOKForNextStep();
                        }
                    );
                }
                
                this.resultLogEntry = function(data)
                {
                    this.message = ko.observable(data);
                }
            }
            
            function step311_siteconfig()
            {
                var self = this;
                
                this.siteURL = ko.observable("");
                
                this.activate = function()
                {
                    $.getJSON(
                        "setup.php?mode=json&class=Step311_siteconfig&method=retrieveValues",
                        function(values)
                        {
                            console.log(values);
                            self.siteURL(values.siteURL);
                        }
                    );
                }
                
                this.deactivate = function()
                {
                    var siteconfig =
                    {
                        "siteURL": self.siteURL
                    };
                    
                    $.getJSON(
                        "setup.php?mode=json&class=Step311_siteconfig&method=saveValues",
                        siteconfig
                    );
                }
            }


            function step314_createconfig()
            {
                var self = this;
                
                this.success = ko.observable(false);
                this.config  = ko.observable("");
                this.error   = ko.observable(null);
                this.executed = ko.observable(false);
                
                this.writeConfig = function()
                {   
                    $.getJSON(
                        "setup.php?mode=json&class=Step314_createconfig&method=writeConfig",
                        function(allData)
                        {
                            self.config(allData.config);
                            self.success(allData.success);
                            if(allData.success == false)
                            {
                                self.error(allData.error);
                            }
                            self.executed(true);
                        }
                    );
                }
            }
            
            function step400_complete()
            {
                this.activate = function()
                {
                    $("#buttons").hide();
                }
            }

            var sc = new stepController();
            sc.start();
        </script>
    </body>

</html>