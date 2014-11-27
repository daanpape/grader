<?php
// Page initialisation
$location = "project";
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
            <h1 class="page-header" id="projectHeader" data-value="<?php echo $projectid ?>" data-bind="text: pageHeader">Project</h1>
            <button id="addCompetenceBtn" class="btn btn-lg">
                Add competence
            </button>
        </div>

        <!-- Content container -->
        <div class="container">
        </div>

        <?php include_once('jsdepends.php') ?>
    </body>
</html>
