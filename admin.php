<?php

// GET routes
$app->get('/admin/', function () use ($app) {
    $app->render('admin/index.php');
});

$app->get('/admin/home', function () use ($app) {
    $app->render('admin/index.php');
});

$app->get('/admin/users/add', function () use ($app) {
    $app->render('admin/adduser.php');
});

$app->get('/admin/edit/:id', function ($id) use($app) {
    $app->render('admin/edit.php', array('edituserid' => $id));
});

?>
