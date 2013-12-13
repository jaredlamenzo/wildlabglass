<?php
/**
 * Singleton class
 *
 * http://stackoverflow.com/questions/203336/creating-the-singleton-design-pattern-in-php5/203359#203359
 *
 * To use:
 * $fact = TemplateFactory::Instance();
 */

require_once 'Sighting.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/mirror-client.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/google-api-php-client/src/Google_Client.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/google-api-php-client/src/contrib/Google_MirrorService.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/util.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

final class TemplateFactory {

	/**
	 * Call this method to get singleton
	 *
	 * @return TemplateFactory
	 */
	public static function Instance() {
		static $inst = null;
		if ($inst === null) {
			$inst = new TemplateFactory();
		}
		return $inst;
	}

	/**
	 * Private ctor so nobody else can instance it
	 *
	 */
	private function __construct() {

	}

	public function getSightingCoverArticle($inSighting) {
		return "<article class=\"cover-only\">  
			    <img src=\"" . $inSighting -> image_url . "\" width=\"100%\" height=\"100%\">
				<section>    
					<div class=\"text-medium\" style=\"\">      
						<p class=\"yellow\">" . $inSighting -> species_name . "</p>     
					</div> 
					<div class=\"text-small\" style=\"\">" . $inSighting -> city . ", " . $inSighting -> state . "</div>  
				</section>  
				<footer>    
					<div>Sighted by " . $inSighting -> username . "</div>  
				</footer>
			</article>";
	}

	public function getMapArticle($inSighting, $myLocation) {
		if ($myLocation) {
			return "<article>
				<img src=\"glass://map?w=640&h=360&marker=0;" . $inSighting -> latitude . "," . $inSighting -> longitude . "&marker=1;" . $myLocation -> getLatitude() . "," . $myLocation -> getLongitude() . "\"height=\"360\" width=\"640\">
				</article>";
		} else {
			return "<article>
				<img src=\"glass://map?w=640&h=360&center=" . $inSighting -> latitude . "," . $inSighting -> longitude . "&zoom=4&marker=0;" . $inSighting -> latitude . "," . $inSighting -> longitude . "\"height=\"360\" width=\"640\">
				</article>";
		}
	}

	public function getSightingSpeciesOnly($inSighting) {
		return "<article class=\"photo\">
			    <img src=\"" . $inSighting -> image_url . "\" width=\"100%\" height=\"100%\">
				<div class=\"photo-overlay\"/>
					<section>
						<p class=\"text-auto-size\">" . $inSighting -> species_name . "</p>
					</section>
				</article>";
	}
	
	public function getSightingMoreInfo($inSighting) {
		return "<article>
					<section>
						<ul class=\"text-x-small\">
							<li>" . $inSighting -> species_name . "</li>
							<li>Quantity sighted: ". $inSighting -> number_sighted . "</li>
							<li>Sighted by: ". $inSighting -> username . "</li>
							<li>Location: " . $inSighting -> location . "</li>
							<li>Habitat: ". $inSighting -> habitat_name . "</li>
						</ul>
					</section>
					<footer>
						<p> </p>
					</footer>
				</article>";
	}


	public function getSightingNote($inSighting) {
		if($inSighting -> note == ""){
			return "";
		} else {
			return "<article>
						<section>
							<p class=\"text-auto-size\">
								<em class=\"yellow\">Note:</em> 
								" . $inSighting -> note . ".
							</p>
						</section>
					</article>";
		}
	}


	public function getSightingMenuItems($inSighting) {
		global $base_url;

		//-------------------------------------
		// A couple of built in menu items
		//-------------------------------------
		$menu_items = array();

		//-------------------------------------
		// 1. OPenURI - Wikipedia link
		//-------------------------------------
		global $wl_species_name;

		$menu_item = new Google_MenuItem();
		$menu_item -> setAction("OPEN_URI");

		// A custom displayName
		$custom_menu_item = new Google_MenuItem();
		$custom_menu_value = new Google_MenuValue();
		$custom_menu_value -> setDisplayName("Species Info");
		$menu_item -> setValues(array($custom_menu_value));

		$menu_item -> setPayload("http://en.wikipedia.org/wiki/Special:Search/" . $inSighting -> species_name);
		array_push($menu_items, $menu_item);

		//-------------------------------------
		// 2. SHARE
		//-------------------------------------
		$menu_item = new Google_MenuItem();
		$menu_item -> setAction("SHARE");
		array_push($menu_items, $menu_item);

		//-------------------------------------
		// 3. DELETE
		//-------------------------------------
		$menu_item = new Google_MenuItem();
		$menu_item -> setAction("DELETE");
		array_push($menu_items, $menu_item);

		//-------------------------------------
		// 4. CUSTOM - Map
		//-------------------------------------
		// $custom_menu_item = new Google_MenuItem();
		// $custom_menu_value = new Google_MenuValue();
		// $custom_menu_value -> setDisplayName("Show Map");
		// $custom_menu_value -> setIconUrl($base_url . "/static/images/show_map.png");
		//
		// $custom_menu_item -> setValues(array($custom_menu_value));
		// $custom_menu_item -> setAction("CUSTOM");
		// // This is how you identify it on the notification ping
		// $custom_menu_item -> setId("show-map");
		// array_push($menu_items, $custom_menu_item);

		return $menu_items;

	}

}
?>