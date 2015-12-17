<?php
// Page initialisation
$location = "adminIndex";
require_once('templates/header.php');
?>
<body style="padding-top: 0px">
<?php

    require_once("templates/menu.php")
?>
<div id="wrapper">
    <div style="width: 90%; margin: 0 auto; margin-top: 2%">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div>
                        <a href="/admin/users/add" type="button" class="btn btn-default pull-right" id="addUser">
                            <span class="glyphicon glyphicon-plus"></span> <span data-bind="text: addBtn"></span>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.col-lg-12 -->
            <div>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th data-bind="text: userName">Username</th>
                        <th data-bind="text: firstName">Name</th>
                        <th data-bind="text: lastName">Lastname</th>
                        <th data-bind="text: userPermissions">Permissions</th>
                        <th data-bind="text: userStatus">Status</th>
                        <th data-bind="text: userActions">Actions</th>
                    </tr>
                    </thead>
                    <tbody data-bind="foreach: users">
                    <tr style="width: 100%">
                        <td data-bind="text: username"></td>
                        <td data-bind="text: firstname"></td>
                        <td data-bind="text: lastname"></td>
                        <td data-bind="text: permissions"></td>
                        <td data-bind="text: status"></td>
                        <!-- ko if: status() === 'ACTIVE' -->
                        <td style="width: 15%" data-bind="if:status"><a style="cursor:pointer"><i class="fa fa-toggle-on fa-lg" data-bind="click: changeStatus"></i></a>
                            <a  data-bind="attr:{'href': '/admin/edit/' + id()}" style="cursor:pointer"><i class="fa fa-wrench fa-lg"></i></a>
                            <a style="cursor:pointer"><i class="fa fa-times fa-lg" data-bind="click: removeThisUser"></i></a><a style="cursor:pointer">
                        </td>
                        <!-- /ko -->
                        <!-- ko if: status() !== 'ACTIVE' -->
                        <td style="width: 15%" data-bind="if:status"><a style="cursor:pointer"><i class="fa fa-toggle-off fa-lg" data-bind="click: changeStatus"></i></a>
                            <a  data-bind="attr:{'href': '/admin/edit/' + id()}" style="cursor:pointer"><i class="fa fa-wrench fa-lg"></i></a>
                            <a style="cursor:pointer"><i class="fa fa-times fa-lg" data-bind="click: removeThisUser"></i></a><a style="cursor:pointer">
                        </td>
                        <!-- /ko -->

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