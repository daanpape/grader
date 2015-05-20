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
        <div id="top-col" class="col-md-12">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th data-bind="text: firstNameTableTitle">FirstName</th>
                    <th data-bind="text: lastNameTableTitle">LastName</th>
                    <th data-bind="text: scoreTableTitle">Scores</th>
                    <th data-bind="text: filesTableTitle">Scores</th>
                    <th data-bind="text: actionTableTitle">Actions</th>
                </tr>
                </thead>
                <tbody data-bind="foreach: tabledata">
                <tr>
                    <td data-bind="text: tfirstname">--</td>
                    <td data-bind="text: tlastname">--</td>
                    <td><a data-bind="attr:{'href': '/assess/project/' + tpid + '/student/' + tid + '/scores'}"><button class="btn"><span data-bind="text: tScoreTableBtn"></span></button></a></td>
                    <td><a data-bind="attr:{'href': '/assess/project/' + tpid + '/student/' + tid + '/completeness'}"><button class="btn"><span data-bind="text: tFilesTableBtn"></span></button></a></td>
                    <td><a href="#" data-bind="click: function() { createPDF($data.tid,$data.tfirstname,$data.tlastname,$data.email,viewModel.pageHeader(),viewModel.projectDescription()) }" class="glyphicon glyphicon-file"></a></td>
                    <td><button class="glyphicon glyphicon-tag" data-bind="popupTemplate: 'test-template'">Show popup</button></td>
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
        <h1>This is a popup</h1>
        <p>
            You can place any content in the popup template you
            want.
        </p>
    </div>
</script>

<?php include_once('jsdepends.php') ?>
<script src="/js/knockout.popupTemplate.js"></script>
</body>
</html>
