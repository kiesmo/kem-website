<?php
$offerFields = [
    'form_type', 'website', 'cleaning_types',
    'email', 'company', 'salutation', 'first_name', 'last_name', 'phone',
    'cleaning_company', 'cleaning_street', 'cleaning_postcode', 'cleaning_city',
    'object_type', 'floor', 'furnishing',
    'type_office', 'type_window', 'type_general', 'type_carpet', 'type_upholstery', 'type_clearance', 'type_graffiti', 'type_solar', 'type_other',
    'office_area', 'office_frequency', 'office_rooms', 'office_soiling', 'office_notes',
    'general_area', 'general_reason', 'general_soiling', 'general_notes',
    'window_max_height', 'window_sashes', 'window_scope', 'window_soiling', 'window_notes',
    'carpet_loose_count', 'carpet_loose_area', 'carpet_fitted_area', 'carpet_scope', 'carpet_soiling', 'carpet_notes',
    'upholstery_two_seater', 'upholstery_three_seater', 'upholstery_corner_small', 'upholstery_corner_large',
    'upholstery_armchair', 'upholstery_stool', 'upholstery_chair_seat', 'upholstery_chair_back',
    'upholstery_custom_seats', 'upholstery_scope', 'upholstery_soiling', 'upholstery_notes',
    'graffiti_area', 'graffiti_surface', 'graffiti_scope', 'graffiti_notes',
    'solar_modules', 'solar_area', 'solar_access', 'solar_soiling', 'solar_notes',
    'clearance_area', 'clearance_volume', 'clearance_floor', 'clearance_elevator', 'clearance_scope', 'clearance_notes',
    'other_details',
    'appointment_preference', 'desired_date', 'desired_time', 'appointment_notes',
    'privacy',
];
return [
    'offer_fields' => $offerFields,
    'forms' => [
        'kontakt' => ['allowed' => ['form_type', 'website', 'name', 'email', 'phone', 'subject', 'message', 'privacy']],
        'angebot' => ['allowed' => $offerFields],
    ],
];
