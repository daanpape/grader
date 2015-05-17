<?php
// Page initialisation
$location = "jsrapport/modulerapporten";
?>
<!DOCTYPE html>
<html lang="nl" id="htmldoc">
    <head>
        <style>
            #top-col {
                padding-bottom: 15px;
            }
            
            .form-name {
                display: inline-block !important;
                margin-right: 10px;
                width: 300px !important;
            }
            
            .form-desc {
                display: inline-block !important;
                margin-right: 10px;
                width: 520px !important;
            }

            .validationSummary
            {
                color: red;
            }

            .hide{
                display: none;
            }
        </style>

        <?php include_once('templates/hddepends.php') ?>
    </head>

    <body>
        <?php include_once('templates/menu.php') ?>

        <!-- Header container -->
        <div class="container">
            <h1 class="page-header" id="projectHeader" data-value="<?php echo $courseid ?>"><?php echo $coursename ?></h1>
            <div class="row">
                <div id="top-col" class="col-md-12">
                    <button class="btn btn-lg addmoduleBtn" data-bind="text: addmoduleBtn">
                        Add module
                    </button>
                    
                    <button class="btn btn-lg savePageBtn pull-right" data-bind="text: savePage">
                        Save
                    </button>
                </div>
            </div>
            <!-- Validation Summary -->
            <div class="validationSummary hide">
                <h2>Course was not saved!</h2>
                <ul></ul>
            </div>
        </div>

        <!-- Content container -->
        <div class="container" data-bind="foreach: modules">
            <div class="col-md-12 compPanel">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <input type="text" placeholder="module name" class="form-control form-name" data-bind="value: name">
                        <input type="text" placeholder="module description" class="form-control form-desc" data-bind="value: description">
                    </div>
                    <div class="panel-body" data-bind="foreach: doelstellingen">         
                        <div class="subcompPanel">
                            <div class="panel panel-default">
                                <div class="panel-heading color-subcomp">
                                    <input type="text" placeholder="competence name" class="form-control form-name" data-bind="value: name">
                                    <input type="text" placeholder="competence description" class="form-control form-desc" data-bind="value: description">
                                </div>
                                <div class="panel-body">
                                    <ul class="list-group" data-bind="foreach: criterias">
                                        <li class="list-group-item">
                                            <input type="text" placeholder="criteria name" class="form-control form-name" data-bind="value: name">
                                            <input type="text" placeholder="criteria description" class="form-control form-desc" data-bind="value: description">
                                            <button class="btn" data-bind="click: removeThis">Remove this criteria</button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="panel-footer color-subcomp">
                                    <button class="btn" value="NaN-0" data-bind="click: addCriteria">Add a criteria</button>
                                    <button class="btn pull-right" data-bind="click: removeThis">Remove this competence</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button class="btn" value="NaN" data-bind="click: addDoelstelling">Add a competence</button>
                        <button class="btn pull-right" value="NaN" data-bind="click: removeThis">Remove this module</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container">
            <div class="row">
                <div id="bottom-col" class="col-md-12">
                    <button class="btn btn-lg addmoduleBtn" data-bind="text: addmoduleBtn">
                        Add module
                    </button>
                    
                    <button class="btn btn-lg savePageBtn pull-right" data-bind="text: savePage">
                        Save
                    </button>
                </div>
            </div>
        </div>

        <?php include_once('templates/jsdepends.php') ?>
        <script>
            var courseid = <?php echo $courseid ?>
        </script>
    </body>
</html>
