<?php
    $location = "jsrapport/worksheetpropertiesrapporten";
?>

<!DOCTYPE html>
<html lang="nl" id="htmldoc">
    <head>
        <?php include_once('templates/hddepends.php');  ?>
        <link href="/css/cssrapport/report.css" rel="stylesheet">
    </head>
    
    <body>
        <?php include_once('templates/menu.php') ?>

        <!-- Header container -->
        <div class="container">
            <h1 id="header" class="page-header" data-bind="attr:{'data-value': <?php echo $sheetid ?>}"><?php echo $sheetname ?></h1>
        </div>
        
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <form id="worksheetform">
                        <div class="form-group">
                            <label data-bind="text: formequip"></label>
                            <textarea class="form-control" rows="5" name="equipment" form="worksheetform"></textarea>
                        </div>
                        <br />
                        <div class="form-group">
                            <label data-bind="text: formmethod"></label>
                            <textarea class="form-control" rows="5" name="method" form="worksheetform"></textarea>
                        </div>

                        <div style="max-height: 300px;overflow: auto;">
                            <ul class="list-group checked-list-box">
                              <li class="list-group-item">Cras justo odio</li>
                              <li class="list-group-item" data-checked="true">Dapibus ac facilisis in</li>
                              <li class="list-group-item">Morbi leo risus</li>
                              <li class="list-group-item">Porta ac consectetur ac</li>
                              <li class="list-group-item">Vestibulum at eros</li>
                              <li class="list-group-item">Cras justo odio</li>
                              <li class="list-group-item">Dapibus ac facilisis in</li>
                              <li class="list-group-item">Morbi leo risus</li>
                              <li class="list-group-item">Porta ac consectetur ac</li>
                              <li class="list-group-item">Vestibulum at eros</li>
                            </ul>
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