<?php
require_once 'config.php';
require_once 'mirror-client.php';
require_once 'google-api-php-client/src/Google_Client.php';
require_once 'google-api-php-client/src/contrib/Google_MirrorService.php';
require_once 'util.php';



// cron job set up in Dreamhost:
// 1. http://wiki.dreamhost.com/Cron_Jobs
// 2. http://wiki.dreamhost.com/Run_PHP_from_cron

// cron job command to be entered to the dreamhost panel:
// /usr/local/php54/bin/php /home/pwang/zonefive.us/glassfun/insertMostRecentSightingAllUsers.php 

$credentials = list_credentials();
if (count($credentials) > 10) {
  $message = "Found " . count($credentials) . " users. Aborting to save your quota.";
} else {
	// organize data -----------------------------------------------
	$url="http://www.thewildlab.org/sighting/feeds/";
			
	$json = file_get_contents($url);
				
	$data = json_decode($json, TRUE);
	$wl_username = $data["sighting_list"][0]["username"];
	$wl_sightingtime = $data["sighting_list"][0]["sighting_time"];
	$wl_species_name = $data["sighting_list"][0]["species_name"];
	$wl_location = $data["sighting_list"][0]["location"];
	$wl_number_sighted = $data["sighting_list"][0]["number_sighted"];
				
	$wl_city = $data["sighting_list"][0]["city"];
	$wl_state = $data["sighting_list"][0]["state"];
	
	$wl_folder = $data["sighting_list"][0]["folder"];
				
	$wl_image_url = "http://zonefive.us/glassfun/images/" . $wl_folder . ".jpg";
			
	$wl_msg_html = "<article style=\"left: 0px; visibility: visible;\">  
		    <img src=\"". $wl_image_url ."\" width=\"100%\" height=\"100%\">
			<section>    
				<div class=\"text-medium\" style=\"\">      
					<p class=\"yellow\">". $wl_species_name ."</p>     
				</div> 
				<div class=\"text-small\" style=\"\">" . $wl_city . ", " . $wl_state . "</div>  
			</section>  
			<footer>    
				<div>Sighted by " . $wl_username . "</div>  
			</footer>
		</article>";
	// end of organize data -----------------------------------------------
  foreach ($credentials as $credential) {
        $user_specific_client = get_google_api_client();
        $user_specific_client->setAccessToken($credential['credentials']);

        $new_timeline_item = new Google_TimelineItem();
		
	    $new_timeline_item->setHtml($wl_msg_html);
	
	    $notification = new Google_NotificationConfig();
	    $notification->setLevel("DEFAULT");
	    $new_timeline_item->setNotification($notification);

        $user_specific_mirror_service = new Google_MirrorService($user_specific_client);

        insert_timeline_item($user_specific_mirror_service, $new_timeline_item, null, null);
  }
  $message = "Sent to " . count($credentials) . " users.";
  echo $message;
}

?>
