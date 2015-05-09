<?php
    $location = "jsrapport/worksheetrapporten";
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
            <h1 class="page-header" data-bind="text: app">Worksheets</h1>
        </div>
        
        <!-- Content container -->
        <div class="container">
            <div class="big-info"><span data-bind="text: selectCourse">Select course</span>:</div>
            <div class="row">
                <div class="dropdown col-md-4">
                    <button class="btn btn-wide btn-default btn-courseRapport dropdown-toggle" type="button" id="courseRapport" data-toggle="dropdown" aria-expanded="true">
                        <span class="text-center">Course</span>
                        <span class="pull-right caret-down caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-courseRapport ul-wide" role="menu" aria-labelledby="courseRapport" data-bind="foreach: availableCourses" id="testcliker">
                        <li class="li-wide" role="presentation"><a role="menuitem" tabindex="-1" href="#" data-bind="attr:{'id': 'coursebtn-' + id}"><span data-bind="text: name"></span></a><p id="errormessage" class="text-danger">*</p> </li>
                    </ul>
                </div>            
            </div>
        </div>
        
        <!-- Content container -->
        <div class="container">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th data-bind="text: werkficheID">Werkfiche ID</th>
                    <th data-bind="text: werkficheName">Name</th>
                    <th data-bind="text: werkficheAction">Actions</th>
                </tr>
                </thead>
                <tbody data-bind="foreach: tabledata">
                <tr>
                    <td data-bind="text: tid">--</td>     
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