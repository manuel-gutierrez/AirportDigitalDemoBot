<?php 
require_once __DIR__ . '/../Models/ApiAiClient.php';

/**
*  Here a call to a nlp endpoint is made and processed. It returns the intent result s. 
*  Use: Api Ai.
*  https://rest.locuslabs.com/v1/venue/sea/
*/

class Nlp
{
	private $nlp; // nlp object

	function __construct($language)
	{
		$this->nlp = new ApiAiClient($language);
	}

	/**
	* Gets the query input returns the intent relevant data; 
	* @param  string $query 
	* @return array  $data  
	*/

	public function doQuery($query)
	{
		$queryResult = $client->doQuery($query);
		$data = $this->nlp->getImportantData($queryResult);
		return $data;
	}

	/**
	* Flow Xo routing (Map)
	* @param  array  $intentAction;
	* @return string $flowName  
	*/
	public function routeToAFlow($intentAction)
	{
		switch ($intentAction) {
			case 'find_place_description':
				$flowName = "SearchAPlace";
				break;

			case 'book_a_flight':
				$flowName = "BookAFlight";
				break;
			case 'lng_spanish':
				$flowName = "ChangeLanguage";
				break;
			case 'lng_english':
				$flowName = "ChangeLanguage";
				break;
			case 'flight_status':
				$flowName = "FlightStatus";
				break;
			case 'salute':
				$flowName = "Salute";
				break;
			case 'saludo':
				$flowName = "Saludo";
				break;
			
			default:
				$flowName = "UnknownIntent";
				break;
		}
		return $flowName;
	}

	/**
	* Process  Query
	* @param  string  $query
	* @return array   $data [$flowName,$data]  
	*/
	public function processQuery($query)
	{
		$queryResult = $this->nlp->doQuery($query);
		$querySuccesfull = $this->nlp->intentSuccessfull($queryResult); 
		
		if ($querySuccesfull){
			$flow = $this->routeToAFlow($this->nlp->getAction($queryResult));
			$parsedResult = $this->nlp->getImportantData($queryResult);
			$data=array("flow"=>$flow, "data" => $parsedResult );
			return $data; 
		} else 
		{
			$flow = "UnknownIntent";
			$parsedResult = $this->nlp->getImportantData($queryResult);
			$data=array("flow"=>$flow, "data" => $parsedResult);
			return $data; 
		}

	}

}