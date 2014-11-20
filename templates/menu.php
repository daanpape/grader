<?php
    require_once 'dptcms/security.php';
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
                <li<?php
                if ($location == 'projects') {
                    echo 'active';
                }
                ?>">
                    <a href="/projects" data-bind="text: projecttypeBtn">Projects</a>
                </li>
            </ul>
            </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <?php
                    if(Security::isUserLoggedIn()){
                        echo '<li><a href="/account">'.Security::getLoggedInName().'</a></li>';
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

    <!-- General modal -->
    <div id="general_modal" class="modal_box extrapadding">
        <div class="modal_title" id="general_modal_title"></div>
        <div id="general_modal_body"></div>
        <div class="form-inline rightbtns" id="general_modal_buttons">
        </div>
    </div>
</div>