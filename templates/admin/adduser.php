<?php
// Page initialisation
$location = "adminAddUser";
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
                        <a href="/admin/home"><i class="fa fa-home fa-fw fa-lg"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="/admin/permissions"><i class="fa fa-wrench fa-fw fa-lg"></i> Rechten</span></a>
                    </li>
                    <li>
                        <a href="/admin/users"><i class="fa fa-users fa-fw fa-2x"></i> Gebruikers</span></a>
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
            <form id="userForm">
            <input type="hidden" name="lang" value="EN"/>
            <table class="table table-striped">
                <tr>
                    <td>Firstname</td>
                    <td><input type="text" class="form-control form-next" placeholder="Firstname" name="firstname"
                               ></td>
                </tr>
                <tr>
                    <td>Lastname</td>
                    <td><input type="text" class="form-control form-next" placeholder="Lastname" name="lastname"
                               ></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input type="text" class="form-control form-next" placeholder="Email" name="email">
                    </td>
                </tr>
                <tr>
                    <td>password</td>
                    <td><input type="password" class="form-control form-next" placeholder="Password" name="pass"
                               ></td>
                </tr>
                <tr>
                    <td>Confirm password</td>
                    <td><input type="password" class="form-control form-next" placeholder="Confirm password" name="passconfirm"
                               ></td>
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
                        <button class="btn btn-lg savePageBtn pull-right" type="submit">Save</button>
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

<?php
require_once('templates/footer.php');
?>