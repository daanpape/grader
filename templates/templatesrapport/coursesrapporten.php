<?php
    // Page initialisation
    $location = "jsrapport/coursesrapporten";
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
            <h1 class="page-header" data-bind="text: pageHeader">Courses</h1>
        </div>
        
        <!-- Content container -->
        <div class="container">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th data-bind="text: codeTableTitle">Code</th>
                        <th data-bind="text: nameTableTitle">Name</th>
                        <th data-bind="text: descTableTitle">Description</th>
                        <th data-bind="text: actionTableTitle">Actions</th>
                    </tr>
                </thead>
                <tbody data-bind="foreach: tabledata">
                    <tr>
                        <td data-bind="text: tcode">--</td>
                        <td data-bind="text: tname">--</td>
                        <td data-bind="text: tdesc">--</td>
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

            <button type="button" class="btn btn-default pagination-button" id="addCourseBtn">
                <span class="glyphicon glyphicon-plus"></span> <span data-bind="text: addBtn"></span>
            </button>
        </div>

        <?php include_once('templates/jsdepends.php') ?>
    </body>
</html>