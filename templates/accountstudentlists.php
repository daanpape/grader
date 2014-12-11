<?php
// Page initialisation
$location = "accountstudentlists";
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
    <h1 class="page-header"><span data-bind="text: pageHeader">My User lists</span>: <?php echo Security::getLoggedInName() ?></h1>
</div>

<!-- Content container -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="big-info"><span data-bind="myLists">My Studentlists</span>:</div>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th data-bind="text: nameTableTitle">Name</th>
                    <th data-bind="text: actionTableTitle">Actions</th>
                </tr>
                </thead>
                <tbody data-bind="foreach: tabledata">
                <tr>
                    <td data-bind="text: tname">--</td>
                    <td>
                        <span class="glyphicon glyphicon-pencil glyphicon-btn" data-bind="attr:{'id': 'editbtn-' + tid}"></span>
                        <span class="glyphicon glyphicon-trash glyphicon-btn" data-bind="attr:{'id': 'removebtn-' + tid}"></span>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <button type="button" class="btn btn-default pagination-button" id="addStudentList">
            <span class="glyphicon glyphicon-plus"></span> <span data-bind="text: addStudListBtn"></span>
        </button>
    </div>
</div>

<?php include_once('jsdepends.php') ?>
</body>
</html>
