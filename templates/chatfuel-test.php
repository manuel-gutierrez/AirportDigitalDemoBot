<?php
// Register classes
require_once __DIR__ . '/../src/classes.php';


$chatfuel = new ChatfuelMessage;

// Send a Gallery message
// ----for each card ---

//create buttons
$button1 = $chatfuel->ButtonElement("web_url", "http://www.google.com", "Button 1");
$button2 = $chatfuel->ButtonElement("web_url", "http://www.google.com", "Button 2");
$buttons = array ($button1,$button2);

//create cards

$card1 = $chatfuel->CardElement("This is a Test","https://hd.unsplash.com/photo-1470897655254-05feb2d2ab97","Subtitle Text",$buttons); 
$card2 = $chatfuel->CardElement("This is a Test 2","https://hd.unsplash.com/photo-1470897655254-05feb2d2ab97","Subtitle Text 2",$buttons); 
$elements = array($card1,$card2);

// assemble message
$message = $chatfuel->GalleryMessage($elements);
// send message
header("Content-Type: application/json");
print_r(json_encode($message));


?>