<?php
    $location = "jsrapport/homerapporten";
?>

<!DOCTYPE html>
<html lang="nl" id="htmldoc">
    <head>
        <?php include_once('templates/hddepends.php');
        //Connection with local database: include_once('database.php') + Db::getConnection()  ?>
    </head>
    
    <body>
        <?php include_once('templates/menu.php') ?>

        <!-- Header container -->
        <div class="container">
            <h1 class="page-header" data-bind="text: app">Grading System</h1>
        </div>
        
        <!-- Content container -->
        <div class="container">
            <div class="starter-template" data-bind="html: homeManual">
                <p class="lead">Here comes a summary of students who still need to be assessed</p>
            </div>
        </div>

        <?php include_once('templates/jsdepends.php') ?>
    </body>
</html>