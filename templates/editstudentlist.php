<?php
// Page initialisation
$location = "editstudentlist";
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
    <h1 class="page-header" id="page-header" data-bind="attr{'data-value': <?php echo $studentlistid?>}"><span data-bind="text: pageHeader">List: </span><span data-bind="text: studentlistName">Name</span></h1>
</div>

<!-- Content container -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th data-bind="text: email">Username</th>
                    <th data-bind="text: firstname">Firstname</th>
                    <th data-bind="text: lastname">Lastname</th>
                    <th data-bind="text: actionTableTitle">Actions</th>
                </tr>
                </thead>
                <tbody data-bind="foreach: tabledata">
                <tr>
                    <td data-bind="text: tusername">--</td>
                    <td data-bind="text: tfirstname">--</td>
                    <td data-bind="text: tlastname">--</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include_once('jsdepends.php') ?>
</body>
</html>
