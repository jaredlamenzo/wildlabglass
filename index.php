<?php

require_once 'config.php';
require_once 'mirror-client.php';
require_once 'google-api-php-client/src/Google_Client.php';
require_once 'google-api-php-client/src/contrib/Google_MirrorService.php';
require_once 'util.php';

$client = get_google_api_client();

// Authenticate if we're not already
if (!isset($_SESSION['userid']) || get_credentials($_SESSION['userid']) == null) {
  header('Location: ' . $base_url . '/oauth2callback.php');
  exit;
} else {
  verify_credentials(get_credentials($_SESSION['userid']));
  $client->setAccessToken(get_credentials($_SESSION['userid']));
}

// A glass service for interacting with the Mirror API
$mirror_service = new Google_MirrorService($client);

// But first, handle POST data from the form (if there is any)
switch ($_POST['operation']) {
  case 'insertMostRecentSighting':
	$new_timeline_item = new Google_TimelineItem();
    //$new_timeline_item->setText($_POST['message']);
    $wl_msg_html = "<article style=\"left: 0px; visibility: visible;\">  
				    <img src=\"". $_POST['imageUrl'] ."\" width=\"100%\" height=\"100%\">
					<section>    
						<div class=\"text-medium\" style=\"\">      
							<p class=\"yellow\">". $_POST['speciesName'] ."</p>     
						</div> 
						<div class=\"text-small\" style=\"\">" . $_POST['city'] . ", " . $_POST['state']. "</div>  
					</section>  
					<footer>    
						<div>Sighted by " . $_POST['username'] . "</div>  
					</footer>
				</article>";
							
    $new_timeline_item->setHtml($wl_msg_html);

    $notification = new Google_NotificationConfig();
    $notification->setLevel("DEFAULT");
    $new_timeline_item->setNotification($notification);

    insert_timeline_item($mirror_service, $new_timeline_item, null, null);

    $message = "Timeline Item inserted!";
    break;
	
}
?>
<!doctype html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>The WildLab for Glass</title>
  <link href="./static/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
  <link href="./static/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
  <link href="./static/main.css" rel="stylesheet" media="screen">
</head>
<body>
<div class="navbar navbar-inverse navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container">
      <a class="brand" href="#"><img src="./static/images/logo.png"></a>
    </div>
  </div>
</div>

<div class="container">

  <?php if ($message != "") { ?>
  <div class="alert alert-info"><?php echo $message; ?> </div>
  <?php } ?>


    <div class="row">
      <div class="span6">
	    <h2>What does it do?</h2>
	    <p>The WildLab for Glass collects data from theWildLab.org and sends you the most recent sighting every hour.</p>
	    <p>For more information, visit <a href="http://www.thewildlab.org" target="_blank">http://www.thewildlab.org</a></p>
		<?php
			$url="http://www.thewildlab.org/sighting/feeds/";
		
		    $json = file_get_contents($url);
			
			// see http://php.net/manual/en/function.json-decode.php
		    //$data = json_decode($json, TRUE);
			//var_dump($data["sighting_list"][0]["sighting_id"]);
		
			
			$data = json_decode($json, TRUE);
			$wl_username = $data["sighting_list"][0]["username"];
			$wl_sightingtime = $data["sighting_list"][0]["sighting_time"];
			$wl_species_name = $data["sighting_list"][0]["species_name"];
			$wl_location = $data["sighting_list"][0]["location"];
			$wl_number_sighted = $data["sighting_list"][0]["number_sighted"];
			
			$wl_city = $data["sighting_list"][0]["city"];
			$wl_state = $data["sighting_list"][0]["state"];
			
			$wl_image_url = "http://zonefive.us/glassfun/images/" . $data["sighting_list"][0]["folder"] . ".jpg";
			
			// echo("Content grabbed from " . $url . ":");
			// echo("<br/>");
			// echo("<br/>");
			// echo("username: " . $wl_username);
			// echo("<br/>");
			// echo("sighting_time: " . $wl_sightingtime);
			// echo("<br/>");
			// echo("species_name: " . $wl_species_name);
			// echo("<br/>");
			// echo("location: " . $wl_location);
			// echo("<br/>");
			// echo "image:";
			// echo "<br/>";
			// echo("<img src='". $wl_image_url . "'>") ;
		
		?>
	    <br/>
	    <form method="post">
	        <input type="hidden" name="operation" value="insertMostRecentSighting">
	        <input type="hidden" name="speciesName" value="<?php echo $wl_species_name ?>" -->
	        <input type="hidden" name="city" value="<?php echo $wl_city ?>" -->
	        <input type="hidden" name="state" value="<?php echo $wl_state ?>" -->
	        <input type="hidden" name="username" value="<?php echo $wl_username ?>" -->
	        
	        <input type="hidden" name="imageUrl" value="<?php echo $wl_image_url ?>">
	        <input type="hidden" name="contentType" value="image/jpeg">
	
	        <button class="btn btn-block" type="submit">Send the most recent sighting to me now!</button>
	    </form>
	    <br/>
	    <br/>

		<div>Copyright 2009-2013 The WildLab. All rights reserved. Glass is a trademark of Google Inc.</div>

    </div>

  </div>  

</div>


<script
    src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="/static/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
