<?php
// Page initialisation
$location = "assessscore";
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
        input[type=range] {
            -webkit-appearance: none;
            width: 100%;
            margin: 13.8px 0;
        }
        input[type=range]:focus {
            outline: none;
        }
        input[type=range]::-webkit-slider-runnable-track {
            width: 100%;
            height: 8.4px;
            cursor: pointer;
            box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
            background: #ffffff;
            border-radius: 1.3px;
            border: 0.2px solid #010101;
        }
        input[type=range]::-webkit-slider-thumb {
            box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
            border: 1px solid #000000;
            height: 36px;
            width: 16px;
            border-radius: 3px;
            background: #ffffff;
            cursor: pointer;
            -webkit-appearance: none;
            margin-top: -14px;
        }
        input[type=range]:focus::-webkit-slider-runnable-track {
            background: #ffffff;
        }
        input[type=range]::-moz-range-track {
            width: 100%;
            height: 8.4px;
            cursor: pointer;
            box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
            background: #ffffff;
            border-radius: 1.3px;
            border: 0.2px solid #010101;
        }
        input[type=range]::-moz-range-thumb {
            box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
            border: 1px solid #000000;
            height: 36px;
            width: 16px;
            border-radius: 3px;
            background: #ffffff;
            cursor: pointer;
        }
        input[type=range]::-ms-track {
            width: 100%;
            height: 8.4px;
            cursor: pointer;
            background: transparent;
            border-color: transparent;
            color: transparent;
        }
        input[type=range]::-ms-fill-lower {
            background: #ffffff;
            border: 0.2px solid #010101;
            border-radius: 2.6px;
            box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
        }
        input[type=range]::-ms-fill-upper {
            background: #ffffff;
            border: 0.2px solid #010101;
            border-radius: 2.6px;
            box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
        }
        input[type=range]::-ms-thumb {
            box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
            border: 1px solid #000000;
            height: 36px;
            width: 16px;
            border-radius: 3px;
            background: #ffffff;
            cursor: pointer;
            height: 8.4px;
        }
        input[type=range]:focus::-ms-fill-lower {
            background: #ffffff;
        }
        input[type=range]:focus::-ms-fill-upper {
            background: #ffffff;
        }

    </style>
</head>

<body>
<?php include_once('menu.php') ?>

<!-- Header container -->
<div class="container">
    <h1 class="page-header" id="projectHeader" data-value="<?php echo $projectid ?>" data-bind="text: pageHeader">Project</h1>
    <div class="row">
        <div id="top-col" class="col-md-12">
        </div>
    </div>
</div>

<!-- Content container -->
<div class="container" data-bind="foreach: competences">
    <div class="col-md-12 compPanel">
        <div class="panel panel-default">
            <div class="panel-heading">
                <label data-bind="text: name"></label>
            </div>
            <div class="panel-body" data-bind="foreach: subcompetences">
                <div class="subcompPanel">
                    <div class="panel panel-default">
                        <div class="panel-heading color-subcomp">
                            <label data-bind="text: name"></label>
                        </div>
                        <div class="panel-body">
                            <ul class="list-group" data-bind="foreach: indicators">
                                <li class="list-group-item">
                                    <label data-bind="text: description"></label>
                                    <input type="range" min="0" max="100" step="1" defaultValue="0" data-bind="value: score" />
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div id="bottom-col" class="col-md-12">
            <button class="btn btn-lg savePageBtn pull-left" data-bind="text: savePage">
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


