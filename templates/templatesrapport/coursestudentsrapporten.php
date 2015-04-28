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
                    <!-- TODO data-bind aanmaken

                    <tr>
                        <th data-bind="text: studlistTableTitle">StudentList</th>
                        <th data-bind="text: teacherTableTitle">Teachers</th>
                        <th data-bind="text: actionTableTitle">Actions</th>
                    </tr>
                    -->
                    <tr>
                        <th data-bind="text: codeTableTitle">Code</th>
                        <th data-bind="text: nameTableTitle">Name</th>
                        <th data-bind="text: descTableTitle">Description</th>
                    </tr>

                    </thead>
                    <tbody data-bind="foreach: coupledLists">
                    <tr>
                        <td data-bind="text: tcode">--</td>
                        <td data-bind="text: tname">--</td>
                        <td data-bind="text: tdesc">--</td>
                    </tr>
                    </tbody>
                    </table>
            </div>
        </div>

        <button type="button" class="btn btn-default pagination-button" id="addCoursemembers">
            <span class="glyphicon glyphicon-plus"></span> <span data-bind="text: addBtn"></span>
        </button>

    </div>

    <div id="addGroupForm" class="container">
        <div class="row">
                <label>Teacher name:</label> <input id="teachersComplete" name="teachername" />
                <br />
                <label>StudentList:</label> <input id="studentListComplete" name="studentlistname"/>
                <br />
                <button id="addGroupBtn" class="btn btn-default">Add</button>
        </div>
    </div>

    <?php include_once('templates/jsdepends.php') ?>
</body>
</html>
