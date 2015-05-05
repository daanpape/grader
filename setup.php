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
            'Step314_createconfig'
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
        
    }

    
    public function writeConfig()
    {
        $DBDetails = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        $config = <<<EOD
<?php
class Config
{
    /* Site configuration */
    public static \$siteURL	= 'http://dptknokke.ns01.info:9000';

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
                return array('success' => true);
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
        $DBDetails = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        
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
            $DB = new \PDO("mysql:host={$DBDetails['SQLHost']}", $DBDetails['SQLUser'], $DBDetails['SQLPassword']);
            $DB->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
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
        $tests = array();
        $DBDetails = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        
        
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
<html>
    <head>
        <meta charset="utf-8">
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/knockout-3.1.0.js"></script>
        <style type="text/css">
            body { font-family: DejaVu Sans; }
            span.rpasslink { font-size: small; }
            span.rpasslink:hover { cursor: pointer; }
            div[id^=Step] { display: none; }
        </style>
    </head>
    
    <body>
        <h1>Grader setup</h1>
        <ul>
            <li>Step 0: Check system requirements</li>
        </ul>
        
        <!-- Step 000: System requirements -->
        <div id="Step000_sysreq">
            <table>
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
                            <span data-bind="if: satisfied" style="color: green">PASS</span>
                            <span data-bind="ifnot: satisfied" style="color: red">FAIL</span>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button data-bind="click: retest">Retest</button>
        </div>
        <!-- / Step 000: System requirements -->
        
        <!-- Step 001: Database -->
        <div id="Step001_database">
            <table>
                <tbody>

                    <tr>
                        <td>SQL host:</td>
                        <td><input name="SQLHost" type="text" value="localhost" /></td>
                    </tr>

                    <tr>
                        <td>Create user & database for me?</td>
                        <td><input type="checkbox" data-bind="checked: createUserAndDB" /></td>
                    </tr>

                    <!-- ko if: createUserAndDB -->
                    <tr>
                        <td>SQL root user:</td>
                        <td><input name="SQLRootUser" type="text" value="root" /></td>
                    </tr>
                    <tr>
                        <td>SQL root password:</td>
                        <td><input name="SQLRootPassword" type="password" /></td>
                    </tr>
                    <!-- /ko -->

                    <tr>
                        <td>SQL user:</td>
                        <td><input name="SQLUser" type="text" /></td>
                    </tr>

                    <tr>
                        <td>SQL password:</td>
                        <td><input name="SQLPassword" type="text" /><span class="rpasslink" data-bind="visible: : createUserAndDB">(Generate random password)</span></td>
                    </tr>

                    <tr>
                        <td>SQL database:</td>
                        <td><input name="SQLDBName" type="text" /></td>
                    </tr>

                </tbody>
            </table>
        </div>
        <!-- / Step 001: Database -->
        
        
        <!-- Step 002: dbconnect -->
        
        <div id="Step002_dbconnect">
            
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
        </div>
        
        <!-- / Step 310: create db -->
        
        
        <!-- Step 314: create config file -->
        
        <div id="Step314_createconfig">
            
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
        
        <div id="buttons">
            <input name="previousStep" type="submit" value="« Previous step" />
            <input name="nextStep" data-bind="enable: OKForNextStep" type="submit" value="Next step »" />
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
                self.steps.Step314_createconfig = new step314_createconfig();
                
                ko.applyBindings(self.steps.Step000_sysreq, document.getElementById("Step000_sysreq"));
                ko.applyBindings(self.steps.Step001_database, document.getElementById("Step001_database"));
                ko.applyBindings(self.steps.Step002_dbconnect, document.getElementById("Step002_dbconnect"));
                ko.applyBindings(self.steps.Step310_dbcreate, document.getElementById("Step310_dbcreate"));
                ko.applyBindings(self.steps.Step314_createconfig, document.getElementById("Step314_createconfig"));


            
                function stepControllerViewModel()
                {
                    this.OKForNextStep = self.OKForNextStep;
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
                            self.reevaluateOKForNextStep();
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
                            self.reevaluateOKForNextStep();
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
                this.createUserAndDB = ko.observable(false);
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
                    var dbdata =
                    {
                        "SQLHost": $("input[name=SQLHost]").val(),
                        "SQLUser": $("input[name=SQLUser]").val(),
                        "SQLPassword": $("input[name=SQLPassword]").val(),
                        "SQLDBName": $("input[name=SQLDBName]").val(),
                        "SQLRootUser": $("input[name=SQLRootUser]").val(),
                        "SQLRootPassword": $("input[name=SQLRootPassword]").val(),
                        "createUserAndDB": sc.getStep("Step001_database").createUserAndDB
                    };
                    
                    $.getJSON(
                        "setup.php?mode=json&class=Step002_dbconnect&method=TestDB",
                        dbdata,
                        function(allData)
                        {
                            var mappedTests = $.map(allData, function(item) { return new self.test(item) });
                            self.tests(mappedTests);
                        }
                    );
                }
            }
            
            function step310_dbcreate()
            {
                var self = this;
                
                this.createDB = function()
                {
                    var dbdata =
                    {
                        "SQLHost": $("input[name=SQLHost]").val(),
                        "SQLUser": $("input[name=SQLUser]").val(),
                        "SQLPassword": $("input[name=SQLPassword]").val(),
                        "SQLDBName": $("input[name=SQLDBName]").val(),
                        "SQLRootUser": $("input[name=SQLRootUser]").val(),
                        "SQLRootPassword": $("input[name=SQLRootPassword]").val(),
                        "createUserAndDB": sc.getStep("Step001_database").createUserAndDB
                    };

                    $.getJSON(
                        "setup.php?mode=json&class=Step310_dbcreate&method=CreateDB",
                        dbdata,
                        function(allData)
                        {
                            console.log(allData);
                        }
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
                    var dbdata =
                    {
                        "SQLHost": $("input[name=SQLHost]").val(),
                        "SQLUser": $("input[name=SQLUser]").val(),
                        "SQLPassword": $("input[name=SQLPassword]").val(),
                        "SQLDBName": $("input[name=SQLDBName]").val(),
                        "SQLRootUser": $("input[name=SQLRootUser]").val(),
                        "SQLRootPassword": $("input[name=SQLRootPassword]").val(),
                        "createUserAndDB": sc.getStep("Step001_database").createUserAndDB
                    };
                    
                    $.getJSON(
                        "setup.php?mode=json&class=Step314_createconfig&method=writeConfig",
                        dbdata,
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

            var sc = new stepController();
            sc.start();

            $("input[name=nextStep]").on("click", function() 
                {
                    sc.advance();
                }
            );
    
            $("input[name=previousStep]").on("click", function() 
                {
                    sc.recede();
                }
            );

        </script>
    </body>

</html>