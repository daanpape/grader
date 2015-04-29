<?php
session_start();

class StepController
{
    private $Steps;
    
    public function __construct()
    {
        
        $this->Steps = array('Step000_sysreq', 'Step001_database', 'Step002_dbconnect');
        
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

class Step002_dbconnect implements ISetupStep
{
    public function TestDB()
    {
        if($withcreateuser)
        {
            $DB = new PDO("mysql:dbname={$db};host={$host}", $rootuser, $rootpass);
            $DB->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $Query = $DB->prepare("GET DATABASES");
            $Query->execute();
            if(count($Query->fetchAll()) == 0)
            {
                $Query = $DB->prepare("CREATE DATABASE {$dbname} CHARACTER SET = UTF-8 COLLATE = UTF-8");
                $Query->execute();
            }
            
            $Query = $DB->prepare("SELECT User FROM mysql.user WHERE...");
            $Query->execute();
            if(count($Query->fetchAll()) == 0)
            {
                $Query = $DB->prepare("CREATE USER '{$dbuser}'@'%' IDENTIFIED BY '{$dbpass}';");
                $Query->execute();
                $Query = $DB->prepare("GRANT SELECT, INSERT, UPDATE, DELETE, LOCK TABLES ON '{$dbname}'.* TO '{$dbuser}'@'%'");
                $Query->execute();
            }
        }
        
        $SQL = "USE {$dbname};\n";
        $SQL .= file_get_contents('grader.sql');
        $Query = $DB->prepare($SQL);
        $Query->execute();
    }

    public function OKForNextStep()
    {
        
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

if(@$_GET['mode'] == 'json')
{
    header("Content-Type: application/json; charset=UTF-8");
    $ClassName = $_GET['class'];
    $Method = $_GET['method'];
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
        </div>
        <!-- / Step 000: System requirements -->
        
        <!-- Step 001: Database -->
        <div id="Step001_database">
            <table>
                <tbody>

                    <tr>
                        <td>SQL host:</td>
                        <td><input type="text" value="localhost" /></td>
                    </tr>

                    <tr>
                        <td>SQL user:</td>
                        <td><input type="text" /></td>
                    </tr>

                    <tr>
                        <td>SQL password:</td>
                        <td><input type="text" /><span class="rpasslink">(Generate random password)</span></td>
                    </tr>

                    <tr>
                        <td>SQL database:</td>
                        <td><input type="text" /></td>
                    </tr>

                    <tr>
                        <td>Create user & empty database for me?</td>
                        <td><input type="checkbox" data-bind="checked: createUserAndDB" /></td>
                    </tr>

                    <!-- ko if: createUserAndDB -->
                    <tr>
                        <td>SQL root user:</td>
                        <td><input type="text" value="root" /></td>
                    </tr>

                    <tr>
                        <td>SQL root password:</td>
                        <td><input type="text" /></td>
                    </tr>
                    <!-- /ko -->

                </tbody>
            </table>
        </div>
        <!-- / Step 001: Database -->
        
        <input name="previousStep" type="submit" value="« Previous step" />
        <input name="nextStep" data-bind="enable: OKForNextStep" type="submit" value="Next step »" />

        <script type="text/javascript">


            function stepController()
            {
                self = this;
                
                self.currentStep = "";
                
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
                }
                
                this.deactivateCurrentStep = function()
                {
                    $("#" + this.currentStep).hide();
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
                self.OKForNextStep = ko.observable(false);

                $.getJSON(
                    "setup.php?mode=json&class=Step000_sysreq&method=GetReqs",
                    function(allData)
                    {
                        var mappedReqs = $.map(allData, function(item) { return new sysreq(item) });
                        self.reqs(mappedReqs);
                    }
                )

                $.getJSON(
                    "setup.php?mode=json&class=Step000_sysreq&method=OKForNextStep",
                    function(data)
                    {
                        self.OKForNextStep(data);
                    }
                )
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
                this.createUserAndDB = ko.observable(true);
            }

            ko.applyBindings(new step000_sysreqVM(), document.getElementById("Step000_sysreq"));
            ko.applyBindings(new step001_database(), document.getElementById("Step001_database"));

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