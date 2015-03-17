<?php

$app->get('/coursesrapporten', function () use ($app) {
    $app->render('templatesrapport/coursesrapporten.php');
});

$app->get('/homerapporten', function () use ($app) {
    $app->render('templatesrapport/homerapporten.php');
});

$app->get('/assessrapporten', function () use ($app) {
    $app->render('templatesrapport/assessrapporten.php');
});

?>