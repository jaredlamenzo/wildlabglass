<?php
	
require_once '../src/sighting/Sighting.php';
require_once '../src/sighting/SightingsProxy.php';
require_once '../src/sighting/TemplateFactory.php';

echo "Sightings Test"; 


$latestSighting = SightingsProxy::Instance()->getSightingByIndex(0);

echo TemplateFactory::Instance()->getSightingCoverArticle($latestSighting);
echo "<BR><BR>";

echo TemplateFactory::Instance()->getMapArticle($latestSighting);
echo "<BR><BR>";

echo serialize(TemplateFactory::Instance()->getSightingMenuItems($latestSighting));
echo "<BR><BR>";

//echo serialize($latestSighting); 

?>