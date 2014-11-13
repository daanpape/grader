<?php
// Page initialisation
$location = "activate";
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

        <?php include_once('hddepends.php') ?>
    </head>

    <body>
        <?php include_once('menu.php') ?>

        <!-- Header container -->
        <div class="container">
            <h1 class="page-header" data-bind="text: pageHeader">Activation</h1>
        </div>

        <!-- Content container -->
        <div class="container">
            <?php
                if($status){
                    echo "Your grader account is now activated and you can login.";
                } else {
                    echo "The specified activation key was not found, please try again.";
                }
            ?>
        </div>
        <?php include_once('jsdepends.php') ?>
    </body>
</html>
