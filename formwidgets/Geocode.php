<?php namespace Inerba\Geolocation\FormWidgets;

use Html;
use Backend\Classes\FormWidgetBase;
use Inerba\Geolocation\Models\Setting;

class Geocode extends FormWidgetBase
{
    /**
     * {@inheritDoc}
     */
    public $defaultAlias = 'geocode';

    protected $fieldMap;

    /**
     * {@inheritDoc}
     */
    public function init()
    {
        $this->fieldMap = $this->getConfig('fieldMap', []);
    }

    /**
     * {@inheritDoc}
     */
    public function render()
    {
        $this->prepareVars();
        return $this->makePartial('geocode');
    }

    /**
     * Prepares the list data
     */
    public function prepareVars()
    {
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['field'] = $this->formField;
    }

    public function getFieldMapAttributes()
    {
        if($this->controller->getId() == "Settings-update"){
            $result = [];

            foreach ($this->fieldMap as $map => $fieldName) {
                $result['data-input-'.$map] = '#Form-field-Settings-'.$fieldName;
            }
        } else {
            $widget = $this->controller->formGetWidget();

            $fields = $widget->getFields();
            $result = [];
            foreach ($this->fieldMap as $map => $fieldName) {
                if (!$field = array_get($fields, $fieldName)) {
                    continue;
                }

                $result['data-input-'.$map] = '#'.$field->getId();
            }
            
        }      

        return Html::attributes($result);
    }

    /**
     * {@inheritDoc}
     */
    public function loadAssets()
    {
        $apiKey = Setting::get('google_maps_key');
        $this->addJs('//maps.googleapis.com/maps/api/js?libraries=places&key='.$apiKey);
        $this->addJs('js/location-autocomplete.js', 'core');
    }
}
