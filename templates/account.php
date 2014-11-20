<?php
// Page initialisation
$location = "account";
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
    <h1 class="page-header"><span data-bind="text: pageHeader">My Account</span>: <?php echo Security::getLoggedInName() ?></h1>
</div>

<!-- Content container -->
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <img src="/upload/unknown.png" class="avatarimg" alt="avatar"/>
        </div>
        <div class="col-md-8">
            <table class="table">
                <tr>
                    <td>Voornaam:</td>
                    <td>Daan</td>
                </tr>
                
                <tr>
                    <td>Naam:</td>
                    <td>Pape</td>
                </tr>
                
                <tr>
                    <td>Email:</td>
                    <td>daan@dptechnics.com</td>
                </tr>
                
                <tr>
                    <td>Lid sinds:</td>
                    <td>20/11/2014</td>
                </tr>
            </table>
        </div>
    </div>
</div>

<div class="container">
    <h1 class="page-header">Mijn projecten</h1>
</div>

<?php include_once('jsdepends.php') ?>
</body>
</html>
