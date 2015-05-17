<?php
// Page initialisation
$location = "adminPermissions";
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
                    <li>
                        <a href="/admin/home"><i class="fa fa-home fa-fw fa-lg"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="/admin/permissions"><i class="fa fa-wrench fa-fw fa-2x"></i> Rechten</span></a>
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
                <h1 class="page-header" data-bind="text: pageHeader">Rechten</h1>
            </div>
        </div>
        <div>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th data-bind="text: permissionRole">Role</th>
                    <th data-bind="text: permissionDescription">Description</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>GUEST</td>
                    <td>When not logged in you get the GUEST role.</td>
                </tr>
                </tbody>
                <tbody>
                <tr>
                    <td>SUPERUSER</td>
                    <td>The superuser role must have access to everything...</td>
                </tr>
                </tbody>
                <tbody>
                <tr>
                    <td>USER</td>
                    <td>Contains rights for every USER in the system.</td>
                </tr>
                </tbody>
                <tbody>
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
                <tbody data-bind="foreach: usersPermissions">
                <tr style="width: 100%">
                    <td style="width: 30%" data-bind="text: username"></td>
                    <td style="width: 15%" data-bind="text: firstname"></td>
                    <td style="width: 15%" data-bind="text: lastname"></td>
                    <td style="width: 25%" data-bind="text: permissions"></td>
                    <td style="width: 15%"><a  data-bind="attr:{'href': '/admin/permissions/edit/' + id()}" style="cursor:pointer"><i class="fa fa-wrench fa-lg"></i></a></td>
                </tr>
                </tbody>
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