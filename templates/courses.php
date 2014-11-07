<?php
// Page initialisation
$location = "courses";
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
    <h1 class="page-header" data-bind="text: pageHeader">Courses</h1>

    <select id="location" data-bind="options: availableLocations, optionsText: 'locationName', optionsValue: 'id', optionsAfterRender: 'bindEvents()'"></select>
    <select id="training" data-bind="options: availableTrainings, optionsText: 'trainingName', optionsValue: 'id'"></select>
    <select id="course" data-bind="options: availableCourses, optionsText: 'courseName', optionsValue: 'id'"></select>
</div>

<!-- Content container -->
<div class="container">
</div>

<?php include_once('jsdepends.php') ?>
</body>
</html>
