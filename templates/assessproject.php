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

    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">

    <style>
        a:hover
        {
            text-decoration: none;
        }
    </style>


</head>

<body>
<?php include_once('menu.php') ?>

<a class="btn" id="popoverData" href="#" data-content="Popover with data-trigger" rel="popover" data-placement="bottom" data-original-title="Title" data-trigger="hover">Popover with data-trigger</a>

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
                    <td></td>
                </tr><!-- Header container -->
                </tbody>
            </table>
        </div>

    </div>
</div>

<!-- Content container -->
<div class="container">
</div>

<?php include_once('jsdepends.php') ?>
</body>
</html>
