<?php
require_once __DIR__. '/Controllers/test.php';

// Routes


//_________Test Routes___________________
$app->get('/', function ($request, $response)  {
    
     $test = new test;

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
   
    } catch (Unirest\Exception $e) {
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
    
    $test = new test;
    
    try {
        
        $result = $test->locusLabsTestGetVenuesData($request->getAttribute('query'));
   
    } catch (\Unirest\Exception $e) {
    
        $response->withJson($e, 200);

    }
   
    $response->withJson($result, 200);
    
});

// MAPS 
$app->post('/map/search-poi/{query}', function ($request, $response)  {
    
    $test = new test;
    
     try {
        
       $result = $test->locusLabsTestGetVenuesData($request->getAttribute('query'));
   
    } catch (\Unirest\Exception $e) {
    
        $response->withJson($e, 200);

    }
   
   $response->withJson($result, 200);
    
});






