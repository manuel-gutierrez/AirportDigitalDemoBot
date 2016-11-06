<?php 
require_once __DIR__ . '/../Models/Map.php';
require_once __DIR__ . '/../Models/FacebookTemplate.php';

/**
*  Here the map results search are parsed into facebook cards
*  Use: FacebookTemplate.php, Map.php
*/

class MapController
{
	
	/**
	* Parse Single Venue Data
	* @param  var   $query : text 
	* @return array $venues : Raw Data   
	*/
	public function searchVenues($query)
	{
	   $map = new Map(); 
	   $searchResults = $map->searchByQuery($query);	
  	   $venues = $map->getVenues($searchResults->body->data);
  	   

  	   if ($venues != null) {
  	     return $venues;
  	   } else {
  	   	 $venues["error"] = "No venues results";
  	   	 return  $venues;	
  	   }
  	   
	}
	 
	public function getElements($venues)
	{
		if (!isset($venues["error"])) {

			foreach ($venues as $key => $value) {
						$venue = $this->parseSingleVenue($value);
						$elements[$key] =  $venue;
						if ($key == 9){
							return $elements;
						}
					}
			return $elements ;
		} else
		{
			return $venues ;	
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


			$fbCard = new FacebookTemplate;
			
			$button_1_data = array(
				"type" => "web_url",
				"url" => "http://bot.airportdigital.com/maps/seattle-map.html?poi=".$venue->poiId, 
				"title" => "Go to Map"
		    );

		    $button_2_data = array(
				"type" => "web_url",
				"url" => "http://107.20.75.175/order", 
				"title" => "Order Now"
		    );

		    $button1 = $fbCard->parseButton($button_1_data,"tall");
		    $button2 = $fbCard->parseButton($button_2_data,"tall");
		    $buttons = array($button1,$button2);

		    $element = array(
				"title" => "",
				"item_url" => "",
				"image_url" => "",
				"subtitle" => "",
				"buttons" => $buttons
		    );

			if (!empty($venue->name)) {
			 if (!empty($venue->gate)) {
			 	$element["title"] = $venue->name." @ ". $venue->gate;
			 } else {
			 		$element["title"] = $venue->name;
			 }
			 
			} else
			{
			 $element["title"]= "Data Not Available";
			}	

		    if (!empty($venue->terminal) && !empty($venue->hours)) {
			 $element["subtitle"] = $venue->terminal." -- ". $venue->hours;
			} else
			{
			 $element["subtitle"]= "Hours and Gate Data Not Available";
			}

			if (!empty($venue->image)) {
			   $element["image_url"]= "https://img.locuslabs.com/poi/".$venue->image; 
			} else {
			   $element["image_url"]= "http://droidlessons.com/wp-content/themes/TechNews/images/img_not_available.jpg"; // Replace this image. 
			}
			return $element;
		}
		return $element["error"] = "Empty Venue";
	}

	public function buildTemplate($elements)
	{
		if (!isset($elements["error"])){
			$card = new FacebookTemplate; 
			$template = $card->buildCard($elements);
			return $template;
		}else
		{
			return $elements;
		}
	}
	public function search($query)
	{
		$venues = $this->searchVenues($query);
		if (!isset($venues["error"])) {
		   $elements = $this->getElements($venues);
     	   $cards = $this->buildTemplate($elements);
     	   return $cards;
		} else {
			//return error 
			return $venues; 
		}
	}
}