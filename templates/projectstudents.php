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
                <tbody data-bind="foreach: coupledLists">
                <tr>
                    <td data-bind="text: tname">--</td>
                    <td>
                        <button class="btn">UnCouple</button>
                    </td>
                </tr>
                </tbody>
            </table>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody data-bind="foreach: availableLists">
                <tr>
                    <td data-bind="text: tname">--</td>
                    <td>
                        <button class="btn">Couple</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include_once('jsdepends.php') ?>
</body>
</html>
