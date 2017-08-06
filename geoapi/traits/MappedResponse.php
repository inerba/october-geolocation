<?php namespace Inerba\Geolocation\Geoapi\Traits;

use Response;

trait MappedResponse {

    private function get_json($model,$mapping=[])
    {
        $markers = [];
        $num = 0;
        foreach ($model as $itemkey => $item) {

            foreach ($mapping as $k => $v) {
                $markers[$num][$k] = $item->$v;
            }

            $num++;
        }
        return Response::json($markers);
    }
    
}