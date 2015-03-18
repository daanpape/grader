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

$app->get('/rapportapi/projects/page/:pagenr', function ($pagenr) use ($app) {
    ?>
        <script>console.log('im in the api')</script>
    <?php
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    // Calculate start and count
    $pg = Pager::pageToStartStop($pagenr);

    // Get total number of projecttypes in the database
    $pagedata = RapportAPI::getAllCourses($pg->start, $pg->count);

    // Get the page
    echo json_encode(Pager::genPaginatedAnswer($pagenr, $pagedata));
});

$app->post('/rapportapi/project/', function () use ($app) {
    ?><script>console.log('im in indexrapporten')</script> <?php
    // Use json headers
    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    // Insert the data
    echo json_encode(RapportAPI::createCourse($app->request->post('code'), $app->request->post('name'), $app->request->post('description')));
});

?>