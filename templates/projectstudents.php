<?php
// Page initialisation
$location = "projectstudents";
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
</div>

<!-- Content container -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <p data-bind="text: projectStudentsCoupledList">Coupled list</p>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th data-bind="text: nameTableTitle" style="width: 80%">Name</th>
                    <th data-bind="text: actionTableTitle">Actions</th>
                </tr>
                </thead>
                <tbody data-bind="foreach: coupledLists">
                <tr>
                    <td data-bind="text: tname">--</td>
                    <td>
                        <button class="btn btn-default" data-bind="attr:{'id': 'uncouplebtn-' + tid}, text: viewModel.projectStudentsUncouple">Uncouple</button>
                    </td>
                </tr>
                </tbody>
            </table>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th data-bind="text: nameTableTitle" style="width: 80%">Name</th>
                    <th data-bind="text: actionTableTitle">Actions</th>
                </tr>
                </thead>
                <tbody data-bind="foreach: availableLists">
                <tr>
                    <td data-bind="text: tname">--</td>
                    <td>
                        <button class="btn btn-default" data-bind="attr:{'id': 'couplebtn-' + tid}, text: viewModel.projectStudentsCouple">Couple</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <button type="button" class="btn btn-default pagination-button nextPageButton">
            <span class="glyphicon glyphicon-floppy-disk"></span>
            <span  data-bind="text: nextPage">Save</span>
        </button>
    </div>
</div>

<?php include_once('jsdepends.php') ?>
</body>
</html>
