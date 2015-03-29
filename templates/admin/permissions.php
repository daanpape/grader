<?php
// Page initialisation
$location = "adminPermissions";
?>
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
    <link rel="stylesheet" href="../../css/grader.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body style="padding-top: 0px">

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Grader Admin</a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-nav navbar-right" style="margin-right: 5%">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Language <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><span class="navspan" onclick="setLang('en')">English</span></li>
                    <li><span class="navspan" onclick="setLang('nl')">Nederlands</span></li>
                </ul>
            </li>
        </ul>

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
                        <a href="index.php"><i class="fa fa-home fa-fw fa-lg"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="permissions.php"><i class="fa fa-wrench fa-fw fa-2x"></i> Rechten</span></a>
                    </li>
                    <li>
                        <a href="users.php"><i class="fa fa-users fa-fw fa-lg"></i> Gebruikers</span></a>
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
                <h1 class="page-header" data-bind="text: pageHeader">Rechten</h1>
            </div>

            <div>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th data-bind="text: permissionRole">Role</th>
                        <th data-bind="text: permissionDescription">Description</th>
                    </tr>
                    </thead>
                    <tbody data-bind="foreach: users">
                    <tr>
                        <td>Guest</td>
                        <td>When not logged in you get the GUEST role.</td>
                    </tr>
                    </tbody>
                    <tbody data-bind="foreach: users">
                    <tr>
                        <td>SuperUser</td>
                        <td>The superuser role must have access to everything...</td>
                    </tr>
                    </tbody>
                    <tbody data-bind="foreach: users">
                    <tr>
                        <td>User</td>
                        <td>Contains rights for every USER in the system.</td>
                    </tr>
                    </tbody>
                    <tbody data-bind="foreach: users">
                    <tr>
                        <td>STUDENT</td>
                        <td>Can only do studentactions</td>
                    </tr>
                    </tbody>
            </div>

            <div>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th data-bind="text: userName">Username</th>
                        <th data-bind="text: firstName">Name</th>
                        <th data-bind="text: lastName">Lastname</th>
                        <th data-bind="text: userPermissions">Permissions</th>
                        <th data-bind="text: userActions">Actions</th>
                    </tr>
                    </thead>
                    <tbody data-bind="foreach: userPermission">
                    <tr>
                        <td>jonas.vanalderweireldt@student.howest.be</td>
                        <td>Jonas</td>
                        <td>Vanalderweireldt</td>
                        <td>SUPERUSER</td>
                        <td><i class="fa fa-wrench fa-lg"></i></td>
                    </tr>
                    </tbody>
            </div>
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

<?php include_once('jsdepends.php') ?>
</body>

</html>
