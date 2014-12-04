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
        <style>
            #top-col {
                padding-bottom: 15px;
            }
        </style>

        <?php include_once('hddepends.php') ?>
    </head>

    <body>
        <?php include_once('menu.php') ?>

        <!-- Header container -->
        <div class="container">
            <h1 class="page-header" id="projectHeader" data-value="<?php echo $projectid ?>" data-bind="text: pageHeader">Project</h1>
            <div class="row">
                <div id="top-col" class="col-md-12">
                    <button class="btn btn-lg addCompetenceBtn" data-bind="text: addCompetence">
                        Add competence
                    </button>
                    
                    <button class="btn btn-lg savePageBtn" data-bind="text: savePage">
                        Save
                    </button>
                </div>
            </div>
        </div>

        <!-- Content container -->
        <div class="container">
        </div>
        
        <div class="container">
            <div class="row">
                <div id="bottom-col" class="col-md-12">
                    <button class="btn btn-lg addCompetenceBtn" data-bind="text: addCompetence">
                        Add competence
                    </button>
                    
                    <button class="btn btn-lg savePageBtn" data-bind="text: savePage">
                        Save
                    </button>
                </div>
            </div>
        </div>

        <?php include_once('jsdepends.php') ?>
    </body>
</html>
