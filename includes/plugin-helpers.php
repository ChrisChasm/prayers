<?php

function echo_parse_location( $location = null ) {
	if ( is_null($location) ) return;

	var_dump($location);
	
	$prepAddr = str_replace(' ', '+', $location);
	$geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
    $output= json_decode($geocode);

    $parsed_location['formatted_address'] = $output->results[0]->formatted_address; // Lexington, KY, USA
    $parsed_location['lat'] = $output->results[0]->geometry->location->lat;
    $parsed_location['long'] = $output->results[0]->geometry->location->lng;
    $parsed_location['country_long'] = $output->results[0]->address_components[3]->long_name;
    $parsed_location['country_short'] = $output->results[0]->address_components[3]->short_name;

    return $parsed_location;
}