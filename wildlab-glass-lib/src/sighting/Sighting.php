<?php

class Sighting {
	var $username;
	var $sightingtime;
	var $species_name;
	var $location;
	var $number_sighted;

	var $city;
	var $state;

	var $folder;

	var $image_url;

	var $latitude;
	var $longitude;

	var $habitat_name;
	var $note;

	// internal
	var $sourceArr;

	public function Sighting($inArr) {
		// store it just in case
		$this -> sourceArr = $inArr;

		// assign properties that we want to use
		$this -> username = $this -> sourceArr["username"];
		$this -> sightingtime = $this -> sourceArr["sighting_time"];
		$this -> species_name = $this -> sourceArr["species_name"];
		$this -> location = $this -> sourceArr["location"];
		$this -> number_sighted = $this -> sourceArr["number_sighted"];

		$this -> city = $this -> sourceArr["city"];
		$this -> state = $this -> sourceArr["state"];

		$this -> folder = $this -> sourceArr["folder"];

		$this -> image_url = "http://thewildlab.org/glass/images/" . $this -> folder . ".jpg";

		$this -> latitude = $this -> sourceArr["latitude"];
		$this -> longitude = $this -> sourceArr["longitude"];

		$this -> habitat_name = $this -> sourceArr["habitat_name"];
		$this -> note = $this -> sourceArr["note"];
	}

}
?>