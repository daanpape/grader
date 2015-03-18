<?php
    $location = "jsrapport/studentrapportrapporten";
?>

<!DOCTYPE html>
<html lang="nl" id="htmldoc">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="/img/favicon.ico">

        <title data-bind="text: title"></title>

        <?php include_once('templates/hddepends.php');
        //Connection with local database: include_once('database.php') + Db::getConnection()  ?>
    </head>
    
    <body>
        <?php include_once('templates/menu.php') ?>

        <!-- Header container -->
        <div class="container">
            <h1 class="page-header" data-bind="text: app"></h1>
        </div>
        
        <!-- Content container -->
        <div class="container">
            <div class="starter-template" data-bind="html: homeManual">
                <p class="lead">Hier moet een overzicht getoond worden van de behaalde punten</p>
            </div>
        </div>

        <?php include_once('templates/jsdepends.php') ?>
    </body>
</html>