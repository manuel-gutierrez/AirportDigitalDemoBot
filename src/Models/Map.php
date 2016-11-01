<?php
namespace Models;
use app;

/**
*  LocusLabs Map Integration -- Seattle
*  Use: locusLabs API ,  UniRest
*  https://rest.locuslabs.com/v1/venue/sea/
*  Methods: 
*   -SearchQuery : Get results by a query string .
*   -SearchPoi: Get data of a POI .
*   -ParseSearchResults 
*/

class Map 
{
	
	private $headers;
	private $url;
	private $configs;
	private $request;
	private $venue; 
	private $venuesData; 

	/**
	* Constructor set request headers
	* @param  string $language 
	* @return string  $error  
	*/
	
	function __construct()
	{
		$this->configs = include(__DIR__.'/../config.php');
		$this->header = array(
			'Accept' => 'application/json',
			'x-api-key' => $this->configs['locus_labs'] 
			);

	}
	/**
	* Search a Poi by query string in seattle Airport
	* @param  string $query 
	* @return obj  $response  
	*/

	public function searchByQuery($query)
	{
		$this->url = "https://rest.locuslabs.com/v1/venue/sea/search/by-query-string/";
	    
	    // New request Object
		$this->request = new \Unirest\Request;

	
		//Do Request
		$this->response = $this->request->get($this->url.$query,$this->header); 
		return $this->response;

	}

	/**
	* Search a Poi by it poi id  in seattle Airport
	* @param  string $id 
	* @return obj  $response  
	*/

	public function searchById($id)
	{
		$this->url = "https://rest.locuslabs.com/v1/venue/sea/poi/by-id/";

	    // New request Object
		$this->request = new \Unirest\Request;

		//Do Request
		$this->response = $this->request->get($this->url.$id,$this->header); 
		return $this->response;

	}

	/**
	* Validate if the SearchByquery returned valid results
	* @param  obj $results
	* @return bool  
	*/

	public function validQuerySearch($results)
	{
		 if (!empty($results->body->data)) {
		 	return true;
		 } else {
		 	return false;
		 }


	}

	/**
	* Validate if the SearchID returned valid results
	* @param  obj $results
	* @return bool   
	*/

	public function validSearchById($results)
	{

	 	if (!empty($results->body->data)) {
	 		return true;
	 	} else {
	 		return false;
	 	}

	}



	/**
	* Parse Single Venue Data
	* @param  obj $venue
	* @return array $venueDat   
	*/

	public function parseSingleVenue($venue)
	{
		if (!empty($venue)) {

			if (!empty($venue->name)) { $this->venue["name"] = $venue->name;} else { $this->venue["name"]= " ";}	
			if (!empty($venue->gate)) { $this->venue["gate"] = $venue->gate;} else { $this->venue["gate"]= " ";}
			if (!empty($venue->hours)) {$this->venue["hours"]= $venue->hours;} else {$this->venue["hours"]= " ";}
			if (!empty($venue->image)) { $this->venue["terminal"]= $venue->terminal;} else {$this->venue["terminal"]= " ";}

			$this->venue["link"] = "bot.airportdigital.com/map?poi=".$venue->poiId;
			
			if (!empty($venue->image)) {
			   $this->venue["image"]= "https://img.locuslabs.com/poi/".$venue->image; 
			} else {
			 $this->venue["image"]= "http://droidlessons.com/wp-content/themes/TechNews/images/img_not_available.jpg"; // Replace this image. 
			}
		return $this->venue;
		}
		return $this->venue["error"] = "Venue Object is empty";
	}

	/**
	* Get Venue Data
	* Get the venue relevant data.
	* @param  array $id
	* @return array $venue 
	*/

	public function getVenue($id)
	{
		$raw = $this->searchById($id); 
		if ($this->validSearchById($raw)){
			$this->venue = $this->parseSingleVenue($raw->body->data);
			return $this->venue;
		}
		else
		{
			return $this->venue["error"] = "Venue info is not available";
		}
		
	}

	/**
	* Get Venues Data
	* Get an array with all the venues Id. 
	* @param  array $venuesId
	* @return array $venuesData   
	*/

	public function getVenues($venuesId)
	{
		$index = 1;
		if (!empty($venuesId))
		{
			foreach ($venuesId as $value) {
				$this->venuesData[$index] = $this->getVenue($value);
				$index++;
			}
			return $this->venuesData; 
		} 
		else 
		{
			$this->venueData["error"] = "Venues Id array is empty";
		}
	}


}