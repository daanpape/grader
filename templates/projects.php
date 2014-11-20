<?php
// Page initialisation
$location = "projects";
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

        <title data-bind="text: title"></title>

        <?php include_once('hddepends.php') ?>
    </head>

    <body>
        <?php include_once('menu.php') ?>

        <!-- Header container -->
        <div class="container">
            <h1 class="page-header" data-bind="text: pageHeader">Projects</h1>
        </div>
        <!-- Content container -->
        <div class="container">
            <div class="big-info"><span data-bind="text: selectCourse">Select course</span>:</div>
            <div class="row">
                <div class="dropdown col-md-4">
                    <button class="btn btn-wide btn-default btn-location dropdown-toggle" type="button" id="locations" data-toggle="dropdown" aria-expanded="true">
                        <span class="text-center">Locations</span>
                        <span class="pull-right caret-down caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-location ul-wide" role="menu" aria-labelledby="locations" data-bind="foreach: availableLocations" id="testcliker">
                        <li class="li-wide" role="presentation"><a role="menuitem" tabindex="-1" href="#" data-bind="attr:{'id': 'locbtn-' + id}"><span data-bind="text: name"></span></a> </li>
                    </ul>
                </div>

                <div class="dropdown col-md-4">
                    <button class="btn btn-wide btn-default btn-training dropdown-toggle" type="button" id="trainings" data-toggle="dropdown" aria-expanded="true">
                        <span class="text-center">Trainings</span>
                        <span class="pull-right caret-down caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-training ul-wide" role="menu" aria-labelledby="trainings" data-bind="foreach: availableTrainings">
                        <li class="li-wide" role="presentation"><a role="menuitem" tabindex="-1" href="#" data-bind="attr:{'id': 'trainingbtn-' + id}"><span data-bind="text: name"></span></a></li>
                    </ul>
                </div>

                <div class="dropdown col-md-4">
                    <button class="btn btn-wide btn-default btn-course dropdown-toggle" type="button" id="availableCourses" data-toggle="dropdown" aria-expanded="true">
                        <span class="text-center">Courses</span>
                        <span class="pull-right caret-down caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-course ul-wide" role="menu" aria-labelledby="availableCourses" data-bind="foreach: availableCourses">
                        <li class="li-wide" role="presentation"><a role="menuitem" tabindex="-1" href="#" data-bind="attr:{'id': 'coursebtn-' + id}"><span data-bind="text: name"></span></a> </li>
                    </ul>

                </div>
            </div>
        </div>
        
        <!-- Content container -->
        <div class="container">
            <div class="big-info"><span data-bind="text: foundProjects">Found projects</span>:</div>
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
                            <span class="glyphicon glyphicon-trash glyphicon-btn" data-bind="attr:{'id': 'removebtn-' + tid}"></span>
                            <a data-bind="attr: {'href': '/project/' + tid"><span class="glyphicon glyphicon-plus glyphicon-btn" data-bind="attr:{'id': 'managebtn-' + tid}"></span></a>
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

            <button type="button" class="btn btn-default pagination-button" id="addProjectTypeBtn">
                <span class="glyphicon glyphicon-plus"></span> <span data-bind="text: addBtn"></span>
            </button>
        </div>

        <?php include_once('jsdepends.php') ?>
    </body>
</html>
