<?php
// Page initialisation
$location = "assessscore";
?>
<!DOCTYPE html>
<html lang="nl" id="htmldoc">
<head>
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
        input[type="range"] {
            -webkit-appearance:none !important;
            pointer:cursor;
            background: -webkit-linear-gradient(left, red, lawngreen); /* For Safari 5.1 to 6.0 */
            background: -o-linear-gradient(right, red, lawngreen); /* For Opera 11.1 to 12.0 */
            background: -moz-linear-gradient(left, red, lawngreen); /* For Firefox 3.6 to 15 */
            background: linear-gradient(right, red, lawngreen); /* Standard syntax */
            -webkit-border-radius:50px;
            -moz-border-radius:25px;
            background-repeat: no-repeat;
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
                                    <input type="range" min="0" max="100" step="1" data-bind="value: score" />
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
    var projectid = <?php echo $projectid ?>;
    var studentid = <?php echo $studentid ?>;
</script>
</body>
</html>


