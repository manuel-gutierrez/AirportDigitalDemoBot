<?php
use \Controllers\test;
// Routes


//_________Test Routes___________________
$app->get('/', function ($request, $response)  {
    $response->withJson("hola", 200);
 });


//  ---------- Wit Ai Tests -----------------
$app->get('/httpcall/{text}', function ($request, $response)  {

   
    $test = new \Controllers\test;
    try {
        $result = $test->witClasssTest($request->getAttribute('text'));
    } catch (\Unirest\Exception $e) {
        echo "Wit call fail "; 
    }
    $response->withJson($result["body"], 200);
});

//  ---------- Api Ai Tests -----------------
//test 0 = test api integration
$app->get('/nlp/test0/{text}', function ($request, $response)  {

    
    $test = new \Controllers\test;
    
    try {
        
        $result = $test->apiAiTestQuery($request->getAttribute('text'));
   
    } catch (\ApiAi\Exception $error) {
        echo $error->getMessage();
    }
    
    $response->withJson($result, 200);
});

//test 1 = test data is parsed correctly 
$app->get('/nlp/test1/{text}', function ($request, $response)  {

    
    $test = new \Controllers\test;
    
    try {
        
        $result = $test->apiAiTestParseData($request->getAttribute('text'));
   
    } catch (\ApiAi\Exception $error) {
        echo $error->getMessage();
    }
    $response->withJson($result, 200);
});

//test 2 = test if a query was understood
$app->get('/nlp/test2/{text}', function ($request, $response)  {

    
    $test = new \Controllers\test;
    
    try {
        $result = $test->apiAiTestSuccessfullQuery($request->getAttribute('text'));
   
    } catch (\ApiAi\Exception $error) {
        echo $error->getMessage();
        $response->withJson($result, 500);

    }

    $response->withJson($result, 200);
    
});

//  ---------- Locus Labs Tests -----------------
//test 0 = test search by query string 
$app->get('/map/test0/{query}', function ($request, $response)  {

    
    $test = new test;
    
    try {
        
        $result = $test->locusLabsTestSearchByQuery($request->getAttribute('query'));
   
    } catch (\Unirest\Exception $e) {
        echo $e->getMessage();
        $response->withJson($result, 500);

    }

    $response->withJson($result, 200);
    
});


//test 1 = test search by Id
$app->get('/map/test1/{id}', function ($request, $response)  {


    $test = new Controllers\test;
    
    try {
        
        $result = $test->locusLabsTestSearchById($request->getAttribute('id'));
   
    } catch (\Unirest\Exception $e) {
        echo $e->getMessage();
        $response->withJson($result, 500);

    }

    $response->withJson($result, 200);
    
});

//test 2 = test if a query search is valid 
$app->get('/map/test2/{query}', function ($request, $response)  {

    
    $test = new \Controllers\test;
    
    try {
        
        $result = $test->locusLabsTestValidQuerySearch($request->getAttribute('query'));
   
    } catch (\Unirest\Exception $e) {
        echo $e->getMessage();
        $response->withJson($result, 500);

    }

    $response->withJson($result, 200);
    
});

//test 3 = test if a query search by Id is valid 
$app->get('/map/test3/{id}', function ($request, $response)  {

    
    $test = new \Controllers\test;
    
    try {
        
        $result = $test->locusLabsTestValidSearchById($request->getAttribute('id'));
   
    } catch (\Unirest\Exception $e) {
      
        $response->withJson($e, 200);

    }

    $response->withJson($result, 200);
    
});
//test 4 = test if a search return the venues data.
$app->get('/map/test4/{query}', function ($request, $response)  {

    
    $test = new \Controllers\test;
    
    try {
        
        $result = $test->locusLabsTestGetVenuesData($request->getAttribute('query'));
   
    } catch (\Unirest\Exception $e) {

        $response->withJson($e, 200);

    }
   
    $response->withJson($result, 200);
    
});

$app->get('/debug', function ($request, $response)  {
phpinfo();
});



//_________ Endpoints Routes ____________________//

//NLP

$app->post('/map/nlp/', function ($request, $response)  {
    
    $test = new \Controllers\test;
    
    try {
        
        $result = $test->locusLabsTestGetVenuesData($request->getAttribute('query'));
   
    } catch (\Unirest\Exception $e) {
    
        $response->withJson($e, 200);

    }
   
    $response->withJson($result, 200);
    
});

// MAPS 
$app->get('/map/search-poi/{query}', function ($request, $response)  {
    
    $test = new \Controllers\test;
    $result = $test->locusLabsTestGetVenuesData($request->getAttribute('query'));
    // try {
        
       
   
    // } catch (\Unirest\Exception $e) {
    
    //     $response->withJson($e, 200);

    // }
   
   $response->withJson($result, 200);
    
});









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
