<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Grader - Administrator panel</title>

    <link href="/admin_static/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/admin_static/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
    <link href="/admin_static/dist/css/timeline.css" rel="stylesheet">
    <link href="/admin_static/dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="/admin_static/bower_components/morrisjs/morris.css" rel="stylesheet">
    <link href="/admin_static/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <?php include_once('hddepends.php') ?>

</head>

<body>
    <div id="wrapper">
    <?php
    require_once 'dptcms/security.php';
    require_once 'dptcms/config.php';
    ?>

    <!-- Main menu -->
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/home" data-bind="text: projectname">Grader</a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li <?php
                    if ($location == 'home') {
                        echo 'class="active"';
                    }
                    ?>><a href="/home" data-bind="text: homeBtn">Home</a></li>
                    <li><a href="/assess" data-bind="text: assessBtn">Assess</a></li>
                    <li class="<?php if ($location == 'projects') {
                        echo 'active';
                    } ?>"> <a href="/projects" data-bind="text: projecttypeBtn">Projects</a></li>

                    <!---------- RapportSysteem ---------->

                    <li class="<?php if ($location == 'jsrapport/homerapporten') {
                        echo 'active';
                    }
                    ?>"> <a href="homerapporten" >Home</a></li>

                    <li class="<?php if ($location == 'jsrapport/assessrapporten') {
                        echo 'active';
                    }
                    ?>"> <a href="/assessrapporten" >Assess</a></li>

                    <li class="<?php if ($location == 'jsrapport/coursesrapporten') {
                        echo 'active';
                    }
                    ?>"> <a href="/coursesrapporten" >Courses</a></li>
                    <li class="<?php if ($location == 'jsrapport/studentrapportrapporten') {
                        echo 'active';
                    }
                    ?>"> <a href="/studentrapportrapporten" >Rapport</a></li>

                    <!----------  RapportSysteem ---------->

                </ul>

                <ul class="nav navbar-nav navbar-right">

                    <?php
                    if (Security::isUserLoggedIn()) {

                        echo '<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">' . Security::getLoggedInName() . '<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="/account"><span class="navspan">Account</span></a></li>
                                <li><a href="/account/studentlists"><span class="navspan">Student lists</span></a></li>
                                <li><a href="/account/studentlistsrapporten"><span class="navspan">Student Lists (rapporten)</span></a></li>
                                 <li><a href="/templates/admin"><span class="navspan">Admin Panel</span></a></li>
                            </ul>
                        </li>';
                        echo '<li><a href="#" data-bind="text: logoutBtn" id="logoutbtn" onClick="javascript: logoutUser();">Logout</a></li>';
                    } else {
                        echo '<li><a href="#" data-bind="text: loginModalTitle" id="usermanagement">Login</a></li>';
                    }
                    ?>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Language <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><span class="navspan" onclick="setLang('en')">English</span></li>
                            <li><span class="navspan" onclick="setLang('nl')">Nederlands</span></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Modal overlay -->
    <div class="overlay" id="modaloverlay">

        <!-- Login modal -->
        <div class="modal_box" id="login_modal">
            <div class="modal_title" data-bind="text: loginModalTitle">
                Login
            </div>
            <div class="modal_error" id="login_error"></div>
            <form id="loginform">
                <div class="form-group">
                    <input type="text" class="form-control input-lg" placeholder="Email" data-bind="attr: {placeholder: email}" name="email">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control input-lg" placeholder="Password" data-bind="attr: {placeholder: password}" name="password">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-lg btn-block" data-bind="text: loginBtn">Log in</button>
                    <span class="margin-top"><a href="#" data-bind="text: forgotPswdBtn">Forgot password?</a></span>
                    <span class="pull-right margin-top"><a href="register" data-bind="text: notMemberBtn">Not a member yet?</a></span>
                </div>
            </form>
        </div>

        <!-- Yes no modal -->
        <div id="yes_no_modal" class="modal_box extrapadding">
            <div class="modal_title" data-bind="text: yesNoModaltitle">
                Are you sure?
            </div>
            <div id="modal_title_body" data-bind="text: yesNoModalBody">
                Bent u zeker dat u dit wenst te verwijderen?
            </div>
            <div class="form-inline rightbtns">
                <button class="btn btn-primary inline" data-bind="text: yes" id="ynmodel-y-btn">Yes</button>
                <button class="btn btn-primary inline" data-bind="text: no" id="ynmodal-n-btn">No</button>
            </div>
        </div>

        <!-- Upload modal -->
        <div id="upload_modal" class="modal_box extrapadding">
            <div class="modal_title" data-bind="text: uploadModalTitle">
                Upload a file
            </div>
            <div id="modal_title_body">
                <p>
                    To upload pictures to the server simply choose one ore more pictures form your hard drive and click upload.<br/>
                    The images must comply to the following restrictions:
                <ul>
                    <li>Maximum file size: <?php echo Config::$fileMaxSize/1024 ?>Mb</li>
                    <li>Supported file types: <?php echo Config::$fileFriendlySupport ?></li>
                </ul>
                </p>
                <form id="uploadform" enctype="multipart/form-data">
                    <table>
                        <tr>
                            <td><span data-bind="text: chooseFiles">Choose images</span>:</td>
                        </tr>
                        <tr>
                            <td><input type="file" name="files[]" multiple></td>
                            <td><button type="button" class="btn btn-primary inline" data-bind="text: upload" id="uploadformbtn">Upload</button></td>
                        </tr>
                    </table>
                </form>
                <div id="upload-result">

                </div>
            </div>
        </div>

        <!-- General modal -->
        <div id="general_modal" class="modal_box extrapadding">
            <div class="modal_title" id="general_modal_title"></div>
            <div id="general_modal_body"></div>
            <div class="form-inline rightbtns" id="general_modal_buttons">
            </div>
        </div>
    </div>


    <!-- Navigation -->
        <!--<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">Grader Admin</a>
            </div>
            <!-- /.navbar-header -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input  -group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="index.php"><i class="fa fa-home fa-fw fa-2x"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="permissions.php"><i class="fa fa-wrench fa-fw fa-2x"></i> Rechten</span></a>
                        </li>
                        <li>
                            <a href="users.php"><i class="fa fa-users fa-fw fa-2x"></i> Gebruikers</span></a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="/admin_static/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/admin_static/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="/admin_static/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="/admin_static/bower_components/raphael/raphael-min.js"></script>
    <script src="/admin_static/bower_components/morrisjs/morris.min.js"></script>
    <script src="/admin_static/js/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="/admin_static/dist/js/sb-admin-2.js"></script>

</body>

</html>
