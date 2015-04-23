<?php
    $location = "jsrapport/coursestudentsrapporten";
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
    <?php include_once('templates/hddepends.php') ?>
</head>

<body>
<?php include_once('templates/menu.php') ?>

    <!-- Header container -->
    <div class="container">
        <h1 class="page-header" id="projectHeader" data-value="<?php echo $coursestudentsid ?>"><?php echo $coursestudentsname ?></h1>
    </div>

    <!-- Content container -->
    <div class="container">
        <div class="big-info">Students:</div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
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
            </div>
        </div>

        <button type="button" class="btn btn-default pagination-button" id="addStudentList">
            <span class="glyphicon glyphicon-plus"></span> <span data-bind="text: addBtn"></span>
        </button>

    </div><br />

    <div id="addStudentListForm" class="container">
    <div class="row">
        <label>StudentList:</label>
        <input id="studentListComplete" />
        <button id="addStudentListBtn" class="btn btn-default">Add</button>
    </div>
    </div>

    <br />

    <!-- Content container -->
    <div class="container">
        <div class="big-info">Teachers:</div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
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
            </div>
        </div>

        <button type="button" class="btn btn-default pagination-button" id="addTeacher">
            <span class="glyphicon glyphicon-plus"></span> <span data-bind="text: addBtn"></span>
        </button>

    </div>
    
    <div id="addTeacherForm" class="container">
    <div class="row">
        <form method="get">
            <label>Teacher name:</label>
            <input id="teachersComplete" name="teachername" />
            <button id="addTeacherBtn" class="btn btn-default">Add</button>
        </form>
    </div>
</div>

    <?php include_once('templates/jsdepends.php') ?>
</body>
</html>
