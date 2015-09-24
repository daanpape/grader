<?php
// Page initialisation
$location = "adminUsers";
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
                        <a href="/admin/permissions"><i class="fa fa-wrench fa-fw fa-lg"></i> Rechten</a>
                    </li>
                    <li>
                        <a href="/admin/users"><i class="fa fa-users fa-fw fa-2x"></i> Gebruikers</a>
                    </li>
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-11">
                <h1 class="page-header" data-bind="text: pageHeader">Gebruikers</h1>
            </div>
            <div class="col-lg-1">
                <a href="/admin/users/add" type="button" class="btn btn-default pagination-button" id="addUser">
                    <span class="glyphicon glyphicon-plus"></span> <span data-bind="text: addBtn"></span>
                </a>
            </div>
        </div>



        <div>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th data-bind="text: userName">Username</th>
                    <th data-bind="text: firstName">Name</th>
                    <th data-bind="text: lastName">Lastname</th>
                    <th data-bind="text: userStatus">Status</th>
                    <th data-bind="text: userActions">Actions</th>
                </tr>
                </thead>
                <tbody data-bind="foreach: users">
                    <tr style="width: 100%">
                        <td data-bind="text: username"></td>
                        <td data-bind="text: firstname"></td>
                        <td data-bind="text: lastname"></td>
                        <td data-bind="text: status"></td>
                        <!-- ko if: status() === 'ACTIVE' -->
                        <td style="width: 15%" data-bind="if:status"><a style="cursor:pointer"><i class="fa fa-toggle-on fa-lg" data-bind="click: changeStatus"></i></a>
                            <a style="cursor:pointer"><i class="fa fa-times fa-lg" data-bind="click: removeThisUser"></i></a><a style="cursor:pointer">
                                <a data-bind="attr:{'href': '/api/adminUsersCourse/'}"><span class="fa fa-archive fa-lg" data-bind=""></span></a></td>
                        <!-- /ko -->
                        <!-- ko if: status() !== 'ACTIVE' -->
                        <td style="width: 15%" data-bind="if:status"><a style="cursor:pointer"><i class="fa fa-toggle-off fa-lg" data-bind="click: changeStatus"></i></a>
                            <a style="cursor:pointer"><i class="fa fa-times fa-lg" data-bind="click: removeThisUser"></i></a><a style="cursor:pointer">
                                <a data-bind="attr:{'href': '/api/adminUsersCourse/'}"><span class="fa fa-archive fa-lg" data-bind=""></span></a></td>
                        <!-- /ko -->

                    </tr>
                </tbody>
        </div>

        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<?php
require_once('templates/footer.php');
?>