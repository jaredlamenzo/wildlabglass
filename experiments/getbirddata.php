<!DOCTYPE html>
<html>

<?php
	$url="http://www.thewildlab.org/sighting/feeds/";

    $json = file_get_contents($url);
	
	// see http://php.net/manual/en/function.json-decode.php
    //$data = json_decode($json, TRUE);
	//var_dump($data["sighting_list"][0]["sighting_id"]);

	
	$data = json_decode($json, TRUE);
	
	echo("Content grabbed from " . $url . ":");
	echo("<br/>");
	echo("<br/>");
	echo("username: " . $data["sighting_list"][0]["username"]);
	echo("<br/>");
	echo("sighting_time: " . $data["sighting_list"][0]["sighting_time"]);
	echo("<br/>");
	echo("species_name: " . $data["sighting_list"][0]["species_name"]);
	echo("<br/>");
	echo("location: " . $data["sighting_list"][0]["location"]);
	echo("<br/>");
	echo "image:";
	echo "<br/>";
	echo("<img src='http://static.thewildlab.org/statics/images/species/" . $data["sighting_list"][0]["folder"] . "/mt.jpg'>") ;

	
	// {
   // "sighting_list":[
      // {
         // "sighting_id":"35233",
         // "category_id":"1",
         // "user_id":"3279",
         // "hotspot_id":"7419",
         // "point_id":"36391",
         // "event_id":null,
         // "protocol_id":"1",
         // "deviceid":"96f36ef0bf3ff6d3daa598d08e9e6a3544c3f980",
         // "observer_amount":"1",
         // "species_id":"243",
         // "number_sighted":"1",
         // "sighting_picture":"",
         // "sighting_time":"2013-11-15 11:50:32",
         // "sighting_unix_timestamp":"1384545032",
         // "all_reported":"1",
         // "habitat_id":"0",
         // "note":"",
         // "created_at":"2013-11-15 09:50:31",
         // "modified_at":null,
         // "status":"0",
         // "start_time":"0000-00-00 00:00:00",
         // "start_unix_stamp":"0",
         // "end_time":"0000-00-00 00:00:00",
         // "end_unix_stamp":"0",
         // "male_number":"0",
         // "female_number":"0",
         // "weather":"0",
         // "day_moment":"0",
         // "observers":"0",
         // "wave_height":"0",
         // "waterbody":"0",
         // "event_hotspot_id":null,
         // "protocol_name":"Casual",
         // "species_name":"Snowy Egret",
         // "folder":"Snowy_Egret",
         // "event_name":null,
         // "event_type_id":null,
         // "habitat_name":"Unknown",
         // "username":"Gillybird",
         // "first_name":"Jennifer",
         // "last_name":"Miller",
         // "hotspot_name":null,
         // "latitude":"30.30655700",
         // "longitude":"-89.82471500",
         // "location":"150-154 Northshore Boulevard, Slidell, LA 70460, USA",
         // "city":"Slidell",
         // "state":"LA",
         // "country":"US",
         // "postcode":"70460"
      // },
?>
</html>