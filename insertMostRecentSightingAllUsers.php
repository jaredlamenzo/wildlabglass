<?php
require_once 'config.php';
require_once 'mirror-client.php';
require_once 'google-api-php-client/src/Google_Client.php';
require_once 'google-api-php-client/src/contrib/Google_MirrorService.php';
require_once 'util.php';

require_once 'wildlab-glass-lib/src/sighting/Sighting.php';
require_once 'wildlab-glass-lib/src/sighting/SightingsProxy.php';
require_once 'wildlab-glass-lib/src/sighting/TemplateFactory.php';

$credentials = list_credentials();
if (count($credentials) > 10) {
  $message = "Found " . count($credentials) . " users. Aborting to save your quota.";
} else {
	// organize data -----------------------------------------------
			
	// latestSighting
	$latestSighting = SightingsProxy::Instance()->getSightingByIndex(0);	
	$menuItems = TemplateFactory::Instance()->getSightingMenuItems($latestSighting);

	// end of organize data -----------------------------------------------
  foreach ($credentials as $credential) {
        $user_specific_client = get_google_api_client();
        $user_specific_client->setAccessToken($credential['credentials']);

        $user_specific_mirror_service = new Google_MirrorService($user_specific_client);

        $new_timeline_item = new Google_TimelineItem();

		$userSpecificLocation = $user_specific_mirror_service->locations->get('latest');
		$htmlText = TemplateFactory::Instance()->getSightingCoverArticle($latestSighting) . 
					TemplateFactory::Instance()->getMapArticle($latestSighting, $userSpecificLocation) .
					TemplateFactory::Instance()->getSightingSpeciesOnly($latestSighting) .
					TemplateFactory::Instance()->getSightingMoreInfo($latestSighting) .
					TemplateFactory::Instance()->getSightingNote($latestSighting)
					;
	    $new_timeline_item->setHtml($htmlText);
	
	    $notification = new Google_NotificationConfig();
	    $notification->setLevel("DEFAULT");
	    $new_timeline_item->setNotification($notification);

		//-------------------------------------
		// insert menu items
		//-------------------------------------
		$new_timeline_item->setMenuItems($menuItems);

        insert_timeline_item($user_specific_mirror_service, $new_timeline_item, null, null);
  }
  $message = "Sent to " . count($credentials) . " users.";
  echo $message;
}

?>
