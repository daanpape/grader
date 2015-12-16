<?php
// Page initialisation
$location = "assessproject";
?>
<!DOCTYPE html>
<html lang="nl" id="htmldoc">
<head>

    <script src="/jsPDF/dist/jspdf.debug.js" ></script>
    <script src="/jsPDF/customHowestPDF.js"></script>

    <?php include_once('hddepends.php') ?>

    <style>
        a:hover
        {
            text-decoration: none;
        }

        .popup {
            border: thin #aaa solid;
            -webkit-box-shadow: 1px 1px 4px rgba(50, 50, 50, 0.75);
            -moz-box-shadow:    1px 1px 4px rgba(50, 50, 50, 0.75);
            box-shadow:         1px 1px 4px rgba(50, 50, 50, 0.75);
            padding: 0.3em 1em;
            background-color: white;
        }

        .positioning {
            text-align: center;
        }

        .positioning button {
            width: 200px;
        }
    </style>


</head>

<body>
<?php include_once('menu.php') ?>


<!-- Header container -->
<div class="container">
    <h1 class="page-header" id="projectHeader" data-value="<?php echo $projectid ?>" data-bind="text: pageHeader">Project</h1>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped">
                <tr>
                    <td style="width: 75%"><input type="text" id="searchField" class="form-control form-next" placeholder="Name of the student" data-bind="value: searchStudent"></td>
                    <td style="width: 10%"><a href="#" data-bind="click: function() { getStudentByName() }" type="button" class="btn btn-default">
                            <span class="glyphicon glyphicon-search"></span>
                        </a> <a href="#" data-bind="click: function() { showFullList() }" type="button" class="btn btn-default">
                            <span class=" glyphicon glyphicon-refresh"></span>
                        </a></td>
                    <td style="vertical-align: middle"><p style="display:inline-block; margin-right: 5px" data-bind="text: assessProjectCompleted">Status:</p><p style="display:inline-block" data-bind="text: totalCompleted"></p><p style="display:inline-block; margin-left: 2px; margin-right: 2px">/</p><p style="display:inline-block" data-bind="text: totalStudents"></p></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div id="top-col" class="col-md-12">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th data-bind="text: assessProjectStatus">Status</th>
                    <th data-bind="text: firstNameTableTitle">FirstName</th>
                    <th data-bind="text: lastNameTableTitle">LastName</th>
                    <th data-bind="text: scoreTableTitle">Scores</th>
                    <th data-bind="text: filesTableTitle">Scores</th>
                    <th data-bind="text: actionTableTitle">Actions</th>
                </tr>
                </thead>
                <tbody data-bind="foreach: tabledata">
                <tr>
                    <!-- ko if: tAssessedCompleted === 'EMPTY' -->
                    <td style="text-align: center"><img src="../img/check_red.png" alt="" title="red" width="25px" height="25px"></td>
                    <!-- /ko -->

                    <!-- ko if: tAssessedCompleted === 'BUSY' -->
                    <td style="text-align: center"><img src="../img/check_orange.png" alt="" title="orange" width="25px" height="25px"></td>
                    <!-- /ko -->

                    <!-- ko if: tAssessedCompleted === 'COMPLETED' -->
                    <td style="text-align: center"><img src="../img/check_green.png" alt="" title="green" width="25px" height="25px"></td>
                    <!-- /ko -->

                    <td data-bind="text: tfirstname">--</td>
                    <td data-bind="text: tlastname">--</td>
                    <td><a data-bind="attr:{'href': '/assess/project/' + tpid + '/student/' + tid + '/scores'}"><button  class="btn btn-default"><span class="glyphicons glyphicons-edit"></span><span data-bind="text: tScoreTableBtn"></span></button></a></td>
                    <td><a data-bind="attr:{'href': '/assess/project/' + tpid + '/student/' + tid + '/completeness'}"><button  class="btn btn-default"><span data-bind="text: tFilesTableBtn"></span></button></a></td>
                    <td><a href="#" data-bind="click: function() { createPDF($data.tid,$data.tfirstname,$data.tlastname,$data.email,viewModel.pageHeader(),viewModel.projectDescription()) }" type="button" class="btn btn-default">
                            <span class="glyphicon glyphicon-file"></span>
                            <span>PDF</span>
                    </a></td>
                    <td><a data-bind="popupTemplate: { template: 'test-template'}, click: function() { getData(tid) }" type="button" class="btn btn-default">
                            <span class="glyphicon glyphicon-info-sign"></span>
                            <span>Info</span>
                    </a></td>
                </tr><!-- Header container -->
                </tbody>
            </table>
        </div>

    </div>
</div>

<!-- Content container -->
<div class="container">
</div>

<script type="text/html" id="test-template">
    <div class="popup">
        <h4><u data-bind="text: viewModel.assessProjectAssessedBy">Assessed by</u></h4>
        <p id="popupContainer">
            <ul data-bind="foreach: viewModel.users">
                <li data-bind="text: $data"></li>
            </ul>
        </p>
    </div>
</script>

<?php include_once('jsdepends.php') ?>
<script src="/js/knockout.popupTemplate.js"></script>
</body>
</html>
