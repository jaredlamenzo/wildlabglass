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
  exit;
} else {
  verify_credentials(get_credentials($_SESSION['userid']));
  $client->setAccessToken(get_credentials($_SESSION['userid']));
}

// A glass service for interacting with the Mirror API
$mirror_service = new Google_MirrorService($client);


// latest sighting
$latestSighting = SightingsProxy::Instance()->getSightingByIndex(0);	
$htmlText = TemplateFactory::Instance()->getSightingCoverArticle($latestSighting) . TemplateFactory::Instance()->getMapArticle($latestSighting);
// end of organize data -----------------------------------------------


$new_timeline_item = new Google_TimelineItem();
$new_timeline_item->setHtml($htmlText);

$notification = new Google_NotificationConfig();
$notification->setLevel("DEFAULT");
$new_timeline_item->setNotification($notification);

//-------------------------------------
// insert menu items
//-------------------------------------
$menuItems = TemplateFactory::Instance()->getSightingMenuItems($latestSighting);
$new_timeline_item->setMenuItems($menuItems);

//-------------------------------------
// insert timeline item
//-------------------------------------
insert_timeline_item($mirror_service, $new_timeline_item, null, null);

//-------------------------------------
// respond
//-------------------------------------
$message = "Timeline Item inserted!";
echo $message;

?>
