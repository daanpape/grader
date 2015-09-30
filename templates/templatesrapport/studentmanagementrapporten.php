<?php
$location = "jsrapport/studentmanagementrapporten";
?>

<!DOCTYPE html>
<html lang="nl" id="htmldoc">
<head>
    <?php include_once('templates/hddepends.php');
    //Connection with local database: include_once('database.php') + Db::getConnection()  ?>
</head>

<body>
<?php include_once('templates/menu.php') ?>

<!-- Header container -->
<div class="container">
    <h1 class="page-header" data-bind="text: app">Student Management</h1>
</div>

<!-- Content container -->
<div class="container">
    <div class="big-info"><span data-bind="text: selectCourse">Select student</span>:</div>
    <div class="row">
        <div class="dropdown col-md-4">
            <button class="btn btn-wide btn-default btn-courseRapport dropdown-toggle" type="button" id="courseRapport" data-toggle="dropdown" aria-expanded="true">
                <span class="text-center">Student</span>
                <span class="pull-right caret-down caret"></span>
            </button>
            <label>Student name:</label> <input id="teachersComplete" name="teachername" class="coursesInputField" />
        </div><p id="errormessage" class="text-danger">*</p>
    </div>
</div>

<!-- Content container -->
<div class="container">
    <table class="table table-striped">
        <thead>
        <tr>
            <th data-bind="text: werkficheID">Course ID</th>
            <th data-bind="text: werkficheName">Name</th>
            <th data-bind="text: werkficheName">Status</th>
            <th data-bind="text: werkficheAction">Actions</th>
        </tr>
        </thead>
        <tbody data-bind="foreach: tabledata">
        <tr>
            <td data-bind="text: tid">--</td>
            <td data-bind="text: tname">--</td>
            <td data-bind="text: tname">--</td>
            <td>
                <span class="glyphicon glyphicon-pencil glyphicon-btn" data-bind="attr:{'id': 'editbtn-' + tid}"></span>
                <span class="glyphicon glyphicon-copyright-mark glyphicon-btn" data-bind="attr:{'id': 'copybtn-' + tid}"></span>
                <span class="glyphicon glyphicon-trash glyphicon-btn" data-bind="attr:{'id': 'removebtn-' + tid}"></span>
            </td>
        </tr>
        </tbody>
    </table>
</div>

<div class="container">
    <!-- Pagination -->
    <ul class="pagination float_left">
        <li id="pager-prev-btn"><a href="#" >&laquo;</a></li>
        <li class="pager-nr-btn"><a href="#" >1</a></li>
        <li class="pager-nr-btn"><a href="#" >2</a></li>
        <li class="pager-nr-btn"><a href="#">3</a></li>
        <li class="pager-nr-btn"><a href="#">4</a></li>
        <li class="pager-nr-btn"><a href="#">5</a></li>
        <li id="pager-next-btn"><a href="#" >&raquo;</a></li>
    </ul>

    <button type="button" class="btn btn-default pagination-button" id="addWorksheetBtn">
        <span class="glyphicon glyphicon-plus"></span> <span data-bind="text: addBtn"></span>
    </button>
</div>

<?php include_once('templates/jsdepends.php') ?>
</body>
</html>