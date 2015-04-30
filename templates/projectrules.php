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
    <h1 class="page-header" id="projectHeader" data-value="<?php echo $projectid ?>">Project Rules</h1>
</div>

<!-- Content container -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                    <tr style="width: 100%">
                        <th style="width: 25%">Rule Name</th>
                        <th style="width: 50%">Action</th>
                        <th style="width: 25%">Result of the rule</th>
                    </tr>
                </thead>
                <tbody data-bind="foreach: projectRules">
                    <tr>
                        <td class="col-md-2">
                            <input type="text" class="form-control form-next" placeholder="Name of the rule" data-bind="value: name">
                        </td>

                        <td>
                            <select data-bind="foreach: viewModel.projectActions, value: action, optionValue: action" class="form-control form-next">
                                <option data-bind="text: name, value: $data"></option>
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
                                <span>Total score:</span>
                                <select class="form-control form-next" data-bind="foreach: viewModel.availableSigns, value: sign">
                                    <option data-bind="text: $data"></option>
                                </select>
                                <input type="text" class="form-control form-next" placeholder="Percent"  data-bind="value: result">
                                <button class="btn deleteRuleBtn form-next"  data-bind="click: removeThisRule">
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
