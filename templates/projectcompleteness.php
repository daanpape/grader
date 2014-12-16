<?php
// Page initialisation
$location = "projectcompleteness";
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
                            <button class="btn" data-bind="click: $parent.deleteDocumentToSubmit"></button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button class="btn btn-lg" data-bind="click: addDocumentToSubmit">Add a Document</button>
            <button class="btn btn-lg" data-bind="click: saveDocumentsToSubmit">Save</button>
        </div>

    </div>
</div>

<!-- Content container -->
<div class="container">
</div>

<?php include_once('jsdepends.php') ?>
</body>
</html>
