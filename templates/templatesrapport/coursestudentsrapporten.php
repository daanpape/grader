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
                        <th>StudentList</th>
                        <th>Teachers</th>
                        <th>Actions</th>
                    </tr>

                    </thead>
                    <tbody data-bind="foreach: tabledata">
                    <tr>
                        <td data-bind="text: tstudlist">--</td>
                        <td data-bind="text: tteacher">--</td>
                        <td>
                            <span class="glyphicon glyphicon-trash glyphicon-btn" data-bind="attr:{'id': 'removebtn-' + tid}"></span>
                        </td>
                    </tr>
                    </tbody>
                    </table>
            </div>

            <!-- Pagination and action container -->
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

                <button type="button" class="btn btn-default pagination-button" id="addCoursemembers">
                    <span class="glyphicon glyphicon-plus"></span> <span data-bind="text: addBtn"></span>
                </button>
            </div>

        </div>
        <div id="addGroupForm" class="container">
            <div class="row" >
                <label>Teacher name:</label> <input id="teachersComplete" name="teachername" class="coursesInputField" />
                <br />
                <label>StudentList:</label> <input id="studentListComplete" name="studentlistname" class="coursesInputField"/>
                <br />
                <button id="addGroupBtn" class="btn btn-default">Add</button>
            </div>
        </div>
    </div>



    <?php include_once('templates/jsdepends.php') ?>
</body>
</html>
