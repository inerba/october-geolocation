<?php namespace Inerba\Geolocation\Classes;

use Cache;
use Inerba\Geolocation\Models\Setting;

use Location\Coordinate;
use Location\Distance\Vincenty;

class Geolocation
{
	private static $apiurl = 'https://maps.googleapis.com/maps/api/geocode/json';
	private static $directionsurl = 'https://maps.googleapis.com/maps/api/directions/json';

	public static function geo_map($map_address,$height='400px',$width='100%',$zoom=15,$mapType="ROADMAP", $marker=true)
	{
		$id = str_slug($map_address);

		$params = [
			'sensor' => 'false',
			'address' => $map_address
		];

		$settings = Setting::instance();

		$map_data = self::get_maps_json($params);

		$lat_lng = $map_data->coordinates->lat.",".$map_data->coordinates->lng;

		$html = '<div id="map-'.$id.'" class="google-map" style="height: '.$height.'; width: '.$width.';"></div>';
		$html .= "
				<script src=\"https://maps.googleapis.com/maps/api/js?v=3.exp&key=".$settings->google_maps_key."\"></script>
				<script>
				function initMap() {
					var center = new google.maps.LatLng(".$map_data->coordinates->lat.", ".$map_data->coordinates->lng.");
	    
				    var mapOptions = {
				      zoom: ".$zoom.",
				      center: center,
				      mapTypeId: google.maps.MapTypeId.".$mapType."
				    }
				    var map = new google.maps.Map(document.getElementById('map-".$id."'), mapOptions);
				";

		if($marker) $html .= "var beachMarker = new google.maps.Marker({ position: center, map: map });";

		$html .= "} google.maps.event.addDomListener(window, 'load', initMap); </script>";

		return $html;
	}

	public static function geo_geocode($map_address)
	{

		$params = [
			'sensor' => 'false',
			'address' => $map_address
		];

		return self::get_maps_json($params);
	}

	public static function geo_reverse($lat, $lng)
	{
		$params = [
			'sensor' => 'false',
			'latlng' => $lat.','.$lng
		];

		return self::get_maps_json($params);
	}

	public static function geo_reverse_distance($lat, $lng, $lat2, $lng2, $cache_duration = 10080)
	{
		$params = [
			'units' => 'metric',
			'origin' => $lat.','.$lng,
			'destination' => $lat2.','.$lng2
		];

		return self::get_directions($params, $cache_duration);
	}

	public static function geo_distance($loc1, $loc2, $cache_duration = 10080)
	{
		$params = [
			'units' => 'metric',
			'origin' => $loc1,
			'destination' => $loc2
		];

		return self::get_directions($params, $cache_duration);
	}

	private static function get_directions($params, $cache_duration = 10080)
	{
		$settings = Setting::instance();

		$url = self::$directionsurl . "?" . http_build_query(array_merge($params,['key'=>$settings->google_maps_key]));

		$direction = Cache::remember(md5($url), $cache_duration, function() use($url) {

			$data = file_get_contents($url);

			$jsondata = get_object_vars(json_decode($data));

			if($jsondata['status'] != "OK")
				return $jsondata['status'];
			
			// parse the json response
			$jsondata = $jsondata['routes'][0]->legs[0];

			$coordinate1 = new Coordinate($jsondata->start_location->lat, $jsondata->start_location->lng); 
			$coordinate2 = new Coordinate($jsondata->end_location->lat, $jsondata->end_location->lng); 

			$calculator = new Vincenty();

			$distance = $calculator->getDistance($coordinate1, $coordinate2);

			return (object)[
				'routes' => $jsondata->distance,
				'air' => (object) [
					'text' => self::formatDistance($distance),
					'value' => (int) round($distance)
				],
				'directions' => $jsondata, 
			];

		});

		return $direction;
	}

	private static function get_maps_json($params)
	{
		$settings = Setting::instance();

		$url = self::$apiurl . "?" . http_build_query(array_merge($params,['key'=>$settings->google_maps_key]));

		$data = file_get_contents($url);

		// parse the json response
		$jsondata = get_object_vars(json_decode($data))['results'][0];

		$address = [];
		foreach ($jsondata->address_components as $ac) {

			switch ($ac->types[0]) {
				case 'administrative_area_level_3':
					$type = 'city';
					break;

				case 'administrative_area_level_2':
					$type = 'province';
					break;

				case 'administrative_area_level_1':
					$type = 'region';
					break;
				
				default:
					$type = $ac->types[0];
					break;
			}

			$address[$type] = (object) [
				'long' => $ac->long_name,
				'short' => $ac->short_name,
			]; 
		}

		$coordinates = $jsondata->geometry->location;

		$return = (object) [
			'address' => $jsondata->formatted_address,
			'coordinates' => (object) $jsondata->geometry->location,
			'components' => (object) $address,
		];
		return $return;
	}

	public static function formatDistance($meters) {
		if(($meters / 1000) > 1) return round($meters / 1000,1) . " km";
		return round($meters) . " m";
    }

}