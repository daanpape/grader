<?php
// Page initialisation
$location = "project";
?>
<!DOCTYPE html>
<html lang="nl" id="htmldoc">
    <head>
        <style>
            #top-col {
                padding-bottom: 15px;
            }
            
            .form-next {
                display: inline-block !important;
                margin-right: 10px;
                width: auto !important;
            }

            .validationSummary
            {
                color: red;
            }

            .hide{
                display: none;
            }

            .white-group-item {
                border-radius: 4px;
                padding:2%;
                list-style: none;
                background-color:white;
                border:1px solid #DDD;
            }


            .btn-color {
                color:black;
                background-color: rgb(240,240,240);
            }

            .dropdown > ul > li :hover {
                cursor:pointer;
            }
        </style>

        <?php include_once('hddepends.php') ?>
    </head>

    <body>
        <?php include_once('menu.php') ?>

        <!-- Header container -->
        <div class="container">
            <h1 class="page-header" id="projectHeader" data-value="<?php echo $projectid ?>" data-bind="text: pageHeader">Project</h1>
            <div class="row">
                <div id="top-col" class="col-md-12">
                    <button  type="button" class="btn btn-default"  data-bind="click: addCompetence">
                        <span class="glyphicon glyphicon-plus"></span>
                        <span data-bind="text: addCompetenceBtn">Add competence</span>
                    </button>

                    <button type="button" class="btn btn-default savePageBtn  pull-right">
                        <span class="glyphicon glyphicon-floppy-disk"></span>
                        <span  data-bind="text: nextPage">Save</span>
                    </button>
                </div>
            </div>
            <!-- Validation Summary -->
            <div class="validationSummary hide">
                <h2 data-bind="text: projectNotSaved">Project was not saved!</h2>
                <ul></ul>
            </div>
        </div>

        <!-- Content container -->
        <div class="container" data-bind="foreach: competences">
            <div class="col-md-12 compPanel">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <input type="text" placeholder="Competence-Code" class="form-control form-next" data-bind="value: code">
                        <input type="text" placeholder="Name of the competence" class="form-control form-next" data-bind="value: name">
                        <span data-bind="text: viewModel.projectWeight">Current weight:</span> <input type="text" class="form-control form-next" data-bind="value: weight">%
                        <i class="icon-large icon-unlock" style="vertical-align: middle;" data-bind="value: locked, click: toggleLock"></i>
                    </div>
                    <div class="panel-body" data-bind="foreach: subcompetences">         
                        <div class="subcompPanel">
                            <div class="panel panel-default">
                                <div class="panel-heading color-subcomp">
                                    <input type="text" placeholder="SubCompetence-Code" class="form-control form-next" data-bind="value: code">
                                    <input type="text" placeholder="Name of the subcompetence" class="form-control form-next" data-bind="value: name">
                                    <span data-bind="text: viewModel.projectWeight">Current weight:</span> <input type="text" class="form-control form-next" data-bind="value: weight">%
                                    <i class="icon-large icon-unlock" style="vertical-align: middle;" data-bind="click: toggleLock"></i>
                                </div>
                                <div class="panel-body">
                                    <ul class="list-group" data-bind="foreach: indicators">
                                        <li class="list-group-item">
                                            <input type="text" placeholder="Indicatorname" class="form-control form-next" data-bind="value: name">
                                            <input type="text" placeholder="Description" class="form-control form-next" data-bind="value: description">
                                            <span data-bind="text: viewModel.projectWeight">Current weight:</span> <input type="text" class="form-control form-next" data-bind="value: weight">%
                                            <i class="icon-large icon-unlock" style="vertical-align: middle;" data-bind="click: toggleLock"></i>
                                            <button class="btn btn-default" data-bind="click: removeThis, text: viewModel.projectRemoveIndicator">Remove this indicator</button>
                                            <div class="dropdown">
                                                <button class="btn btn-default dropdown-toggle" type="button" id="menu1" data-toggle="dropdown"><span data-bind="text: pointType"></span>
                                                    <span class="caret"></span></button>
                                                <ul class="dropdown-menu" role="menu" aria-labelledby="menu1" data-bind="foreach: viewModel.availableTypes">
                                                    <li role="presentation"><a role="menuitem" data-bind="text: $data, click: viewModel.changePointType.bind($data,$parent)"></a></li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="panel-footer color-subcomp">
                                    <button class="btn btn-default" value="NaN-0" data-bind="click: addIndicator">
                                        <span class="glyphicon glyphicon-plus"></span>
                                        <span data-bind="text: viewModel.projectAddIndicator">Add an indicator</button>
                                    <button class="btn btn-default pull-right" data-bind="click: removeThis">
                                        <span class="glyphicon glyphicon-plus"></span>
                                        <span data-bind="text: viewModel.projectRemoveSubComptence">Remove this subcompetence</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button class="btn btn-default" value="NaN" data-bind="click: addSubCompetence">
                            <span class="glyphicon glyphicon-plus"></span>
                            <span data-bind="text: viewModel.projectAddSubComptence">Add a subcompetence</span>
                        </button>
                        <button class="btn btn-default pull-right" value="NaN" data-bind="click: removeThis, text: viewModel.projectRemoveComptence">Remove this competence</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container">
            <div class="row">
                <div id="bottom-col" class="col-md-12">
                    <button  type="button" class="btn btn-default"  data-bind="click: addCompetence">
                        <span class="glyphicon glyphicon-plus"></span>
                        <span data-bind="text: addCompetenceBtn">Add competence</span>
                    </button>

                    <button type="button" class="btn btn-default savePageBtn  pull-right">
                        <span class="glyphicon glyphicon-floppy-disk"></span>
                        <span  data-bind="text: nextPage">Save</span>
                    </button>
                </div>
            </div>
        </div>

        <?php include_once('jsdepends.php') ?>
        <script>
            var projectid = <?php echo $projectid ?>
        </script>
    </body>
</html>
