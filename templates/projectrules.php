<?php
// Page initialisation
$location = "projectRules";
?>
<!DOCTYPE html>
<html lang="nl" id="htmldoc">
<head>
    <?php include_once('hddepends.php') ?>

    <style>
        .form-next{
            margin-bottom: 1%;
        }

        .deleteRuleBtn{
            margin-top: 1%;
        }
    </style>
</head>

<body>
<?php include_once('menu.php') ?>

<!-- Header container -->
<div class="container">
    <h1 class="page-header" id="projectHeader" data-value="<?php echo $projectid ?>" data-bind="text: projectRulesTitle">Project Rules</h1>
</div>

<!-- Content container -->
<div class="container">
    <div class="row">
        <div class="col-lg-12 container">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr style="width: 100%">
                            <th style="width: 25%" data-bind="text: ruleName">Rule Name</th>
                            <th style="width: 50%" data-bind="text: actionTableTitle">Action</th>
                            <th style="width: 25%" data-bind="text: ruleResult">Result of the rule</th>
                        </tr>
                    </thead>
                    <tbody data-bind="foreach: projectRules">
                        <tr>
                            <td class="col-md-2">
                                <input type="text" class="form-control form-next" placeholder="Name of the rule" data-bind="value: name">
                            </td>

                            <td>
                                <select data-bind="{options: viewModel.projectActions, optionsText: 'name', value: action}" style="width: 200px;" class="form-control form-next">
                                </select>
                                <select data-bind="foreach: viewModel.availableOperators, value: operator" class="form-control form-next">
                                    <option data-bind="text: $data"></option>
                                </select>
                                <div>
                                    <input type="text" class="form-control form-next" placeholder="Value" data-bind="value: value">
                                </div>
                            </td>
                            <td>
                                <div>
                                    <input type="text" class="form-control form-next" placeholder="Percent"  data-bind="value: result">
                                    <button class="form-control btn btn-default form-next" data-bind="click: removeThisRule, text: viewModel.deleteRuleName">
                                        Remove this rule
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div id="bottom-col" class="col-md-12">
            <button type="button" class="btn btn-default addRuleBtn">
                <span class="glyphicon glyphicon-plus"></span>
                <span data-bind="text: addRuleName">Add Rule</span>
            </button>

            <button type="button" class="btn btn-default savePageBtn pull-right" >
                <span class="glyphicon glyphicon-floppy-disk"></span>
                <span data-bind="text: savePage">Save</span>
            </button>
        </div>
    </div>
</div>

<script>
    var projectid = <?php echo $projectid ?>
</script>

<?php include_once('jsdepends.php') ?>
</body>
</html>
