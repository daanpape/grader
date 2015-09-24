<?php
    $location = "jsrapport/worksheetassess";
?>

<!DOCTYPE html>
<html lang="nl" id="htmldoc">
    <head>
        <style>
            #top-col {
                padding-bottom: 15px;
            }          
            .form-name {
                display: inline-block !important;
                margin-right: 10px;
                width: 750px !important;
            }
            .validationSummary
            {
                color: red;
            }
            .hide{
                display: none;
            }         
            form {
                margin-bottom: 100px;
            }
            #list {
                width: 50%;
                margin-bottom: 2%;
            }
            #list ul {
                margin: 0;
                padding: 0;
                list-style-type: none;
            }
            #modules li {
                display: block;
                color: #FFF;
                background-color: #154890;
                font-size: 20px;
                border-radius: 10px;
                width: auto;
                padding: 10px 10px 10px 8px;
                text-decoration: none;
                font-weight: bold;
                margin-bottom: 2px;
            }
            #competences li {
                display: block;
                color: #FFF;
                background-color: #6699FF;
                font-size: 20px;
                border-radius: 10px;
                width: auto;
                padding: 10px 10px 10px 8px;
                text-decoration: none;
                font-weight: normal;
                margin-bottom: 2px;
                margin-left: 6%;
            }
            #criterias li {
                display: block;
                color: #FFF;
                background-color: #CDBFAC;
                font-size: 20px;
                border-radius: 10px;
                width: auto;
                padding: 10px 10px 10px 8px;
                text-decoration: none;
                font-weight: normal;
                margin-bottom: 2px;
                margin-left: 12%;
            }
        </style>
        
        <?php include_once('templates/hddepends.php');  ?>
    </head>
    
    <body>
        <?php include_once('templates/menu.php') ?>

        <!-- Header container -->
        <p id="storage" data-bind="attr:{'data-value': <?php echo $courseid ?>}" style="display: none"><?php echo $userid ?></p>
        <div class="container">
            <h1 id="header" class="page-header" data-bind="attr:{'data-value': <?php echo $workid ?>}"><?php echo $workname ?></h1>
        </div>
        
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <form id="worksheetassess" action="/assessrapporten">    <!-- action="/assessrapporten" -->
                        <div class="form-group">
                            <label data-bind="text: formdate"></label><br />
                            <input type="text" id="date" />
                        </div>
                        <br />
                        
                        <!-- list van modules, competenties en criteria -->
                        <div class="formgroup">
                            <label data-bind="text: formmodules"></label>
                            <div id="list">
                                <ul data-bind="foreach: modules" id="modules">              <!-- modules -->
                                    <li>
                                        <span data-bind="text: modname"></span>
                        <!--------->    <div class="dropdown col-md-2">
                                            <button class="btn btn-wide btn-default btn-assessScore dropdown-toggle" type="button" id="assessScore" data-toggle="dropdown" aria-expanded="true">
                                                <span class="text-center" id="sheetscore">Choose...</span>
                                                <span class="pull-right caret-down caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-assessMethod ul-wide" role="menu" aria-labelledby="assessScore" name="assessScore" data-bind="foreach: viewModel.assessMethod">
                                                <li class="li-wide" role="presentation"><a role="menuitem" tabindex="-1" href="#" data-bind="text: score"></a></li>
                                            </ul>
                        <!--------->    </div>
                                    </li>
                    
                                    
                                    <ul data-bind="foreach: competences" id="competences">      <!-- competences -->
                                        <li data-bind="text: comname"></li>
                                        <ul data-bind="foreach: criterias" id="criterias">         <!-- criteria -->
                                            <li data-bind="text: critname"></li>
                                        </ul>
                                    </ul>
                                </ul>
                            </div>
                        </div>
                        
                        <label data-bind="text: formworksheet"></label>
                        <div class="row">
                            <div class="dropdown col-md-2">
                                <button class="btn btn-wide btn-default btn-assessScore dropdown-toggle" type="button" id="assessScore" data-toggle="dropdown" aria-expanded="true">
                                    <span class="text-center" id="sheetscore">Choose...</span>
                                    <span class="pull-right caret-down caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-assessMethod ul-wide" role="menu" aria-labelledby="assessScore" name="assessScore" data-bind="foreach: viewModel.assessMethod">
                                    <li class="li-wide" role="presentation"><a role="menuitem" tabindex="-1" href="#" data-bind="text: score"></a></li>
                                </ul>
                            </div>
                        </div>
                        
                        <input type="submit" id="submit" value="Save" class="btn btn-primary" />
                        <input type="reset" id="cancel" value="Reset" class="btn btn-default" />
                    </form>
                </div>
            </div>
        </div>

        <?php include_once('templates/jsdepends.php') ?>
    </body>
</html>