<?php

function echo_parse_location( $location = null ) {
	if ( is_null($location) ) return;
	
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

function echo_save_location_meta( $id = 0, $location = null ) {
    if ( is_null($location) || $id == 0 ) return;

    add_post_meta( $id, 'meta-prayer-location-latitude', $location['lat'] );
    add_post_meta( $id, 'meta-prayer-location-longitude', $location['long'] );
    add_post_meta( $id, 'meta-prayer-location-formatted-address', $location['formatted_address'] );
    add_post_meta( $id, 'meta-prayer-location-country-long', $location['country_long'] );
    add_post_meta( $id, 'meta-prayer-location-country-short', $location['country_short'] );
}