<?php
// Page initialisation
$location = "adminAddUser";
?>
<!DOCTYPE html>
<html lang="nl" id="htmldoc">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Grader - Admin panel</title>

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

        <ul class="nav navbar-nav navbar-right" style="margin-right: 5%">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Language <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><span class="navspan" onclick="setLang('en')">English</span></li>
                    <li><span class="navspan" onclick="setLang('nl')">Nederlands</span></li>
                </ul>
            </li>
        </ul>

        <!-- /.navbar-header -->

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li>
                        <a href="index.php"><i class="fa fa-home fa-fw fa-lg"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="permissions.php"><i class="fa fa-wrench fa-fw fa-lg"></i> Rechten</span></a>
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
                <h1 class="page-header" data-bind="text: pageHeaderAddUser">Add User</h1>
            </div>
        </div>

        <!-- /.col-lg-12 -->
        <div>
        <form id="addUserForm" autocomplete="off">
            <table class="table table-striped">
                <tr>
                    <td>Firstname</td>
                    <td><input type="text" class="form-control form-next" placeholder="Firstname" name="firstname"
                               data-bind="value: value"></td>
                </tr>
                <tr>
                    <td>Lastname</td>
                    <td><input type="text" class="form-control form-next" placeholder="Lastname" name="lastname"
                               data-bind="value: value"></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input type="text" class="form-control form-next" placeholder="Email" name="email">
                    </td>
                </tr>
                <tr>
                    <td>password</td>
                    <td><input type="password" class="form-control form-next" placeholder="Password" name="pass"
                               data-bind="value: value"></td>
                </tr>
                <tr>
                    <td>Confirm password</td>
                    <td><input type="password" class="form-control form-next" placeholder="Confirm password" name="passconfirm"
                               data-bind="value: value"></td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>
                        <select class="form-control form-next">
                            <option>Active</option>
                            <option>Non-Active</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Permission</td>
                    <td>
                        <select class="form-control form-next">
                            <option>GUEST</option>
                            <option>STUDENT</option>
                            <option>USER</option>
                            <option>SUPERUSER</option>
                        </select>
                    </td>
                </tr>
            </table>

            <div class="container">
                <div class="row">
                    <div id="bottom-col" class="col-md-12">
                        <button class="btn btn-lg savePageBtn pull-right" data-bind="click: createUser">Save</button>
                    </div>
                </div>
            </div>
        </form>
        </div>
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<?php include_once('../jsdepends.php') ?>
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
