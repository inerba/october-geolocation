<?php namespace Inerba\Geolocation;

use Backend;
use Event;
use System\Classes\PluginBase;
use System\Classes\PluginManager;
use Inerba\Geolocation\Classes\Geolocation as Geo;
use RainLab\Blog\Models\Post as PostModel;


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

    public $require = ['RainLab.Blog','RainLab.Pages'];

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
        PostModel::extend(function($model){
            $model->implement[] = 'Inerba.Geolocation.Behaviors.Geographical';
            //$model->jsonable(array_merge($model->getJsonable(), ["geo_components"]));
            $model->addJsonable(["geo_components"]);

            $model->bindEvent('model.beforeSave', function() use ($model) {

                $input = input('Post');
                
                if(empty($model->geo_lat) || empty($model->geo_lng)){
                    $model->geo_lat = null;
                    $model->geo_lng = null;
                }
            });
        });

        Event::listen('backend.form.extendFields', function ($widget) {
            if( PluginManager::instance()->hasPlugin('RainLab.Blog') && $widget->model instanceof \RainLab\Blog\Models\Post)
            {

                $widget->addFields([
                    'geo_components[address]' => [
                        'label'   => 'inerba.geolocation::lang.blog.address',
                        'type'    => 'geocode',
                        'fieldMap' => [
                            'latitude' => 'geo_lat',
                            'longitude' => 'geo_lng',
                            'city' => 'geo_components[city]',
                            'province' => 'geo_components[province]',
                            'country' => 'geo_components[country]',
                            'zip' => 'geo_components[zip]'
                        ],
                        'tab'     => 'inerba.geolocation::lang.blog.geolocation',
                        'span'    => 'full',
                    ],
                    'geo_lat' => [
                        'label'   => 'inerba.geolocation::lang.blog.latitude',
                        'type'    => 'text',
                        'span'    => 'left',
                        'tab'     => 'inerba.geolocation::lang.blog.geolocation',
                    ],
                    'geo_lng' => [
                        'label'   => 'inerba.geolocation::lang.blog.longitude',
                        'type'    => 'text',
                        'span'    => 'right',
                        'tab'     => 'inerba.geolocation::lang.blog.geolocation',
                    ],
                    'geo_components[city]' => [
                        'label'   => 'inerba.geolocation::lang.blog.city',
                        'type'    => 'text',
                        'span'    => 'left',
                        'tab'     => 'inerba.geolocation::lang.blog.geolocation',
                    ],
                    'geo_components[province]' => [
                        'label'   => 'inerba.geolocation::lang.blog.province',
                        'type'    => 'text',
                        'span'    => 'right',
                        'tab'     => 'inerba.geolocation::lang.blog.geolocation',
                    ],
                    'geo_components[country]' => [
                        'label'   => 'inerba.geolocation::lang.blog.country',
                        'type'    => 'text',
                        'span'    => 'left',
                        'tab'     => 'inerba.geolocation::lang.blog.geolocation',
                    ],
                    'geo_components[zip]' => [
                        'label'   => 'inerba.geolocation::lang.blog.zip',
                        'type'    => 'text',
                        'span'    => 'right',
                        'tab'     => 'inerba.geolocation::lang.blog.geolocation',
                    ],
                    
                ],
                'secondary');
            }
        });
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            'Inerba\Geolocation\Components\GoogleMap' => 'GoogleMap',
            'Inerba\Geolocation\Components\MarkerCluster' => 'MarkerCluster',
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
                'geo_map'       => [Geo::class, 'map'],
                'geo_reverse'   => [Geo::class, 'reverse'],
                'geo_geocode'   => [Geo::class, 'geocode'],
                'geo_distance'  => [Geo::class, 'distance'],
                'geo_reverse_distance'  => [Geo::class, 'reverse_distance'],
            ]
        ];
    }
}
