<?php
// Page initialisation
$location = "projectrules";
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
    <h1 class="page-header" id="projectHeader" data-value="<?php echo $projectid ?>" data-bind="text: pageHeader">Project Rules</h1>
</div>

<!-- Content container -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Rule Name</th>
                        <th colspan="3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <input type="text" class="form-control form-next" data-bind="value: projectrulesName">
                        </td>

                        <td>
                            <div class="dropdown col-md-4">
                                <button class="btn btn-wide btn-default btn-location dropdown-toggle" type="button" id="locations" data-toggle="dropdown" aria-expanded="true">
                                    <span class="text-center">Action</span>
                                    <span class="pull-right caret-down caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-location ul-wide" role="menu" aria-labelledby="actions" data-bind="foreach: availableActions" id="avaAct">
                                    <li class="li-wide" role="presentation"><a role="menuitem" tabindex="-1" href="#" data-bind="attr:{'id': 'actbtn-' + id}"><span data-bind="text: name"></span></a> </li>
                                </ul>
                            </div>
                            <div class="dropdown col-md-2">
                                <button class="btn btn-wide btn-default btn-location dropdown-toggle" type="button" id="locations" data-toggle="dropdown" aria-expanded="true">
                                    <span class="text-center">Operator</span>
                                    <span class="pull-right caret-down caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-location ul-wide" role="menu" aria-labelledby="operator" data-bind="foreach: availableOperator" id="avaOpe">
                                    <li class="li-wide" role="presentation"><a role="menuitem" tabindex="-1" href="#" data-bind="attr:{'id': 'opebtn-' + id}"><span data-bind="text: name"></span></a> </li>
                                </ul>
                            </div>
                            <div>
                                <input type="text" class="form-control form-control" data-bind="value: projectrulesName">
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include_once('jsdepends.php') ?>
</body>
</html>
