<?php
Route::group(['prefix' => 'geoapi/v1'], function () {
	
	// Blog posts
	Route::group(['prefix' => 'posts'], function () {
        Route::get('near/{lat}/{lng}/{max_distance?}/{paginate?}/{page?}', 'Inerba\Geolocation\Geoapi\BlogPosts@near');
    	Route::get('geofence/{lat}/{lng}/{inner_radius?}/{outer_radius?}/{paginate?}/{page?}', 'Inerba\Geolocation\Geoapi\BlogPosts@geofence');
    });

});