<?php
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
	* Get Venue Data
	* Get the venue relevant data.
	* @param  array $id
	* @return array $venue 
	*/

	public function getVenue($id)
	{
		$raw = $this->searchById($id); 
		if ($this->validSearchById($raw)){
			$this->venue = $raw->body->data; 
			return  $this->venue;
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
		$index = 0;
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