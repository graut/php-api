<?php

# Enter your agile api key and sub domain name
define("apikey","your_agile_api_key");
define("domain","your_agile_subdomain");    # Example : define("domain","jim");

/**
* Fuction to make an HTTP call using curl
*
* @param String $subject	Entity to perform action on
* @param String $json		JSON data to send on HTTP call
* @param String $action		The HTTP method to use
* @return String
*/
function curlWrap ($subject, $json, $action)
{
	$ch = curl_init();
	curl_setopt_array($ch, array(
	CURLOPT_FOLLOWLOCATION=>true,
	CURLOPT_MAXREDIRS=>10,
	));
switch($action)
{
case "POST":
curl_setopt($ch,CURLOPT_URL,'https://'.domain.'.agilecrm.com/core/php/api/'.$subject.'?id='.apikey);
curl_setopt($ch,CURLOPT_CUSTOMREQUEST,"POST");
curl_setopt($ch,CURLOPT_POSTFIELDS,$json);
break;
case "GET":
$json = json_decode($json);
curl_setopt($ch,CURLOPT_CUSTOMREQUEST,"GET");
curl_setopt($ch,CURLOPT_URL,'https://'.domain.'.agilecrm.com/core/php/api/'.$subject.'?id='.apikey.'&email='.$json->{'email'});
break;
case "PUT":
curl_setopt($ch,CURLOPT_URL,'https://'.domain.'.agilecrm.com/core/php/api/'.$subject.'?id='.apikey);
curl_setopt($ch,CURLOPT_CUSTOMREQUEST,"PUT");
curl_setopt($ch,CURLOPT_POSTFIELDS,$json);
break;
case "DELETE":
$json = json_decode($json);
curl_setopt($ch,CURLOPT_URL,'https://'.domain.'.agilecrm.com/core/php/api/'.$subject.'?id='.apikey.'&email='.$json->{'email'});
curl_setopt($ch,CURLOPT_CUSTOMREQUEST,"DELETE");
break;
default:
break;
}
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	curl_setopt_array($ch, array(
	CURLOPT_RETURNTRANSFER=>true,
	CURLOPT_TIMEOUT=>120
	));
	$output= curl_exec($ch);
	curl_close($ch);
	return $output;
}

# To add contact
$contact_json = '{"email":"contact@test.com", "first_name":"test", "last_name":"contact", "tags":"tag1, tag2"}';
curlWrap("contact", $contact_json, "POST");

# To update contact
$contact_json = '{"email":"contact@test.com", "website":"http://example.com", "company":"ABC Corp"}';
curlWrap("contact", $contact_json, "PUT");

# To delete contact
$json = '{"email":"contact@test.com"}';
curlWrap("contact", $json, "DELETE");

# To get contact details
$json = '{"email":"contact@test.com"}';
curlWrap("contact", $json, "GET");

# To add note
$note_json = '{"email":"contact@test.com", "subject":"test", "description":"note"}';
curlWrap("note", $note_json, "POST");

# To get notes related to contact
$json = '{"email":"contact@test.com"}';
curlWrap("note", $json, "GET");

# To add score to contact
$score_json = '{"email":"contact@test.com", "score":"50"}';
curlWrap("score", $score_json, "PUT");

# To subtract score
$subscore_json = '{"email":"contact@test.com", "score":"-20"}';
curlWrap("score", $subscore_json, "PUT");

# To get current score of contact
$json = '{"email":"contact@test.com"}';
curlWrap("score", $json, "GET");

# To add task
$task_json = '{"type":"MEETING", "priority_type":"HIGH", "subject":"test", "email":"contact@test.com"}';
curlWrap("task", $task_json, "POST");

# To get tasks related to a contact
$json = '{"email":"contact@test.com"}';
curlWrap("task", $json, "GET");

# To add a deal to contact 
$deal_json = '{"name":"Test Deal", "description":"testing deal", "expected_value":"100", "milestone":"won",
	       "probability":"5", "close_date":"1376047332", "email":"contact@test.com"}';
	       			 # close date in epoch time
curlWrap("deal", $deal_json, "POST");

# To get deals associated with contact
$json = '{"email":"contact@test.com"}';
curlWrap("deal", $json, "GET");

# To add tags
$tag_json = '{"email":"contact@test.com", "tags":"tag1, tag2, tag3, tag4, tag5"}';
curlWrap("tags", $tag_json, "POST");
		   
# To delete tags
$rm_tags_json = '{"tags":"tag3, tag4", "email":"contact@test.com"}';
curlWrap("tags", $rm_tags_json, "PUT");

# To get tags assigned to a contact
$json = '{"email":"contact@test.com"}';
curlWrap("tags", $json, "GET");
?>