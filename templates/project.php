<?php
// Page initialisation
$location = "project";
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
        <style>
            #top-col {
                padding-bottom: 15px;
            }
            
            .form-next {
                display: inline-block !important;
                margin-right: 10px;
                width: auto !important;
            }

            .lock{
                background-image: url("/img/lock.jpg");
                background-repeat: no-repeat;
                background-position-y:-50px;
                width:235px;
                height:143px;
                margin-top:10px;
                background-position-x:90px;
            }

            .lock:hover {

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
                    
                    <button class="btn btn-lg savePageBtn pull-right" data-bind="text: savePage">
                        Save
                    </button>
                </div>
            </div>
        </div>

        <!-- Content container -->
        <div class="container" data-bind="foreach: competences">
            <div class="col-md-12 compPanel">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <input type="text" placeholder="Competence-Code" class="form-control form-next" data-bind="value: code">
                        <input type="text" placeholder="Name of the competence" class="form-control form-next" data-bind="value: name">
                        <span>Current weight: <input type="text" class="form-control form-next" data-bind="value: weight">%</span>
                        <img width="25px" height="25px" src=""/>
                    </div>
                    <div class="panel-body" data-bind="foreach: subcompetences">         
                        <div class="subcompPanel">
                            <div class="panel panel-default">
                                <div class="panel-heading color-subcomp">
                                    <input type="text" placeholder="SubCompetence-Code" class="form-control form-next" data-bind="value: code">
                                    <input type="text" placeholder="Name of the subcompetence" class="form-control form-next" data-bind="value: name">
                                    <span>Current weight: <input type="text" class="form-control form-next" data-bind="value: weight">%</span>
                                    <div class="lock"></div>
                                </div>
                                <div class="panel-body">
                                    <ul class="list-group" data-bind="foreach: indicators">
                                        <li class="list-group-item">
                                            <input type="text" placeholder="Indicatorname" class="form-control form-next" data-bind="value: name">
                                            <input type="text" placeholder="Description" class="form-control form-next" data-bind="value: description">
                                            <button class="btn" data-bind="click: removeThis">Remove this indicator</button>
                                            <img width="25px" height="25px" />
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
                    
                    <button class="btn btn-lg savePageBtn pull-right" data-bind="text: savePage">
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
