<?php namespace Inerba\Geolocation\Geoapi\Traits;

use Response;

trait MappedResponse {

    private function get_json($model)
    {
        $markers = $model->map(function ($item) {

            return [
                'id' => $item->id,
                'title' => $item->title,
                'description' => $item->description,
                'latitude' => $item->geo_lat,
                'longitude' => $item->geo_lng
            ];

        });

        return Response::json($markers);
    }
    
}