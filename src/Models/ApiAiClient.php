<?php 


class ApiAiClient
{

	private $configs; 
	private $client;
	private $queryApi;
	private $meanintg;
	private $query;
	private $meaning;
	private $sessionId;
	// Reminder Session Id : Review how to implement sessions in order to have user trazability!

	/**
	* Constructor  return error if language is not valid or empty 
	* @param  string $language 
	* @return string  $error  
	*/
	
	function __construct($language)
	{
		$this->configs = include(__DIR__.'/../config.php');
		  
		if ($language == 'es' || $language == 'en' || !empty($language) ) 
		{
			
			if ($language == 'en') {
				$this->sessionId = uniqid();
		  		$this->client = new \ApiAi\Client($this->configs["apiClientEn"]);
		  		$this->queryApi = new \ApiAi\Method\QueryApi($this->client);
		  	}
		  
		  	if ($language == 'es') {
		  		$this->sessionId = uniqid();
		  		$this->client = new \ApiAi\Client($this->configs["apiClientEs"]);
		  		$this->queryApi = new \ApiAi\Method\QueryApi($this->client);
		 	}
		}
		else
		{
			$error = "Language is not valid or empty"; 
			return $error;
		}	
	}

	/**
	* Api Ai integration. 
	* This method do a query call to api.ai it returns the raw results into an Array.  
	* @param  string $language 
	* @return string  $error  
	*/
	
	public function doQuery($query)
	{
		
		try {
		    
		    $this->query = $this->client->get('query', [
		        'query' => $query,
		        'sessionId' => $this->sessionId,
		        'lang' => 'es',
		    ]);

		    $this->response = json_decode((string) $this->query->getBody(), true);
		    return $this->response;

		} catch (\Exception $error) {
		    echo $error->getMessage();
		}

	}


	/**
	* Return an array with relevant data from a result
	* @param  array $aiResponse 
	* @return array  $data
	*/
	public function getImportantData($aiResponse)
	{
		$data = array (
			"processedQuery" => $aiResponse["result"]["resolvedQuery"],
			"parameters" => $aiResponse["result"]["parameters"],
			"contexts" => $aiResponse["result"]["contexts"],
			"action" => $aiResponse["result"]["action"],
			"confidence" => $aiResponse["result"]["score"],
			"statusCode" => $aiResponse["status"]["code"]
			);
		return $data;
	}

	/**
	* Condition for a succesfull intent 
	* Action !="input.unknown"
	* Confidence > 0.9  
	* Params !empty
	* @param  array $aiResponse 
	* @return bool  $sucess
	*/

	public function intentSuccessfull($aiResponse)
	{
			$action = $this->getAction($aiResponse); 
			$confidence = $this->getConfidence($aiResponse);
			$params= $this->getParameters($aiResponse);
			$emptyParams = $this->paramsAreEmpty($params);
			if ($action != "input.unknown" && $confidence > "0.7"  ) {
				return $sucess = true;
			}  else {
				return $sucess = false;
			}
	}
	/**
	* Check if any of the values of the returned params array are notempty
	* @param  array $params 
	* @return bool  $empty
	*/
	public function paramsAreEmpty($params)
	{
			foreach ($params as $key => $value) {
				if (empty($value))
				{
					return $empty = true;
				}
			}
			return $empty = false;
	}
	/**
	* Return the intent registered in Api.ai
	* @param  array $aiResponse 
	* @return string  $intent
	*/
	public function getIntent($aiResponse)
	{
		$intent = $aiResponse["metadata"]["intentName"];
		return $intent;
	}

	/**
	* Return the text processed by Api.ai
	* @param  array $aiResponse 
	* @return string  $queryText
	*/
	public function getProcessedQuery($aiResponse)
	{
		$queryText = $aiResponse["result"]["resolvedQuery"];
		return $queryText;
	}
	/**
	* Return the resultant intent entities
	* @param  array $aiResponse 
	* @return array  $entities
	*/
	public function getParameters($aiResponse)
	{
		$entities = $aiResponse["result"]["parameters"];
		return $entities;
	}

	/**
	* Return the resultant intent contexts
	* @param  array $aiResponse 
	* @return array  $contexts
	*/
	public function getContexts($aiResponse)
	{
		$contexts = $aiResponse["result"]["contexts"];
		return $contexts;
	}

	/**
	* Return the resultant confidence level of the intent.
	* @param  array $aiResponse 
	* @return string  $confidence
	*/
	public function getConfidence($aiResponse)
	{
		$confidence = $aiResponse["result"]["score"];
		return $confidence;
	}

	/**
	* Return the resultant action of the intent.
	* @param  array $aiResponse 
	* @return string  $action
	*/
	public function getAction($aiResponse)
	{
		$action = $aiResponse["result"]["action"];
		return $action;
	}
	/**
	* Return the resultant code of the call.
	* @param  array $aiResponse 
	* @return string  $code
	*/
	public function getStatusCode($aiResponse)
	{
		$code = $aiResponse["status"]["code"];
		return $code;
	}


	
}
