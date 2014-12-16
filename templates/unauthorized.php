<?php
$location = basename(__FILE__, '.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="You don't have access rights to this page">
        <meta name="author" content="DPTechnics">
        <link rel="shortcut icon" href="favicon.ico">
        <title>DPTechnics - Unauthorized</title>
        <?php require('hddepends.php') ?>
    </head>

    <body>
        <?php require('menu.php') ?>
        <div class="container">
            <div class="jumbotron">
                <div class="jumbotitle">
                    Unauthorized
                </div>
                <div class="jumbocontent">
                    You don't have the correct access rights to view this page. If you think this should not be the case, please contact the site administrator. 
                </div>
            </div>
        </div>
        <?php require('jsdepends.php') ?>    
    </body>
</html>
