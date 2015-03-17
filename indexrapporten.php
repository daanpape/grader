<?php

$app->get('/coursesrapporten', function () use ($app) {
    $app->render('templates/templatesrapport/coursesrapporten.php');
});

$app->get('/homerapporten', function () use ($app) {
    $app->render('templatesrapport/homerapporten.php');
});

?>