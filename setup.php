<?php

class Step001_database
{
    
}

class Step000_sysreq
{
    public function GetReqs()
    {
        return json_encode($this->CalculateReqs());
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
                return json_encode(false);
            }
        }
        
        return json_encode(true);
    }
}

if(@$_GET['mode'] == 'json')
{
    header("Content-Type: application/json; charset=UTF-8");
    $ClassName = $_GET['class'];
    $Method = $_GET['method'];
    $C = new $ClassName;
    echo $C->$Method();
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
        </style>
    </head>
    
    <body>
        <h1>Grader setup</h1>
        <ul>
            <li>Step 0: Check system requirements</li>
        </ul>
        
        <!-- Step 000: System requirements -->
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
        <input data-bind="enable: OKForNextStep" type="submit" value="Next step »" />
        <!-- / Step 000: System requirements -->
        
        <!-- Step 001: Database -->
        
        <table>
            
        </table>
        
        
        <!-- / Step 001: Database -->

        <script type="text/javascript">

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

            ko.applyBindings(new step000_sysreqVM());
        </script>
    </body>

</html>