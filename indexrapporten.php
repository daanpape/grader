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

/* API get routes */

$app->get('/api/projects/page/:pagenr', function ($pagenr) use ($app) {
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    // Calculate start and count
    $pg = Pager::pageToStartStop($pagenr);

    // Get total number of projecttypes in the database
    $pagedata = GraderAPI::getProjectByCourseId($courseid, $pg->start, $pg->count);
    $totalprojects = GraderAPI::getProjectCountByCourseId($courseid);

    // Get the page
    echo json_encode(Pager::genPaginatedAnswer($pagenr, $pagedata, $totalprojects));
});

?>