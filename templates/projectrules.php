<?php
// Page initialisation
$location = "projectRules";
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
    <h1 class="page-header" id="projectHeader" data-value="<?php echo $projectid ?>" data-bind="text: projectRules">Project Rules</h1>
</div>

<!-- Content container -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th data-bind="text: ruleName">Rule Name</th>
                        <th data-bind="text: ruleAction">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="width: 33%">
                            <input type="text" class="form-control form-next" data-bind="value: projectrulesName">
                        </td>

                        <td>
                            <div class="dropdown col-md-4">
                                <button class="btn btn-wide btn-default btn-location dropdown-toggle" type="button" id="locations" data-toggle="dropdown" aria-expanded="true">
                                    <span class="text-center" data-bind="text: ruleActionDropdown">Action</span>
                                    <span class="pull-right caret-down caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-location ul-wide" role="menu" aria-labelledby="actions" data-bind="foreach: availableActions" id="avaAct">
                                    <li class="li-wide" role="presentation"><a role="menuitem" tabindex="-1" href="#" data-bind="attr:{'id': 'actbtn-' + id}"><span data-bind="text: actionName"></span></a> </li>
                                </ul>
                            </div>
                            <div class="dropdown col-md-2">
                                <button class="btn btn-wide btn-default btn-location dropdown-toggle" type="button" id="locations" data-toggle="dropdown" aria-expanded="true">
                                    <span class="text-center">Operator</span>
                                    <span class="pull-right caret-down caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-location ul-wide" role="menu" aria-labelledby="operator" data-bind="foreach: availableOperator" id="avaOpe">
                                    <li class="li-wide" role="presentation"><a role="menuitem" tabindex="-1" href="#" data-bind="attr:{'id': 'opebtn-' + id}"><span data-bind="text: operatorName"></span></a> </li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control form-next" data-bind="value: projectrulesName">
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div id="bottom-col" class="col-md-12">
            <button class="btn btn-lg addRule" data-bind="text: addRule">Add Rule</button>

            <button class="btn btn-lg savePageBtn pull-right" data-bind="text: savePage">Save</button>
        </div>
    </div>
</div>

<?php include_once('jsdepends.php') ?>
</body>
</html>
