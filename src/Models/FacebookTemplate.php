<?php
/**
*  Facebook Cards Template Integration 
*  Use: https://developers.facebook.com/docs/messenger-platform/send-api-reference/
*  Methods: 
*   -genericTemplateSkeleton : Build the generic template skeleton.
*   -card : return the structure of a single card
*   -cardSet: return the structure of a set of cards
*   -cardElementParsing : Build a single "element" array
*   -cardElemntNesting: Nest all the elements on a single element array.
*/

/**
* 
*/
class FacebookTemplate 
{
	private $message; 
	private $element;
	private $button;
	private $buttons;
	private $skeleton;

	/**
	* Build Facebook Generic template Skeleton
	* @return array $skeleton   
	*/
	public function genericTemplateSkeleton()
	{
		$this->skeleton = array(
			"attachment" => array(
				"type" => "template",
				"payload" => array(
					"template_type" => "generic",
					"elements" => array()
				)
			)
		);
		return $this->skeleton;
	}

	/**
	* parse an element
	* @return array $element   
	*/
	
	public function parseElement($params)
	{
		$this->element = array(
			"title" => $params["title"],
			"item_url" => $params["item_url"], 
			"image_url" => $params["image_url"], 
			"subtitle" => $params["subtitle"], 
			"buttons" => $params["buttons"],
		);
		return $this->element;
	}

	/**
	* parse button array;
	* @return array $element   
	*/
	
	public function parseButton($params, $webview_height_ratio = false)
	{
		$this->button = array(
			"type" => $params["type"],
			"url" => $params["url"], 
			"title" => $params["title"],
			"messenger_extensions"=> true
		);

		if ($webview_height_ratio) {
			$this->button["webview_height_ratio"] = $webview_height_ratio;
		}
		return $this->button;
	}

	/**
	* Parse Data into the card! 
	* @return array $message   
	*/

	public function buildCard($elements)
	{
	  // create card		
	  $this->message = $this->genericTemplateSkeleton();
	  $this->message["attachment"]["payload"]["elements"] = $elements;
	  return $this->message;
    }
   }