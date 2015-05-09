<?php
    $location = "jsrapport/worksheetassess";
?>

<!DOCTYPE html>
<html lang="nl" id="htmldoc">
    <head>
        <?php include_once('templates/hddepends.php');  ?>
        <link href="/css/cssrapport/report.css" rel="stylesheet">
    </head>
    
    <body>
        <?php include_once('templates/menu.php') ?>

        <!-- Header container -->
        <div class="container">
            <h1 id="header" class="page-header" data-bind="attr:{'data-value': <?php echo $workid ?>}"><?php echo $workname ?></h1>
        </div>
        
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <form id="worksheetassess" action="/assessrapporten">
                        <div class="form-group">
                            <label data-bind="text: formdate"></label>
                            <input type="text" id="date" />
                        </div>
                        <br />
                        
                        <div class="form-group">
                            <label data-bind="text: formmodules"></label>
                            <!-- modules, competences and criteria scores -->
                        </div>
                        <br />
                        
                        <div class="form-group">
                            <label data-bind="text: formworksheet"></label>
                            <!-- worksheet score -->
                        </div>
                        <br />
                        
                        <input type="submit" id="submit" value="Save" class="btn btn-primary" />
                        <input type="reset" id="cancel" value="Reset" class="btn btn-default" />
                    </form>
                </div>
            </div>
        </div>

        <?php include_once('templates/jsdepends.php') ?>
    </body>
</html>