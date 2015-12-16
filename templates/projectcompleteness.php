<?php
// Page initialisation
$location = "projectcompleteness";
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
            <div class="big-info">
                <span data-bind="text: projectCompletenessTitle"></span>
            </div>
        </div>
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Document</th>
                        <th>amount required</th>
                        <th>weight</th>
                        <th>Lock</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody data-bind="foreach: documents">
                    <tr>
                        <td data-bind="attr: {'id': id}"">
                            <input class="form-control" data-bind="value: description">
                        </td>
                        <td>
                            <input class="form-control" data-bind="value: amount_required">
                        </td>
                        <td>
                            <input class="form-control" data-bind="value: weight">
                        </td>
                        <td>
                            <i class="icon-large icon-unlock" style="vertical-align: middle;" data-bind="click: toggleLock"></i></span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-default" data-bind="click: removeThis">Remove</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button type="button" class="btn btn-default" ><span class="glyphicon glyphicon-plus"></span> <span data-bind="click: addNewDocument, text: projectAddDocument">Add a Document</span></button>
            <button type="button" class="btn btn-default pull-right"><span class="glyphicon glyphicon-floppy-disk"></span> <span data-bind="click: saveDocuments" data-bind="text: nextPage">Next</span></span></button>
        </div>

    </div>
</div>

<!-- Content container -->
<div class="container">
</div>

<?php include_once('jsdepends.php') ?>
</body>
</html>
