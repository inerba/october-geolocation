<?php
/**
 *  Based on Laravel-Geographical (http://github.com/malhal/Laravel-Geographical)
 *
 *  Created by Malcolm Hall on 4/10/2016.
 *  Copyright © 2016 Malcolm Hall. All rights reserved.
 */

namespace Inerba\Geolocation\Behaviors;

use Illuminate\Database\Eloquent\Builder;

class Geographical extends \October\Rain\Extension\ExtensionBase
{
    
    protected $parent;

    public function __construct($parent)
    {
        $this->parent = $parent;
    }

    /**
     * @param Builder $query
     * @param float $latitude Latitude
     * @param float $longitude Longitude
     * @return Builder
     */
    public function scopeDistance($query, $latitude, $longitude)
    {
        $latName = $this->getQualifiedLatitudeColumn();
        $lonName = $this->getQualifiedLongitudeColumn();
        $query->select($this->getTable() . '.*');
        $sql = "((ACOS(SIN(? * PI() / 180) * SIN(" . $latName . " * PI() / 180) + COS(? * PI() / 180) * COS(" .
            $latName . " * PI() / 180) * COS((? - " . $lonName . ") * PI() / 180)) * 180 / PI()) * 60 * ?) as distance";

        $query->selectRaw($sql, [$latitude, $latitude, $longitude, 1.1515 * 1.609344]);

        return $query;
    }

    public function scopeGeofence($query, $latitude, $longitude, $inner_radius, $outer_radius)
    {
        $query = $this->scopeDistance($query, $latitude, $longitude);
        return $query->havingRaw('distance BETWEEN ? AND ?', [$inner_radius, $outer_radius]);
    }

    protected function getQualifiedLatitudeColumn()
    {
        return $this->getTable() . '.geo_lat';
    }

    protected function getQualifiedLongitudeColumn()
    {
        return $this->getTable() . '.geo_lng';
    }

    public function getTable()
    {
        return $this->parent->getTable();
    }
}

?>