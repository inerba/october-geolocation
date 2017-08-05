<?php namespace Inerba\Geolocation\Components;

use Cms\Classes\ComponentBase;
use Response;

class MarkerCluster extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'MarkerCluster Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            "component_data" => [
                "title" => "Data from",
                "default" => "posts"
            ],
            "debug_item" => [
                "title" => "Debug",
                "default" => 0,
                "type" => "checkbox",
            ],
            "marker_title" => [
                "title" => "Title data from",
                "default" => "title",
                "group" => "Mapping",
            ],
            "marker_description" => [
                "title" => "Description data from",
                "default" => "description",
                "group" => "Mapping",
            ],
            "marker_lat" => [
                "title" => "latitude",
                "default" => "geo_lat",
                "group" => "Mapping",
            ],
            "marker_lng" => [
                "title" => "longitude",
                "default" => "geo_lng",
                "group" => "Mapping",
            ]
        ];
    }

    public function onRun()
    {
        
        $p = $this->getProperties();

        $cd = $this->page->{$p['component_data']};

        $markers = [];
        foreach ($cd as $item) {

            if(!is_null($item->{$p['marker_lat']}) || !is_null($item->{$p['marker_lng']}))          
                $markers[] = [
                    'title' => $item->{$p['marker_title']},
                    'description' => $item->{$p['marker_description']},
                    'latitude' => $item->{$p['marker_lat']},
                    'longitude' => $item->{$p['marker_lng']},
                ];
        }
        
        return Response::json($markers);
    }
}
