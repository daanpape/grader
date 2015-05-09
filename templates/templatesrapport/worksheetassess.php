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
                
            </div>
        </div>

        <?php include_once('templates/jsdepends.php') ?>
    </body>
</html>