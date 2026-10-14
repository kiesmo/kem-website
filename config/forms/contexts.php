<?php
return [
    'services' => ['office', 'window', 'general', 'carpet', 'upholstery', 'clearance', 'graffiti', 'solar', 'other'],
    'routes' => [
        '/leistungen/buero-und-gewerberaumreinigung/' => 'office',
        '/leistungen/glas-und-fensterreinigung/' => 'window',
        '/leistungen/grundreinigung/' => 'general',
        '/leistungen/teppichreinigung/' => 'carpet',
        '/leistungen/polsterreinigung/' => 'upholstery',
        '/leistungen/entruempelung/' => 'clearance',
        '/leistungen/fassadenreinigung/' => 'graffiti',
        '/leistungen/solaranlagenreinigung/' => 'solar',
    ],
    'cities' => ['bruehl' => 'Brühl', 'koeln' => 'Köln', 'bonn' => 'Bonn'],
];
