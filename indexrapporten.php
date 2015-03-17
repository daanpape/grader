<?php

$app->get('/coursesrapporten', function () use ($app) {
    $app->render('coursesrapporten.php');
});

$app->get('/homerapporten', function () use ($app) {
    $app->render('homerapporten.php');
});

?>