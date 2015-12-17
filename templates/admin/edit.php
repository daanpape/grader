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
            </li>'; ?>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-bind="html: menuLanguage">Language</a></b>
                <ul class="dropdown-menu">
                    <li><span class="navspan" onclick="setLang('en')">English</span></li>
                    <li><span class="navspan" onclick="setLang('nl')">Nederlands</span></li>
                </ul>
            </li>
        </ul>
    </nav>

    <div style="width: 90%; margin: 0 auto; margin-top: 2%">
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
                        <td data-bind="text: viewModel.firstname">Firstname</td>
                        <td><input type="text" class="form-control form-next" placeholder="Firstname" name="firstname" data-bind="value: firstname"></td>
                    </tr>
                    <tr>
                        <td data-bind="text: viewModel.lastname">Lastname</td>
                        <td><input type="text" class="form-control form-next" placeholder="Lastname" name="lastname" data-bind="value: lastname"></td>
                    </tr>
                    <tr>
                        <td data-bind="text: viewModel.email">Email</td>
                        <td><input type="text" class="form-control form-next" placeholder="Email" name="email" data-bind="value: username">
                        </td>
                    </tr>
                    <tr>
                        <td data-bind="text: viewModel.status">Status</td>
                        <td>
                            <select class="form-control form-next" name="status" data-bind="options: userStatuses, value: status">
                            </select>
                        </td>
                    </tr>
                    <tr>
                </table>


                <h2 data-bind="text: adminEditUserPermissions">User Permissions</h2>
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
                            <td data-bind="text: adminGuest">When not logged in you get the GUEST role.</td>
                        </tr>
                        </tbody>
                        <tbody>
                        <tr>
                            <td>STUDENT</td>
                            <td data-bind="text: adminStudent">Can only do studentactions</td>
                        </tr>
                        </tbody>
                        <tbody>
                        <tr>
                            <td>USER</td>
                            <td data-bind="text: adminUser">Contains rights for every USER in the system.</td>
                        </tr>
                        </tbody>
                        <tbody>
                        <tr>
                            <td>SUPERUSER</td>
                            <td data-bind="text: adminSuperuser">The superuser role must have access to everything...</td>
                        </tr>
                        </tbody>
                        <tbody>
                        <tr>
                            <td data-bind="text: adminRights">Permission</td>
                            <td><select class="form-control" id="selectedPermission" data-bind="options: availablePermissions, value: currentUserRole">
                                    <option value="GUEST">Guest</option>
                                    <option value="STUDENT">Student</option>
                                    <option value="USER">User</option>
                                    <option value="SUPERUSER">Superuser</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                            </td>
                            <td>
                                <div class="row">
                                    <div>
                                        <button class="btn btn-default savePageBtn" type="submit">
                                            <span class="glyphicon glyphicon-floppy-disk"></span>
                                            <span data-bind="text: saveBtn">Save</span>
                                        </button>

                                        <button class="btn btn-default cancelPageBtn" type="button">
                                            <span class="glyphicon glyphicon-remove-sign"></span>
                                            <span data-bind="text: cancelBtn">Cancel</span>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                </div>
            </form>
        </div>
    </div>
    <!-- /.row -->
<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<?php
require_once('templates/footer.php');
?>