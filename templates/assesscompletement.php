<?php
// Page initialisation
$location = "assesscompletement";
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
    <h1 class="page-header" id="projectHeader" data-value="<?php echo $projectid ?>" data-bind="text: pageHeader">Project</h1>
    <div class="row">
        <div id="top-col" class="col-md-12">
            <div class="col-lg-12 container">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th data-bind="text: nameTableTitle">Name</th>
                            <th data-bind="text: projectWeight">Weight</th>
                            <th data-bind="text: documentScore"></th>
                        </tr>
                        </thead>
                        <tbody data-bind="foreach: documents">
                            <tr>
                                <td><span data-bind="text: description"></span></td>
                                <td><span data-bind="text: weight"></span></td>
                                <td>
                                    <!-- ko if: pointType() === 'Slider' -->
                                    <input type="range" min="0" max="100" step="1" data-bind="value: score" />
                                    <!-- /ko -->

                                    <!-- ko if: pointType() === 'Punten' -->
                                    <div>
                                        <input type="text" data-bind="value: score" placeholder="Score op 100" />
                                    </div>
                                    <!-- /ko -->

                                    <!-- ko if: pointType() === 'Ja/Nee' -->
                                    <br>
                                    <input type="radio" name="ja_nee" value="100"> Ja<br>
                                    <input type="radio" name="ja_nee" value="0"> Nee
                                    <!-- /ko -->
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12">
                    <button data-value="<?php echo $studentid ?>" id="saveBtn" type="button" class="btn btn-default pagination-button">
                        <span class="glyphicon glyphicon-floppy-disk"></span>
                        <span data-bind="text: saveBtn">Save</span>
                    </button>
                    <button id="cancelBtn" type="button" class="btn btn-default pagination-button" data-bind="text: cancelBtn">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content container -->
<div class="container">
</div>

<script>
    var projectid = <?php echo $projectid ?>
</script>


<?php include_once('jsdepends.php') ?>
</body>
</html>
