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
                <h1 class="page-header" data-bind="text: pageHeaderAddUser">Add User</h1>
            </div>
        </div>

        <!-- /.col-lg-12 -->
        <div>
            <form id="userForm" class="form">
                <input type="hidden" name="skipEmailVerification" value="true">
                <div class="form-group">
                    <label class="control-label col-md-4" data-bind="text: firstName">Firstname</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control form-next" placeholder="Firstname" name="firstname">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4" data-bind="text: lastName">Lastname</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control form-next" placeholder="Lastname" name="lastname">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4" data-bind="text: email">Email</label>
                    <div class="col-md-8"><input type="text" class="form-control form-next" placeholder="Email" name="email">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4" data-bind="text: password">password</label>
                    <div class="col-md-8"><input type="password" class="form-control form-next" placeholder="Password" name="pass"
                               ></div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4" data-bind="text: confirmPassword">Confirm password</label>
                    <div class="col-md-8">
                        <input type="password" class="form-control form-next" placeholder="Confirm password" name="passconfirm">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4" data-bind="text: language">Language</label>
                    <div class="col-md-8">
                        <select class="form-control form-next" name="lang">
                            <option>EN</option>
                            <option>NL</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4" data-bind="text: userStatus">Status</label>
                    <div class="col-md-8">
                        <select class="form-control form-next" name="status">
                            <option>ACTIVE</option>
                            <option>DISABLED</option>
                        </select>
                    </div>
                </div>
                <!--
                <div class="form-group">
                    <label class="control-label col-md-4">Permission</label>
                    <div class="col-md-8">
                        <select class="form-control form-next">
                            <option>GUEST</option>
                            <option>STUDENT</option>
                            <option>USER</option>
                            <option>SUPERUSER</option>
                        </select>
                    </div>
                </div>
                -->

                <div class="row">
                    <div class="col-lg-12" style="text-align: right">
                        <br />
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

</body>