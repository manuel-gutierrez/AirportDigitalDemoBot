<?php namespace Models;


/**
*  HttpRequest.
*  Use:  UniRest.
*  http://unirest.io/php.html
*
*  Methods: 
*   -getRequest : Make a get call to an http. Returns Data or the error message. 
*   -processHttpError :  Return the meaning of an error. 
*/


class Wit
{
	private $url;
	private $header;
	private $configs; 
	private $params ;
	private $response; 
	private $language; 
	
	function __construct($lang)
	{

		$this->configs = include(__DIR__.'/../config.php');
		$this->url = "https://api.wit.ai/message";
	    $this->language = $lang; 

	    // Language Configuration
	    
	    //English
	    if ($this->language == "en") {
	    	$this->headers = array("Authorization" => "Bearer ".$this->configs['wit_en'], "Accept" => "application/json");
	    	$this->params = array("v"=>"20161003","q"=>"","timezone"=>"America/Los_Angeles");
	    } 

	    // Spanish 
	    if ($this->language == "es") {
	    	$this->headers = array("Authorization" => "Bearer ".$this->configs['wit_dorado_es'], "Accept" => "application/json");
	    	$this->params = array("v"=>"20161024","q"=>"","timezone"=>"America/Los_Angeles");
	    } 
	    
	}
	

	/**
	* Wit Integration classs.
	* @param  string $text  
	* @return array  $data  
	*/

	public function witCall($text)
	{
		// New request Object
		$rest = new \Unirest\Request;

		// Add text to the request  
		$this->params["q"] = $text; 

		// Do request
		$call = $rest->get($this->url,$this->headers,$this->params); 
		
		// Parse code and body to the resoult 
		$this->response["body"] = $call->body;
		$this->response["code"] = $call->code;
		
		return $this->response;
	}




	/**
	 * @param  text   $errorCode
	 * @return string $errorMeaning
	 */

	private function processHttpError($errorCode)
	{
		switch ($errorCode) {
			case 404:
				$errorMeaning = "Error: 404 - Bad url request";
				break;
			case 400:
				$errorMeaning = "Error: 400 - Bad request, please review parameters";
				break;
			case 401:
				$errorMeaning = "Error: 401 - Unauthorized Request, please review tokens and api keys";
				break;
			case 500:
				$errorMeaning = "Error: 500 - Request Server is not responding";
				break;
			
			default:
				$errorMeaning = "Uknown error: ".$errorCode;
				break;
		}
		return $errorMeaning;
	}





}