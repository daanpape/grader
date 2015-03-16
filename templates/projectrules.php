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
                        <th>Rule Name</th>
                        <th>Action</th>
                        <th>Result of the rule</th>
                    </tr>
                </thead>
                <tbody data-bind="foreach: projectRules">
                    <tr>
                        <td class="col-md-2">
                            <input type="text" class="form-control form-next" placeholder="Name of the rule" data-bind="value: name">
                        </td>

                        <td>
                            <div class="dropdown">
                                <button class="btn btn-wide btn-default btn-location dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
                                    <span class="text-center" data-bind="text: ruleActionDropdown">Action</span>
                                    <span class="pull-right caret-down caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-location ul-wide" role="menu" aria-labelledby="actions" data-bind="foreach: projectActions" id="avaAct">
                                    <li>test</li>
                                </ul>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-wide btn-default btn-location dropdown-toggle" type="button" id="locations" data-toggle="dropdown" aria-expanded="true">
                                    <span class="text-center">Operator</span>
                                    <span class="pull-right caret-down caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-location ul-wide" role="menu" aria-labelledby="operator" data-bind="foreach: availableOperator" id="avaOpe">
                                    <li class="li-wide" role="presentation"><a role="menuitem" tabindex="-1" href="#" data-bind="attr:{'id': 'opebtn-' + id}"><span data-bind="text: operatorName"></span></a> </li>
                                </ul>
                            </div>
                            <div>
                                <input type="text" class="form-control form-next" placeholder="Value" data-bind="value: projectrulesAction">
                            </div>
                        </td>
                        <td>
                            <div>
                                <input type="text" class="form-control form-next" placeholder="Result of the rule"  data-bind="value: projectrulesResult">
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
            <button class="btn btn-lg addRuleBtn" data-bind="text: addRuleName">
                Add Rule
            </button>

            <button class="btn btn-lg savePageBtn pull-right" data-bind="text: savePage">Save</button>
        </div>
    </div>
</div>

<script>
    var projectid = <?php echo $projectid ?>
</script>

<?php include_once('jsdepends.php') ?>
</body>
</html>
