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

        <div class="col-lg-12 container">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th data-bind="text: projectName">Document</th>
                            <th data-bind="text: projectPointType"></th>
                            <th data-bind="text: projectWeigth">weight</th>
                            <th data-bind="text: projectLock">Lock</th>
                            <th data-bind="text: projectActions">Delete</th>
                        </tr>
                    </thead>
                    <tbody data-bind="foreach: documents">
                        <tr>
                            <td data-bind="attr: {'id': id}"">
                                <input class="form-control" style="width: 200px" data-bind="value: description">
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" id="menu1" data-toggle="dropdown"><span data-bind="text: pointType"></span>
                                        <span class="caret"></span></button>
                                    <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="menu1" data-bind="foreach: viewModel.availableTypes">
                                        <li role="presentation"><a role="menuitem" data-bind="text: $data, click: viewModel.changePointType.bind($data,$parent)"></a></li>
                                    </ul>
                                </div>
                            </td>
                            <td>
                                <input class="form-control" data-bind="value: weight">
                            </td>
                            <td>
                                <i class="icon-large icon-unlock" style="vertical-align: middle;" data-bind="click: toggleLock"></i></span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-default" data-bind="click: removeThis, text: viewModel.projectDelete">Remove</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <button type="button" class="btn btn-default" data-bind="click: addNewDocument"><span class="glyphicon glyphicon-plus"></span> <span  data-bind="text: projectAddDocument">Add a Document</span></button>
            <button type="button" class="btn btn-default pull-right" data-bind="click: saveDocuments"><span class="glyphicon glyphicon-floppy-disk"></span> <span data-bind="text: nextPage">Next</span></span></button>
        </div>

    </div>
</div>

<!-- Content container -->
<div class="container">
</div>

<?php include_once('jsdepends.php') ?>
</body>
</html>
