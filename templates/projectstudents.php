<?php
// Page initialisation
$location = "projectstudents";
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
</div>

<!-- Content container -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <p>Coupled lists</p>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody data-bind="foreach: tabledata">
                <tr>
                    <td data-bind="text: tname">--</td>
                    <td data-bind="text: status">--</td>
                    <td>
                        <a data-bind="attr:{'href': '/account/studentlist/edit/' + tid}"><span class="glyphicon glyphicon-pencil glyphicon-btn" data-bind="attr:{'id': 'editbtn-' + tid}"></span></a>
                        <span class="glyphicon glyphicon-trash glyphicon-btn" data-bind="attr:{'id': 'removebtn-' + tid}"></span>
                    </td>
                </tr>
                </tbody>
            </table>
            <table id="coupledLists">
                <thead>

                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include_once('jsdepends.php') ?>
</body>
</html>
