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
                            <table class="table">
                                <thead>
                                </thead>
                                <tbody data-bind="foreach: modules">
                                    <tr>
                                        <td data-bind="text: modname"></td>
                                        <td>
                                            <table>
                                                <tbody data-bind="foreach: competences">
                                                    <tr>
                                                        <td data-bind="text: comname"></td>
                                                        <td>
                                                            <table>
                                                                <tbody data-bind="criterias">
                                                                    <tr>
                                                                        <td data-bind="text: critname"></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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