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
                    <th>Name</th>
                    <th># to submit</th>
                    <th>Weight</th>
                    <th>Not submitted</th>
                </tr>
                </thead>
                <tbody data-bind="foreach: documents">
                    <tr>
                        <td><span data-bind="text: description"></span></td>
                        <td><span data-bind="text: amount_required"></span></td>
                        <td><span data-bind="text: weight"></span></td>
                        <td>
                            <select class="form-control" data-bind="options: amount_not_submitted, attr:{'id': 'document-' + id}">
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-12">
            <button data-bind="click: saveDocumentsNotSubmitted" data-value="<?php echo $studentid ?>" id="saveBtn" class="btn btn-lg">Save</button>
            <button id="cancelBtn" class="btn btn-lg">Cancel</button>
        </div>
    </div>
</div>

<!-- Content container -->
<div class="container">
</div>

<?php include_once('jsdepends.php') ?>
</body>
</html>
