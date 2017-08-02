<?php namespace Inerba\Geolocation\Components;

use Cms\Classes\ComponentBase;
use Inerba\Geolocation\Models\Setting;
use Inerba\Geolocation\Classes\Geolocation as Geo;

class GoogleMap extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'GoogleMap Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'address' => [
                'title'             => 'Address',
                'type'              => 'string',
            ],
            'latitude' => [
                'title'             => 'Latitude',
                'default'           => 51.506767,
                'type'              => 'string',
            ],
            'longitude' => [
                'title'             => 'Longitude',
                'default'           => -0.122205,
                'type'              => 'string',
            ],
            'zoom' => [
                'title'             => 'Zoom',
                'default'           => 12,
                'type'              => 'string',
            ],
            'width' => [
                'title'             => 'Width',
                'default'           => '100%',
                'description'       => 'It can be use px or %',
                'type'              => 'string',
            ],
            'height' => [
                'title'             => 'Height',
                'default'           => '350px',
                'description'       => 'Use px only',
                'type'              => 'string',
            ],
            'mapTypeId' => [
                'title'             => 'Map Type',
                'default'           => 'ROADMAP',
                'type'              => 'dropdown',
                'options'           => ['ROADMAP'=>'Roadmap', 'SATELLITE'=>'Satellite', 'HYBRID'=>'Hybrid', 'TERRAIN'=>'Terrain']
            ],
            'showMarker' => [
                'title'             => 'Show Marker',
                'default'           => 'true',
                'type'              => 'checkbox',
            ],
            
        ];
    }

    public function onRun()
    {
        $settings = Setting::instance();

        $address = $this->property('address');
        $latitude = $this->property('latitude');
        $longitude = $this->property('longitude');

        if($address) {
            $geocode = Geo::geo_geocode($address);
            $latitude = $geocode->coordinates->lat;
            $longitude = $geocode->coordinates->lng;
        }

        $this->page['google_maps_key'] = $settings->google_maps_key;
        $this->page['latitude'] = $latitude;
        $this->page['longitude'] = $longitude;
    }
}
