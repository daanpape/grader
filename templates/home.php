<?php
// Page initialisation
$location = "home";
?>
<!DOCTYPE html>
<html lang="nl" id="htmldoc">
    <head>
        <?php include_once('hddepends.php') ?>
    </head>

    <body>
        <?php include_once('menu.php') ?>

        <!-- Header container -->
        <div class="container">
            <h1 class="page-header" data-bind="text: app">Projects</h1>
        </div>
        
        <!-- Content container -->
        <div class="container">
            <div class="starter-template" data-bind="html: homeManual">
                <p class="lead">This HoWest Assessment tool is used to grade students.<br/>Please read this short manual
                    before using the service.</p>
            </div>
        </div>
        
        <!-- Header container -->
        <div class="container">
            <h1 class="page-header">Uw openstaande projecten</h1>
        </div>
        
        <!-- Header container -->
        <div class="container">
            <h1 class="page-header">Te beoordelen projecten</h1>
        </div>

        <?php include_once('jsdepends.php') ?>
    </body>
</html>
