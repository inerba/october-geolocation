<?php

return [
    'plugin' => [
        'name' => 'Geolocation',
        'description' => 'Location based features, such as Country and State.',
    ],
    'permissions' => [
        'settings' => 'Locations management',
    ],
    'location' => [
        'label' => 'Location',
        'new' => 'New Location',
        'create_title' => 'Create Location',
        'update_title' => 'Edit Location',
        'preview_title' => 'Preview Location',
    ],
    'locations' => [
        'menu_label' => 'Countries & States',
        'menu_description' => 'Manage available user countries and states.',
        'disabled_label' => 'Disabled',
        'enabled_label' => 'Enabled',
        'enabled_help' => 'Disabled locations are not visible on the front-end.',
        'enable_or_disable_title' => "Enable or Disable Locations",
        'enable_or_disable' => 'Enable or disable',
        'selected_amount' => 'Locations selected: :amount',
        'enable_success' => 'Successfully enabled those locations.',
        'disable_success' => 'Successfully disabled those locations.',
        'disable_confirm' => 'Are you sure?',
        'unpin_label' => 'Unpinned',
        'pinned_label' => 'Pinned',
        'pinned_help' => 'Pinned locations are sorted first in the list.',
        'pin_or_unpin_title' => "Pin or Unpin Locations",
        'pin_or_unpin' => 'Pin or unpin',
        'pin_success' => 'Successfully pinned selected locations.',
        'unpin_success' => 'Successfully unpinned selected locations.',
        'unpin_confirm' => 'Are you sure?',
        'list_title' => 'Manage Locations',
        'delete_confirm' => 'Do you really want to delete this location?',
        'return_to_list' => 'Return to locations list',
        'default_country' => 'Default Country',
        'default_country_comment' => 'When a user does not specify their location, select a default country to use.',
        'default_state' => 'Default State',
        'default_state_comment' => 'When a user does not specify their location, select a default state to use.',
    ],
    'settings' => [
        'menu_label' => 'Geolocation settings',
        'menu_description' => 'Manage geolocation plugin.',
        'google_maps_key' => 'Google Maps API Key',
        'google_maps_key_comment' => 'If you plan on using Google Maps services, enter the API key for it here.',
        'credentials_tab' => 'Credentials',
    ],
    'state' => [
        'label' => 'State',
        'name' => 'Name',
        'select' => '-- select state --',
        'name_comment' => 'Enter the display name for this state.',
        'code' => 'Code',
        'code_comment' => 'Enter a unique code to identify this state.',
    ],
    'country' => [
        'label' => 'Country',
        'name' => 'Name',
        'select' => '-- select country --',
        'code' => 'Code',
        'code_comment' => 'Enter a unique code to identify this country.',
        'enabled' => 'Enabled',
        'pinned' => 'Pinned',
    ],
    'blog' => [
        'geolocation' => 'Territorio',
        'address' => 'Indirizzo',
        'latitude' => 'Latitudine',
        'longitude' => 'Longitudine',
        'city' => 'Città',
        'province' => 'Provincia',
        'country' => 'Codice Paese',
        'zip' => 'Cap',
    ]
];
