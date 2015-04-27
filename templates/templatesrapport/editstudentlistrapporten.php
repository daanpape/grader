<?php
// Page initialisation
$location = "jsrapport/editstudentlistrapporten";
?>
<!DOCTYPE html>
<html lang="nl" id="htmldoc">
<head>
    <?php include_once('templates/hddepends.php') ?>
</head>

<body>
<?php include_once('templates/menu.php') ?>

<!-- Header container -->
<div class="container">
    <h1 class="page-header" id="page-header" data-bind="attr:{'data-value': <?php echo $studentlistid ?>}"><span data-bind="text: pageHeader">List: </span><?php echo $studentlistname ?></h1>
</div>

<!-- Content container -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th data-bind="text: firstname">Firstname</th>
                    <th data-bind="text: lastname">Lastname</th>
                    <th data-bind="text: email">Username</th>
                    <th data-bind="text: actionTableTitle">Actions</th>
                </tr>
                </thead>
                <tbody data-bind="foreach: tabledata">
                <tr>
                    <td data-bind="text: tfirstname">--</td>
                    <td data-bind="text: tlastname">--</td>
                    <td data-bind="text: tusername">--</td>
                    <td>
                        <span class="glyphicon glyphicon-edit glyphicon-btn" data-bind="attr:{'id': 'editbtn-' + tid}"></span>
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
        <button type="button" class="btn btn-default pagination-button" id="addStudent">
            <span class="glyphicon glyphicon-plus"></span> <span data-bind="text: addBtn"></span>
        </button>
    </div>
</div>

<div id="addStudentForm" class="container">
    <div class="row">
        <label>Student name:</label>
        <input id="studentsComplete" />
        <button id="addStudentBtn" class="btn btn-default">Add</button>
    </div>
</div>

<?php include_once('templates/jsdepends.php') ?>
</body>
</html>
