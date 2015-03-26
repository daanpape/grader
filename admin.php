<?php

// GET routes

$app->get('/account/admin', function() use ($app) {
    $app->render('/admin/index.php');
});

$app->get('/account/admin/', function () use ($app) {
    $app->render('/admin/index.php');
});

$app->get('/account/admin/home', function () use ($app) {
    $app->render('/admin/index.php');
});

?>
