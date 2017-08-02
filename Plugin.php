<?php namespace Inerba\Geolocation;

use Backend;
use System\Classes\PluginBase;
use Inerba\Geolocation\Classes\Geolocation as Geo;

/**
 * Geolacatio Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'inerba.geolocation::lang.plugin.name',
            'description' => 'inerba.geolocation::lang.plugin.description',
            'author'      => 'Inerba',
            'icon'        => 'icon-globe',
            'homepage'    => 'https://github.com/inerba/october-geolocation'
        ];
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'inerba.geolocation::lang.settings.menu_label',
                'description' => 'inerba.geolocation::lang.settings.menu_description',
                'category'    => 'inerba.geolocation::lang.plugin.name',
                'icon'        => 'icon-map-signs',
                'class'       => 'Inerba\Geolocation\Models\Setting',
                'order'       => 600,
                'permissions' => ['inerba.geolocation.access_settings'],
            ]
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'Inerba\Geolacatio\Components\MyComponent' => 'myComponent',
        ];
    }

    public function registerPermissions()
    {
        return [
            'inerba.geolocation.access_settings' => [
                'label' => 'inerba.geolocation::lang.permissions.settings',
                'tab' => 'inerba.geolocation::lang.plugin.name'
            ],
        ];
    }

    /**
     * Registers any form widgets implemented in this plugin.
     */
    public function registerFormWidgets()
    {
        return [
            'Inerba\Geolocation\FormWidgets\Geocode' => 'geocode'
        ];
    }

    public function registerMarkupTags()
    {
        return [
            'functions' => [
                'geo_reverse'   => [Geo::class, 'geo_reverse'],
                'geo_geocode'   => [Geo::class, 'geo_geocode'],
                'geo_distance'  => [Geo::class, 'geo_distance'],
                'geo_reverse_distance'  => [Geo::class, 'geo_reverse_distance'],
            ]
        ];
    }
}
