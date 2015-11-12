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
                    <button class="btn btn-lg addCompetenceBtn" data-bind="text: addCompetenceBtn">
                        Add competence
                    </button>
                    
                    <button class="btn btn-lg savePageBtn pull-right" data-bind="text: nextPage">
                        Save
                    </button>
                    </button>
                </div>
            </div>
            <!-- Validation Summary -->
            <div class="validationSummary hide">
                <h2>Project was not saved!</h2>
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
                        <span>Current weight: <input type="text" class="form-control form-next" data-bind="value: weight">%
                        <i class="icon-large icon-unlock" style="vertical-align: middle;" data-bind="value: locked, click: toggleLock"></i></span>
                    </div>
                    <div class="panel-body" data-bind="foreach: subcompetences">         
                        <div class="subcompPanel">
                            <div class="panel panel-default">
                                <div class="panel-heading color-subcomp">
                                    <input type="text" placeholder="SubCompetence-Code" class="form-control form-next" data-bind="value: code">
                                    <input type="text" placeholder="Name of the subcompetence" class="form-control form-next" data-bind="value: name">
                                    <span>Current weight: <input type="text" class="form-control form-next" data-bind="value: weight">%
                                    <i class="icon-large icon-unlock" style="vertical-align: middle;" data-bind="click: toggleLock"></i></span>
                                </div>
                                <div class="panel-body">
                                    <ul class="list-group" data-bind="foreach: indicators">
                                        <li class="list-group-item">
                                            <input type="text" placeholder="Indicatorname" class="form-control form-next" data-bind="value: name">
                                            <input type="text" placeholder="Description" class="form-control form-next" data-bind="value: description">
                                            <span>Current weight: <input type="text" class="form-control form-next" data-bind="value: weight">%
                                            <i class="icon-large icon-unlock" style="vertical-align: middle;" data-bind="click: toggleLock"></i></span>
                                            <button class="btn" data-bind="click: removeThis">Remove this indicator</button>
                                            <select>
                                                <option value="slider">Slider</option>
                                                <option value="points">Punten</option>
                                                <option value="ja/nee">Ja / Nee</option>
                                            </select>
                                        </li>
                                    </ul>
                                </div>
                                <div class="panel-footer color-subcomp">
                                    <button class="btn" value="NaN-0" data-bind="click: addIndicator">Add an indicator</button>
                                    <button class="btn pull-right" data-bind="click: removeThis">Remove this subcompetence</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button class="btn" value="NaN" data-bind="click: addSubCompetence">Add a subcompetence</button>
                        <button class="btn pull-right" value="NaN" data-bind="click: removeThis">Remove this competence</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container">
            <div class="row">
                <div id="bottom-col" class="col-md-12">
                    <button class="btn btn-lg addCompetenceBtn" data-bind="text: addCompetenceBtn">
                        Add competence
                    </button>
                    
                    <button class="btn btn-lg savePageBtn pull-right" data-bind="text: nextPage">
                        Save
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
