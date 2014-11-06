<?php
	$location = basename(__FILE__, '.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Register for a DPTechnics account">
    <meta name="author" content="DPTechnics">
    <link rel="shortcut icon" href="favicon.ico">
    <title>DPTechnics - Register</title>
	<?php require('hddepends.php') ?>
	<link rel="stylesheet" href="/css/bootstrapValidator.min.css"/>
  </head>

  <body>
	<?php require('menu.php') ?>
    <div class="container">
		 <div class="jumbotron">
			<div class="jumbotitle">
				Register
			</div>
			<div class="jumbocontent" id="regcontent">
				<p>
				On this page you can register for a DPTechnics account. You will be able to post on the forum,
				use the webshop and many more in the futere. It is your unique and free ticket to all the DPTechnics
				services.
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
						<input type="text" class="form-control input-lg" placeholder="Username" name="user" autocomplete="off" value="">
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
		</div>
    </div>

	<?php require('footer.php') ?>
	<?php require('jsdepends.php') ?>    
  </body>
</html>
