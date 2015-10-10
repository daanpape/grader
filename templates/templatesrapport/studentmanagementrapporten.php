<?php
$location = "jsrapport/studentmanagementrapporten";
?>

<!DOCTYPE html>
<html lang="nl" id="htmldoc">
<head>
    <?php include_once('templates/hddepends.php'); ?>
</head>

<body>
<?php include_once('templates/menu.php') ?>

<!-- Header container -->
<div class="container">
    <h1 class="page-header" data-bind="text: app">Student Management</h1>
</div>

<!-- Content container -->
<div class="container">
    <div class="row">
        <div class="dropdown col-md-4">
            <label>Student name:</label> <input id="studentsComplete" name="studentname" class="coursesInputField" />
        </div>
    </div>
</div>

<!-- Content container -->
<div class="container">
    <table class="table table-striped">
        <thead>
        <tr>
            <th data-bind="text: courseID">Course ID</th>
            <th data-bind="text: courseName">Name</th>
            <th data-bind="text: volgStatus">Status</th>
            <th data-bind="text: courseAction">Actions</th>
            <th data-bind="text: actionTableTitle">Tempary</th>
        </tr>
        </thead>
        <tbody data-bind="foreach: tabledata">
        <tr>
            <td data-bind="text: tcode">--</td>
            <td data-bind="text: tname">--</td>
            <td data-bind="">--</td>
            <td></td>
            <td>
                <span class="glyphicon glyphicon-pencil glyphicon-btn" data-bind="attr:{'id': 'editbtn-' + tid}"></span>
                <a data-bind="attr:{'href': '/api/coursemodule/' + tid + '/' + tname}"><span class="glyphicon glyphicon-plus glyphicon-btn" data-bind="attr:{'id': 'managebtn-' + tid}"></span></a>
                <a data-bind="attr:{'href': '/api/coursestudents/' + tid + '/' + tname}"><span class="glyphicon glyphicon-user glyphicon-btn" data-bind="attr:{'id': 'studentbtn-' + tid}"></span></a>
                <span class="glyphicon glyphicon-trash glyphicon-btn" data-bind="attr:{'id': 'removebtn-' + tid}"></span>
                <span class="glyphicon glyphicon-copyright-mark glyphicon-btn" data-bind="attr:{'id': 'copybtn-' + tid}"></span>
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
</div>

<?php include_once('templates/jsdepends.php') ?>
</body>
</html>