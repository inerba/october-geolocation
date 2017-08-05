<?php
Route::group(['prefix' => 'geoapi/v1'], function () {
    //Route::resource('posts', 'Inerba\Geolocation\Geoapi\BlogPosts');
    Route::get('posts/near/{lat}/{lng}/{paginate?}/{page?}', 'Inerba\Geolocation\Geoapi\BlogPosts@near');
    Route::get('posts/geofence/{lat}/{lng}/{inner_radius?}/{outer_radius?}/{paginate?}/{page?}', 'Inerba\Geolocation\Geoapi\BlogPosts@geofence');
});