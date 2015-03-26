<?php
    $location = "jsrapport/assessrapporten";
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
        
        <?php include_once('templates/hddepends.php') ?>
    </head>
    
    <body>
        <?php include_once('templates/menu.php') ?>
        
        <!-- Header container -->
        <div class="container">
            <h1 class="page-header" data-bind="text: pageHeader">Assess students</h1>
        </div>

        <!-- Content container -->
        <div class="container">
            <div class="big-info"><span data-bind="text: selectCourse">Select course</span>:</div>
            <div class="row">
                <div class="dropdown col-md-3">
                    <button class="btn btn-wide btn-default btn-courseRapport dropdown-toggle" type="button" id="courseRapport" data-toggle="dropdown" aria-expanded="true">
                        <span class="text-center">Course</span>
                        <span class="pull-right caret-down caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-courseRapport ul-wide" role="menu" aria-labelledby="courseRapport" data-bind="foreach: availableCoursesRapport" id="testcliker">
                        <li class="li-wide" role="presentation"><a role="menuitem" tabindex="-1" href="#" data-bind="attr:{'id': 'locbtn-' + id}"><span data-bind="text: name"></span></a> </li>
                    </ul>
                </div>

                <div class="dropdown col-md-3">
                    <button class="btn btn-wide btn-default btn-module dropdown-toggle" type="button" id="modules" data-toggle="dropdown" aria-expanded="true">
                        <span class="text-center">Module</span>
                        <span class="pull-right caret-down caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-module ul-wide" role="menu" aria-labelledby="modules" data-bind="foreach: availableModules">
                        <li class="li-wide" role="presentation"><a role="menuitem" tabindex="-1" href="#" data-bind="attr:{'id': 'modulebtn-' + id}"><span data-bind="text: name"></span></a></li>
                    </ul>
                </div>

                <div class="dropdown col-md-3">
                    <button class="btn btn-wide btn-default btn-submodule dropdown-toggle" type="button" id="availableSubmodules" data-toggle="dropdown" aria-expanded="true">
                        <span class="text-center">Sub-module</span>
                        <span class="pull-right caret-down caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-submodule ul-wide" role="menu" aria-labelledby="availableSubmodules" data-bind="foreach: availableSubmodules">
                        <li class="li-wide" role="presentation"><a role="menuitem" tabindex="-1" href="#" data-bind="attr:{'id': 'submodulebtn-' + id}"><span data-bind="text: name"></span></a> </li>
                    </ul>
                </div>

                <div class="dropdown col-md-3">
                    <button class="btn btn-wide btn-default btn-goal dropdown-toggle" type="button" id="availableGoals" data-toggle="dropdown" aria-expanded="true">
                        <span class="text-center">Goal</span>
                        <span class="pull-right caret-down caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-goal ul-wide" role="menu" aria-labelledby="availableGoals" data-bind="foreach: availableGoals">
                        <li class="li-wide" role="presentation"><a role="menuitem" tabindex="-1" href="#" data-bind="attr:{'id': 'goalbtn-' + id}"><span data-bind="text: name"></span></a> </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Content container -->
        <div class="container">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th data-bind="text: studIDTableTitleRapport">Student ID</th>
                    <th data-bind="text: nameTableTitleRapport">Name</th>
                    <th data-bind="text: lastNameTableTitleRapport">Last name</th>
                    <th data-bind="text: mailTableTitleRapport">Mail</th>
                    <th data-bind="text: scoreTableTitleRapport">Score</th>
                </tr>
                </thead>
                <tbody data-bind="foreach: tabledata">
                <tr>
                    <td data-bind="text: tstudidRapport">--</td>
                    <td data-bind="text: tnameRapport">--</td>
                    <td data-bind="text: tlnameRapport">--</td>
                    <td data-bind="text: tmailRapport">--</td>
                    <td data-bind="text: tscoreRapport">--</td>
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
        </div>

        <?php include_once('templates/jsdepends.php') ?>
    </body>
</html>
