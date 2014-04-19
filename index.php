<?php
require_once 'config.php';
require_once 'mirror-client.php';
require_once 'google-api-php-client/src/Google_Client.php';
require_once 'google-api-php-client/src/contrib/Google_MirrorService.php';
require_once 'util.php';

require_once 'wildlab-glass-lib/src/sighting/Sighting.php';
require_once 'wildlab-glass-lib/src/sighting/SightingsProxy.php';
require_once 'wildlab-glass-lib/src/sighting/TemplateFactory.php';

$client = get_google_api_client();

// Authenticate if we're not already
if (!isset($_SESSION['userid']) || get_credentials($_SESSION['userid']) == null) {
	header('Location: ' . $base_url . '/oauth2callback.php');
	exit ;
} else {
	verify_credentials(get_credentials($_SESSION['userid']));
	$client -> setAccessToken(get_credentials($_SESSION['userid']));
}

// A glass service for interacting with the Mirror API
$mirror_service = new Google_MirrorService($client);
?>


<!doctype html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">
  <title>The WildLab for Glass </title>
  <link href="./static/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
  <link href="./static/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
  <link href="./static/main.css" rel="stylesheet" media="screen">
  <style type="text/css">
	.footerText {
		font-size: 12px;
		color: #FFF;
	}
	.span4 {
		background-color: #545353;
		color: #F9ED33;
		height: 350px;
		width: 280px;
		padding-left: 10px;
		padding-top: 10px;
		padding-right: 10px;
		padding-bottom: 10px;
	}
  </style>
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

  <div id="formResponse"></div>

  <!--?php if ($message != "") { ?-->
  <!--div id="formResponse" class="alert alert-info"><?php echo $message; ?> </div-->
  <!--?php } ?-->

  <h2>Experience the natural world like never before.</h2>
  <div class="row">
    <div style="margin-top: 5px; margin-left: 30px;">
    	<p>Use the WildLab for Glass™ as your window onto the natural world. Envision a new kind of learning, framed by the sky and the earth.</p>
    	<p>You will receive notifications about wildlife near you, and contribute to our citizen science database:</p>
    	<ol>
			<li>Get started by authorizing WildLab for Glass. Then, click on the “insert sighting” button to the left. In your Glass, you will see an update with a photograph of the species, its locations, and more.</li>
  			<li>Your sightings can be viewed and shared on social networks.</li>
		</ol>
		<p>The WildLab has already reached tens of thousands of learners across the country. They have collected sightings for use in citizen science and their own outdoor explorations. See our <a href="http://thewildlab.org/" target="_blank">Web site</a> for more information. </p> 
    </div>
  </div>

    <br/>
    	
    <div class="row">
      <div class="span4">
	    <h3>Send Sighting to Me</h3>
	    
		<?php
 		// http://stackoverflow.com/questions/18171017/show-submitted-form-response-on-the-same-page-no-reload
 		
		$latestSighting = SightingsProxy::Instance() -> getSightingByIndex(0);

		/*
		 echo("Username: " . $latestSighting -> username);
		 echo("<br/>");
		 echo("Sighting Time: " . $latestSighting -> sightingtime);
		 echo("<br/>");
		 echo("Species Name: " . $latestSighting -> species_name);
		 echo("<br/>");
		 */
		echo("<br/>");
		echo("<img src='" . $latestSighting -> image_url . "'>");
		?>
	    <br/>
	    <br/>
	    <form id="insertMostRecentSightingMeForm" action="insertMostRecentSightingMe.php" method="post">
	        <button class="btn btn-block" type="submit">Insert a sighting</button>
	    </form>
	    <br/>
	    <br/>

    </div>
    
    
    
    <div class="span4">
	    <h3>Upcoming</h3>
	    <p>You will submit sightings by saying the species name followed by the quantity, e.g., "American Robins, 5."</p>
	    <br/>
	    <img src="./static/images/birds_x5_2.png"></img>
    </div>

    <div class="span4">
	    <h3>Upcoming</h3>
	    <p>You will select the frequency of updates using the toggles below. Currently they are sent every hour.</p>
	    <br/>
	    <img src="./static/images/toggle_fake_2.png"></img>
    </div>

  </div>  

	<div class="navbar navbar-inverse navbar-fixed-bottom">
		<div class="navbar-inner">
			<div class="container">
			    <div style="margin-top: 10px;">
			    	<a href="http://thewildlab.org/terms" target="_blank">Terms and Services</a> | <a href="http://thewildlab.org/policy" target="_blank">Privacy Policy</a>
					<p class="footerText">Copyright 2009-2013 The WildLab. All rights reserved. Glass is a trademark of Google Inc.</p>
			    </div>
			</div>
		</div>
	</div>

</div>


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="/static/bootstrap/js/bootstrap.min.js"></script>

<script>
     $("#insertMostRecentSightingMeForm").submit(function(event) 
     {
         /* stop form from submitting normally */
         event.preventDefault();

         /* get some values from elements on the page: */
         var $form = $( this ),
             url = $form.attr('action');

         /* Send the data using post */
         var posting = $.post(url);

         posting.done(function( data )
         {
             /* Put the results in a div */
             $( "#formResponse" ).html(data);

             /* Change the button text. */
             //$submit.text('Sent, Thank you');

             /* Disable the button. */
             //$submit.attr("disabled", true);
         });
    });
</script>

</body>
</html>
