<?php
// Page initialisation
$location = "register";
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
            <h1 class="page-header" data-bind="text: pageHeader">Register</h1>
        </div>

        <!-- Content container -->
        <div class="container" id="regcontent">
            <p>
                Register for a Grader account on this page. 
            </p>
            <div class="modal_error" id="login_error">Please check the data you entered.</div>
            <form id="registerform" autocomplete="off">
                <!-- Prevent chrome autofill -->
                <input style="display:none" type="text" name="username"/>
                <input style="display:none" type="password" name="password"/>
                <input type="hidden" name="lang" value="EN"/>
                <!-- --- -->

                <div class="row">
                    <div class="col-md-6 form-group "><input type="text" class="form-control input-lg" placeholder="Firstname" name="firstname" autocomplete="off" value=""></div>
                    <div class="col-md-6 form-group "><input type="text" class="form-control input-lg" placeholder="Lastname" name="lastname" autocomplete="off" value=""></div>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control input-lg" placeholder="Email" name="email" autocomplete="off" value="">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control input-lg" placeholder="Password" name="pass" autocomplete="off" value="">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control input-lg" placeholder="Repeat password" name="passconfirm" autocomplete="off" value="">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-lg btn-block">Register</button>
                </div>
            </form>
        </div>

        <!-- Pagination and action container -->
        <div class="container">

        </div>

        <?php include_once('jsdepends.php') ?>
        <script src="/js/bootstrapValidator.min.js"></script>
    </body>
</html>
