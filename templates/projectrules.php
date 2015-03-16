<?php
// Page initialisation
$location = "projectrules";
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
    <h1 class="page-header" id="projectHeader" data-value="<?php echo $projectid ?>" data-bind="text: pageHeader">Project Rules</h1>
</div>

<!-- Content container -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Rule Name</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody data-bind="foreach: coupledLists">
                <tr>
                    <td data-bind="text: tname">--</td>
                    <td>
                        <button class="btn" data-bind="attr:{'id': 'uncouplebtn-' + tid}">Uncouple</button>
                    </td>
                </tr>
                </tbody>
            </table>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody data-bind="foreach: availableLists">
                <tr>
                    <td data-bind="text: tname">--</td>
                    <td>
                        <button class="btn" data-bind="attr:{'id': 'couplebtn-' + tid}">Couple</button>
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
