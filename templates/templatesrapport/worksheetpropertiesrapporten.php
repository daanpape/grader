<?php
    $location = "jsrapport/worksheetpropertiesrapporten";
?>

<!DOCTYPE html>
<html lang="nl" id="htmldoc">
    <head>
        <?php include_once('templates/hddepends.php');  ?>
    </head>
    
    <body>
        <?php include_once('templates/menu.php') ?>

        <!-- Header container -->
        <div class="container">
            <h1 class="page-header" data-bind="text: <?php echo $sheetname ?>">Sheet</h1>
        </div>

        <?php include_once('templates/jsdepends.php') ?>
    </body>
</html>