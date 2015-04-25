<?php
    $location = "jsrapport/coursestudentsrapporten";
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
        <h1 class="page-header" id="projectHeader" data-value="<?php echo $coursestudentsid ?>"><?php echo $coursestudentsname ?></h1>
    </div>

    <!-- Content container -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Studentlists</th>
                        <th>Teachers</th>
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

        <button type="button" class="btn btn-default pagination-button" id="addCoursemembers">
            <span class="glyphicon glyphicon-plus"></span> <span data-bind="text: addBtn"></span>
        </button>

    </div>

    <div id="addStudentListForm" class="container">
        <div class="row">
            <label>StudentList:</label>
            <input id="studentListComplete" />
            <button id="addStudentListBtn" class="btn btn-default">Add</button>
        </div>
    </div>

    <br />
    
    <div id="addTeacherForm" class="container">
        <div class="row">
            <form method="form">
                <label>Teacher name:</label>
                <input id="teachersComplete" name="teachername" />
                <button id="addTeacherBtn" class="btn btn-default">Add</button>
            </form>
        </div>
    </div>

    <?php include_once('templates/jsdepends.php') ?>
</body>
</html>
