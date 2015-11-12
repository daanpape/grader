<?php
// Page initialisation
$location = "adminIndex";
require_once('templates/header.php');
?>
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
            <a class="navbar-brand" href="/home"><i class="fa fa-home fa-fw fa-lg"></i>Grader Home</a>
        </div>

        <ul class="nav navbar-nav navbar-right" style="margin-right: 5%">
            echo '<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">' . Security::getLoggedInName() . '<b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="/account"><span class="navspan">Account</span></a></li>
                    <li><a href="/account/studentlists"><span class="navspan">Student lists</span></a></li>
                    <li><a href="/admin/home"><span class="navspan">Admin Panel</span></a></li>
                </ul>
            </li>';
            echo '<li><a href="#" data-bind="text: logoutBtn" id="logoutbtn" onClick="javascript: logoutUser();">Logout</a></li>';
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
                        <a href="/admin/home"><i class="fa fa-home fa-fw fa-2x"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="/admin/permissions"><i class="fa fa-wrench fa-fw fa-lg"></i> Rechten</span></a>
                    </li>
                    <li>
                        <a href="/admin/users"><i class="fa fa-users fa-fw fa-lg"></i> Gebruikers</span></a>
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
                <h1 class="page-header" data-bind="text: pageHeader">Dashboard</h1>
            </div>
            <!-- /.col-lg-12 -->
            <div>
                <p>Change the permissions of an user in the Permissions-tab</p>

                <p>Change an user in the Users-tab</p>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<?php
require_once('templates/footer.php');
?>