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

    <style>
        .form-next{
            margin-bottom: 1%;
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
                            <select data-bind="foreach: viewModel.projectActions, value: action" class="form-control form-next">
                                <option data-bind="text: name"></option>
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
                                <input type="text" class="form-control form-next" placeholder="Result on total score /100"  data-bind="value: result">
                                <button class="btn deleteRuleBtn" data-bind="click: removeThisRule">
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
