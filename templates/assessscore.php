<?php
// Page initialisation
$location = "assessscore";
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
    <div class="row">
        <div id="top-col" class="col-md-12">
        </div>
    </div>
</div>

<!-- Content container -->
<div class="container" data-bind="foreach: competences">
    <div class="col-md-12 compPanel">
        <div class="panel panel-default">
            <div class="panel-heading">
                <label data-bind="text: name"></label>
            </div>
            <div class="panel-body" data-bind="foreach: subcompetences">
                <div class="subcompPanel">
                    <div class="panel panel-default">
                        <div class="panel-heading color-subcomp">
                            <label data-bind="text: name"></label>
                        </div>
                        <div class="panel-body">
                            <ul class="list-group" data-bind="foreach: indicators">
                                <label data-bind="text: name"></label>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once('jsdepends.php') ?>
<script>
    var projectid = <?php echo $projectid ?>
</script>
</body>
</html>


