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
            <h1 class="page-header" data-bind="attr:{'data-value': <?php echo $sheetid ?>}"><?php echo $sheetname ?></h1>
        </div>
        
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" id="worksheetform">
                        <div class="form-group">
                            <label data-bind="text: formequip"></label>
                            <textarea class="form-control" rows="5" cols="75" name="equipment" form="worksheetform"></textarea>
                        </div>
                        <div class="form-group">
                            <label data-bind="text: formmethod"></label>
                            <textarea class="form-control" rows="5" cols="75" name="method" form="worksheetform"></textarea>
                        </div>
                        <input type="submit" id="submit" value="Save" class="btn btn-default" />
                        <input type="reset" id="cancel" value="Reset" class="btn btn-default" />
                    </form>
                </div>
            </div>
        </div>

        <?php include_once('templates/jsdepends.php') ?>
    </body>
</html>