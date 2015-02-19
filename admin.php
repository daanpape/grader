<?php

// GET routes
$app->get('/admin/', function () use ($app) {
    $app->render('admin/pages/index.php');
});

$app->get('/admin/home', function () use ($app) {
    $app->render('admin/pages/index.php');
});

?>
