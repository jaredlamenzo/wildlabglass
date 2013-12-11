<?php
/**
 * Singleton class
 *
 * http://stackoverflow.com/questions/203336/creating-the-singleton-design-pattern-in-php5/203359#203359
 * 
 * To use:
 * $fact = SightingsProxy::Instance();
 * $fact2 = SightingsProxy::Instance();
 */
 
final class SightingsProxy
{
	
	var $data;
	
    /**
     * Call this method to get singleton
     *
     * @return SightingsProxy
     */
    public static function Instance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new SightingsProxy();
        }
        return $inst;
    }

    /**
     * Private ctor so nobody else can instance it
     *
     */
    private function __construct()
    {
		$this->updateDataFromServer();
    }
	
	private function updateDataFromServer()
	{
		$url="http://www.thewildlab.org/sighting/feeds/";
		$json = file_get_contents($url);
		$this->data = json_decode($json, TRUE);
	}
	
	
	public function getSightingByIndex($index)
	{
		$dataArr = $this->data["sighting_list"][$index];
		$curSighting = new Sighting($dataArr);
		return $curSighting;
		
	}
	
}

?>