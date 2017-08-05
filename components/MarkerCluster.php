<?php namespace Inerba\Geolocation\Components;

use Cms\Classes\ComponentBase;
use RainLab\Blog\Models\Post as PostModel;
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
        $latitude = 31.030117;
        $longitude = 2.796551;
        $inner_radius = 0;
        $outer_radius = 1000;

        $posts = PostModel::geofence($latitude, $longitude, $inner_radius, $outer_radius)->get();

        foreach ($posts as $item) {

            if(!is_null($item->geo_lat) || !is_null($item->geo_lng))          
                $markers[] = [
                    'title' => $item->title,
                    'description' => $item->description,
                    'latitude' => $item->geo_lat,
                    'longitude' => $item->geo_lng,
                ];
        }

        dd($markers);

        /*
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
        */
        
        return Response::json($markers);
    }
}
