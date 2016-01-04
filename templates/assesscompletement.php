<?php
// Page initialisation
$location = "assesscompletement";
?>
<!DOCTYPE html>
<html lang="nl" id="htmldoc">
<head>
    <?php include_once('hddepends.php') ?>
</head>

<style>
    input[type=range] {
        -webkit-appearance: none;
        width: 100%;
        margin: 13.8px 0;
    }
    input[type=range]:focus {
        outline: none;
    }
    input[type=range]::-webkit-slider-runnable-track {
        width: 100%;
        height: 8.4px;
        cursor: pointer;
        box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
        background: #ffffff;
        border-radius: 1.3px;
        border: 0.2px solid #010101;
    }
    input[type=range]::-webkit-slider-thumb {
        box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
        border: 1px solid #000000;
        height: 36px;
        width: 16px;
        border-radius: 3px;
        background: #ffffff;
        cursor: pointer;
        -webkit-appearance: none;
        margin-top: -14px;
    }
    input[type=range]:focus::-webkit-slider-runnable-track {
        background: #ffffff;
    }
    input[type=range]::-moz-range-track {
        width: 100%;
        height: 8.4px;
        cursor: pointer;
        box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
        background: #ffffff;
        border-radius: 1.3px;
        border: 0.2px solid #010101;
    }
    input[type=range]::-moz-range-thumb {
        box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
        border: 1px solid #000000;
        height: 36px;
        width: 16px;
        border-radius: 3px;
        background: #ffffff;
        cursor: pointer;
    }
    input[type=range]::-ms-track {
        width: 100%;
        height: 8.4px;
        cursor: pointer;
        background: transparent;
        border-color: transparent;
        color: transparent;
    }
    input[type=range]::-ms-fill-lower {
        background: #ffffff;
        border: 0.2px solid #010101;
        border-radius: 2.6px;
        box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
    }
    input[type=range]::-ms-fill-upper {
        background: #ffffff;
        border: 0.2px solid #010101;
        border-radius: 2.6px;
        box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
    }
    input[type=range]::-ms-thumb {
        box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
        border: 1px solid #000000;
        height: 36px;
        width: 16px;
        border-radius: 3px;
        background: #ffffff;
        cursor: pointer;
        height: 8.4px;
    }
    input[type=range]:focus::-ms-fill-lower {
        background: #ffffff;
    }
    input[type=range]:focus::-ms-fill-upper {
        background: #ffffff;
    }
    input[type="range"] {
        -webkit-appearance:none !important;
        pointer:cursor;
        background: -webkit-linear-gradient(left, darkred, lawngreen); /* For Safari 5.1 to 6.0 */
        background: -o-linear-gradient(right, darkred, lawngreen); /* For Opera 11.1 to 12.0 */
        background: -moz-linear-gradient(left, darkred, lawngreen); /* For Firefox 3.6 to 15 */
        background: linear-gradient(right, darkred, lawngreen); /* Standard syntax */
        height: 25px;
        -webkit-border-radius:15px;
        -moz-border-radius:5px;
        background-repeat: no-repeat;
    }

    .table > tbody > tr > td {
        vertical-align: middle;
        text-align: center;
    }

    th {
        text-align: center;
    }

    ul > li {
        cursor:pointer;
    }

</style>
<body>
<?php include_once('menu.php') ?>

<!-- Header container -->
<div class="container">
    <h1 class="page-header" id="projectHeader" data-value="<?php echo $projectid ?>" data-bind="text: pageHeader">Project</h1>
    <div class="row">
        <div id="top-col" class="col-md-12">
            <div class="col-lg-12 container">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th data-bind="text: nameTableTitle">Name</th>
                            <th data-bind="text: projectWeight">Weight</th>
                            <th data-bind="text: documentSubmit"></th>
                            <th data-bind="text: documentScore"></th>
                        </tr>
                        </thead>
                        <tbody data-bind="foreach: documents">
                            <tr>
                                <td><span data-bind="text: description"></span></td>
                                <td><span data-bind="text: weight"></span></td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-default dropdown-toggle" type="button" id="menu1" data-toggle="dropdown"><span data-bind="text: notSubmitted"></span>
                                            <span class="caret"></span></button>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="menu1" data-bind="foreach: nrNotSubmitted">
                                            <li role="presentation"><a role="menuitem" data-bind="text: $data, click: viewModel.changeNotSubmitted.bind($data,$parent)"></a></li>
                                        </ul>
                                    </div>
                                </td>
                                <tr data-bind="foreach: nrDocuments">
                                    <input class="form-control" type="text">
                                </tr>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div class="col-md-12">
                    <button style="float:right" id="cancelBtn" type="button" class="btn btn-default pagination-button" data-bind="text: cancelBtn">Cancel</button>
                    <button style="float:right"  data-value="<?php echo $studentid ?>" id="saveBtn" type="button" class="btn btn-default pagination-button">
                        <span class="glyphicon glyphicon-floppy-disk"></span>
                        <span data-bind="text: saveBtn">Save</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content container -->
<div class="container">
</div>

<script>
    var projectid = <?php echo $projectid ?>
</script>


<?php include_once('jsdepends.php') ?>
</body>
</html>
