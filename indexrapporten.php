<?php

$app->get('/coursesrapporten', function () use ($app) {
    $app->render('templates/templatesrapport/courses.php');
});

$app->get('/homerapporten', function () use ($app) {
    $app->render('templates/templatesrapport/home.php');
});

?>