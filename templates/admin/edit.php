<?php
// Page initialisation
$location = "adminEdit";
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
            <?php echo '<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">' . Security::getLoggedInName() . '<b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="/account"><span class="navspan">Account</span></a></li>
                    <li><a href="/account/studentlists"><span class="navspan">Student lists</span></a></li>
                    <li><a href="/admin/home"><span class="navspan">Admin Panel</span></a></li>
                </ul>
            </li>';
            echo '<li><a href="#" data-bind="text: logoutBtn" id="logoutbtn" onClick="javascript: logoutUser();">Logout</a></li>'; ?>
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
                        <a href="/admin/home"><i class="fa fa-home fa-fw fa-lg"></i> Dashboard</a>

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
                <h1 class="page-header" id="usereditHeader" data-value="<?php echo $edituserid ?>"  data-bind="text: pageHeaderEditUser">Edit User</h1>
            </div>
        </div>

        <!-- /.col-lg-12 -->
        <div>
            <form id="userEditForm">
                <input type="hidden" name="lang" value="EN"/>


                <table class="table table-striped" data-bind="foreach: user">
                    <tr>
                        <td>Firstname</td>
                        <td><input type="text" class="form-control form-next" placeholder="Firstname" name="firstname" data-bind="value: firstname"></td>
                    </tr>
                    <tr>
                        <td>Lastname</td>
                        <td><input type="text" class="form-control form-next" placeholder="Lastname" name="lastname" data-bind="value: lastname"></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><input type="text" class="form-control form-next" placeholder="Email" name="email" data-bind="value: username">
                        </td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>
                            <select class="form-control form-next" name="status" data-bind="options: userStatuses, value: status">
                            </select>
                        </td>
                    </tr>
                    <tr>
                </table>


                <h2>User Permissions</h2>
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
                            <td>STUDENT</td>
                            <td>Can only do studentactions</td>
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
                            <td>SUPERUSER</td>
                            <td>The superuser role must have access to everything...</td>
                        </tr>
                        </tbody>
                        <tbody>
                        <tr>
                            <td>Permission</td>
                            <td><select class="form-control" id="selectedPermission" data-bind="value: selectedPermission">
                                    <option value="GUEST">Guest</option>
                                    <option value="STUDENT">Student</option>
                                    <option value="USER">User</option>
                                    <option value="SUPERUSER">Superuser</option>
                                </select>
                            </td>
                        </tr>
                        </tbody>
                </div>
            </form>

        </div>
    </div>

    <div class="container">
        <div class="row">
            <div id="bottom-col" class="col-md-12">
                <button class="btn btn-lg savePageBtn pull-right" type="submit">Save</button>
            </div>
        </div>
    </div>
    <!-- /.row -->
<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<?php
require_once('templates/footer.php');
?>