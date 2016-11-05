<?php 
require_once __DIR__ . '/../Models/ApiAiClient.php';
require_once __DIR__ . '/../Models/Map.php';
require_once __DIR__ . '/../Models/FacebookTemplate.php';
require_once __DIR__ . '/../Controllers/Nlp.php';
require_once __DIR__ . '/../Controllers/MapController.php';



/**
* Desc: test classes
* @return $response
*/

if (!class_exists('test')) {
  class test
  {
      public function witClasssTest($text) 
  	{	
  	 $wit = new Wit("en"); 
  	 $response = $wit->witCall($text); 
  	 return $response;
  		
  	}

  	// Api Api Ai Tests
  	 public function apiAiTestQuery($text) 
  	{	
  	 $apiClient = new ApiAiClient("en"); 
  	 $response = $apiClient->doQuery($text); 
  	 return $response;
  	}
  	 public function apiAiTestParseData($text) 
  	{	
  	 $apiClient = new ApiAiClient("es"); 
  	 $aiResponse = $apiClient->doQuery($text); 
  	 $response = $apiClient->getImportantData($aiResponse);
  	 return $response;
  	}

  	 public function apiAiTestSuccessfullQuery($text) 
  	{	
  	 $apiClient = new ApiAiClient("es"); 
  	 $aiResponse = $apiClient->doQuery($text); 
  	 $response ["result"] = $apiClient->intentSuccessfull($aiResponse);
  	 $response ["params"] = $apiClient->getParameters($aiResponse);
  	 $response ["action"] = $apiClient->getAction($aiResponse);
  	 $response ["confidence"] =  $apiClient->getConfidence($aiResponse);	
  	 return $response;
  	}

    public function apiAiTestWithLanguage($query,$language) 
    { 
     $apiClient = new ApiAiClient($language); 
     $response = $apiClient->doQuery($query);
     return $response;
    }
    public function nlpTestProcessQuery($query, $lng)
    {
      $nlp = new Nlp($lng);
      $result = $nlp->processQuery($query);
      return $result;  
    }

  	// Locus Labs Tests
  	 public function locusLabsTestSearchByQuery($query) 
  	{	
  	 $map = new Map(); 
  	 $response = $map->searchByQuery($query);	
  	 return $response;
  	}
  	 public function locusLabsTestSearchById($id) 
  	{	
  	 $map = new Map(); 
  	 $response = $map->searchById($id);	
  	 return $response;
  	}

  	 public function locusLabsTestValidQuerySearch($query) 
  	{	
  	 $map = new Map(); 
  	 $result = $map->searchByQuery($query);	
  	 $response = $map->validQuerySearch($result);
  	 return $response;
  	}

       public function locusLabsTestValidSearchById($id) 
  	{	
  	 $map = new Map(); 
  	 $result = $map->searchByQuery($id);	
  	 $response = $map->validSearchById($result);
  	 return $response;
  	}


      public function locusLabsTestGetVenuesData($query) 
  	{	
  	 $map = new MapController;
     $venues = $map->searchVenues($query);
  	 return $venues;
  	}

    // Facebook Templates test 

     public function facebookTemplateTestcard() 
    { 
     $card = new FacebookTemplate; 
     $result = $card->card();
     return $result;
    }

    public function facebookTemplateTestElements($query) 
    { 
     $map = new MapController;
     $venues = $map->searchVenues($query);
     $elements = $map->getElements($venues);
     return $elements;
    }
    public function facebookTemplateTestVenueCard($query) 
    { 
     $map = new MapController;
     $venues = $map->searchVenues($query);
     $elements = $map->getElements($venues);
     $card = $map->buildTemplate($elements);
     return $card;
    }

  }


}
