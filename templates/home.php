<?php
	// Page initialisation
	$location = "home";
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

		<div class="container">
			<div class="starter-template" data-bind="html: homeManual">
				<h1>Assessment tool</h1>
				<p class="lead">This HoWest Assessment tool is used to grade students.<br/>Please read this short manual
				before using the service.</p>
			</div>
		</div>

    <?php include_once('jsdepends.php') ?>
  </body>
</html>
