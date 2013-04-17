<?php
class Metrix {
	/**
	 *
	 *
	 *
	 * Calculate distance between 2 GPS coordinates (lat and long)
	 *
	 * @param unknown_type $lat1        	
	 * @param unknown_type $lng1        	
	 * @param unknown_type $lat2        	
	 * @param unknown_type $lng2        	
	 * @param unknown_type $miles        	
	 * @return number
	 */
	function DistanceBetweenPoints($lat1, $lon1, $lat2, $lon2) {
		$pi80 = M_PI / 180;
		$lat1 *= $pi80;
		$lng1 *= $pi80;
		$lat2 *= $pi80;
		$lng2 *= $pi80;
	
		$r = 6372.797; // mean radius of Earth in km
		$dlat = $lat2 - $lat1;
		$dlng = $lng2 - $lng1;
		$a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
		$c = 2 * atan2(sqrt($a), sqrt(1 - $a));
		$km = $r * $c;
	
		return round($km, 2);
	}
}

?>