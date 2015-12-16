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
            <table class="table table-striped">
                <thead>
                <tr>
                    <th data-bind="text: nameTableTitle">Name</th>
                    <th data-bind="text: assessCompletementNumberToSubmit"># to submit</th>
                    <th data-bind="text: projectWeight">Weight</th>
                    <th data-bind="text: assessCompletementNumberSubmitted">Submitted</th>
                </tr>
                </thead>
                <tbody data-bind="foreach: documents">
                    <tr>
                        <td><span data-bind="text: description"></span></td>
                        <td><span data-bind="text: amount_required"></span></td>
                        <td><span data-bind="text: weight"></span></td>
                        <td>
                            <select class="form-control" data-bind="options: amount_not_submitted, value: submitted, attr:{'id': 'document-' + id}">
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-12">
            <button data-value="<?php echo $studentid ?>" id="saveBtn" type="button" class="btn btn-default pagination-button" data-bind="text: saveBtn">Save</button>
            <button id="cancelBtn" type="button" class="btn btn-default pagination-button" data-bind="text: cancelBtn">Cancel</button>
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
