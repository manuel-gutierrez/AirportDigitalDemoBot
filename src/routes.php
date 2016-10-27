<?php
// Routes
/// ----------------- Booking Search -----------------------------//
//return flight search
$app->get('/book-return/{origin}/{destination}/{departure_date}/{return_date}/{adults}/{currency}/{airline}/{limit}/{name}/{last_name}/', function ($request, $response, $args) {
    // Log Query
    $this->logger->info("Slim-Skeleton '/flight/{origin}'route");
    // Pass the query string to the "controler variable"

   return $this->renderer->render($response, 'book-return.php', $args);
});
//return flight search
$app->get('/book-return/es/{origin}/{destination}/{departure_date}/{return_date}/{adults}/{currency}/{airline}/{limit}/{name}/{last_name}/', function ($request, $response, $args) {
    // Log Query
    $this->logger->info("Slim-Skeleton '/flight/{origin}'route");
    // Pass the query string to the "controler variable"

   return $this->renderer->render($response, 'book-return-es.php', $args);
});

// One way flight search
$app->get('/book-single/{origin}/{destination}/{departure_date}/{adults}/{currency}/{airline}/{limit}/{name}/{last_name}/', function ($request, $response, $args) {
    // Log Query
    $this->logger->info("Slim-Skeleton '/flight/{origin}'route");
    // Pass the query string to the "controler variable"

   return $this->renderer->render($response, 'book-single.php', $args);
});
// One way flight search Sapanish
$app->get('/book-single/es/{origin}/{destination}/{departure_date}/{adults}/{currency}/{airline}/{limit}/{name}/{last_name}/', function ($request, $response, $args) {
    // Log Query
    $this->logger->info("Slim-Skeleton '/flight/{origin}'route");
    // Pass the query string to the "controler variable"

   return $this->renderer->render($response, 'book-single-es.php', $args);
});

/// ----------------- Checkout Page -----------------------------//

//Checkout Page 
$app->get('/check-out/{name}/{last_name}/', function ($request, $response, $args) {
    // Log Query
    $this->logger->info("Slim-Skeleton '/flight/{origin}'route");
    // Pass the query string to the "controler variable"

   return $this->renderer->render($response, 'checkout.php', $args);
});

//Review Details 
$app->get('/review-purchase', function ($request, $response, $args) {
    // Log Query
    $this->logger->info("Slim-Skeleton '/flight/{origin}'route");
    // Pass the query string to the "controler variable"

   return $this->renderer->render($response, 'review-purchase.php', $args);
});
//Review Details 
$app->get('/confirmation', function ($request, $response, $args) {
    // Log Query
    $this->logger->info("Slim-Skeleton '/flight/{origin}'route");
    // Pass the query string to the "controler variable"

   return $this->renderer->render($response, 'confirmation.php', $args);
});

/// --------------------- Maps  -----------------------------//

//Maps Page
$app->get('/map/test', function ($request, $response, $args) {
    // Log Query
    // $this->logger->info("Slim-Skeleton '/flight/{origin}'route");
    // Pass the query string to the "controler variable"
    $args = $request->getQueryParams();
    return $this->renderer->render($response, 'seattle-map.phtml', $args);
});

// search points 
$app->get('/map/search/{query}/', function ($request, $response, $args) {
    // Log Query
    $this->logger->info("Slim-Skeleton '/flight/{origin}'route");
    // Pass the query string to the "controler variable"
    return $this->renderer->render($response, 'search-in-map.php', $args);
});

// navigation
$app->get('/map', function ($request, $response, $args) {
    // Log Query
    $args = $request->getQueryParams();
    
    if (isset($args['poi'])) {
       return $this->renderer->render($response, 'seattle-map.phtml', $args);
    }else{
        return $this->renderer->render($response, 'seattle-navigation.html', $args);
    }
    
});

/// ----------------- Flight Status  -----------------------------//

// Flight status end point 
$app->get('/flight-status/{type}/{flight_number}/', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    return $this->renderer->render($response, 'flight-status.php', $args);
});
$app->get('/flight-status/es/{type}/{flight_number}/', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    return $this->renderer->render($response, 'flight-status-es.php', $args);
});


/// ----------------------- Tests  -----------------------------//


$app->get('/test', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");
   
   // Pass the query string to the "controler variable"
   return $this->renderer->render($response, 'test.php', $args);
});

$app->post('/nlp', function ($request, $response, $args) {
 // pass
 $args = $request->getParsedBody();
 return $this->renderer->render($response, 'nlp.php', $args);
});
