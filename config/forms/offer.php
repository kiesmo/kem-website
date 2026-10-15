<?php
// Shared relevance rules. Manual city entry keeps its existing free-text rules.
return [
    'cities' => [
        'koeln' => 'Köln',
        'bruehl' => 'Brühl',
        'bonn' => 'Bonn',
    ],
    'services' => [
        'office' => [
            'label' => 'Büro- und Gewerberaumreinigung',
            'fields' => ['office_area', 'office_frequency', 'office_rooms', 'office_soiling', 'office_notes'],
            'required' => ['office_area' => 'Bitte geben Sie die ungefähre Fläche an.', 'office_frequency' => 'Bitte wählen Sie den gewünschten Turnus aus.'],
        ],
        'window' => [
            'label' => 'Glas- und Fensterreinigung',
            'fields' => ['window_max_height', 'window_sashes', 'window_scope', 'window_soiling', 'window_notes'],
            'required' => ['window_sashes' => 'Bitte geben Sie die ungefähre Fensteranzahl an.', 'window_scope' => 'Bitte wählen Sie den gewünschten Reinigungsumfang aus.'],
        ],
        'general' => [
            'label' => 'Grund- und Spezialreinigung',
            'fields' => ['general_area', 'general_reason', 'general_soiling', 'general_notes'],
            'required' => ['general_area' => 'Bitte geben Sie die ungefähre Fläche an.', 'general_reason' => 'Bitte wählen Sie den Anlass der Reinigung aus.'],
        ],
        'carpet' => [
            'label' => 'Teppichreinigung',
            'fields' => ['carpet_loose_count', 'carpet_loose_area', 'carpet_fitted_area', 'carpet_scope', 'carpet_soiling', 'carpet_notes'],
            'required' => ['carpet_scope' => 'Bitte wählen Sie den Reinigungswunsch aus.', 'carpet_soiling' => 'Bitte wählen Sie den Verschmutzungsgrad aus.'],
        ],
        'upholstery' => [
            'label' => 'Polsterreinigung',
            'fields' => ['upholstery_two_seater', 'upholstery_three_seater', 'upholstery_corner_small', 'upholstery_corner_large', 'upholstery_armchair', 'upholstery_stool', 'upholstery_chair_seat', 'upholstery_chair_back', 'upholstery_custom_seats', 'upholstery_scope', 'upholstery_soiling', 'upholstery_notes'],
            'required' => ['upholstery_scope' => 'Bitte wählen Sie den Reinigungswunsch aus.', 'upholstery_soiling' => 'Bitte wählen Sie den Verschmutzungsgrad aus.'],
        ],
        'clearance' => [
            'label' => 'Entrümpelung',
            'fields' => ['clearance_area', 'clearance_volume', 'clearance_elevator', 'clearance_scope', 'clearance_notes'],
            'required' => ['clearance_area' => 'Bitte geben Sie die ungefähre Objektfläche an.', 'clearance_scope' => 'Bitte wählen Sie den gewünschten Umfang aus.'],
        ],
        'graffiti' => [
            'label' => 'Fassaden- und Graffitireinigung',
            'fields' => ['graffiti_area', 'graffiti_surface', 'graffiti_scope', 'graffiti_notes'],
            'required' => ['graffiti_area' => 'Bitte geben Sie die ungefähre Fläche an.', 'graffiti_surface' => 'Bitte wählen Sie den Untergrund aus.'],
        ],
        'solar' => [
            'label' => 'Solar- und Photovoltaikanlagenreinigung',
            'fields' => ['solar_modules', 'solar_area', 'solar_access', 'solar_soiling', 'solar_notes'],
            'required' => ['solar_access' => 'Bitte wählen Sie die Zugänglichkeit aus.', 'solar_soiling' => 'Bitte wählen Sie den Verschmutzungsgrad aus.'],
        ],
        'other' => [
            'label' => 'Sonstige Leistung',
            'fields' => ['other_details'],
            'required' => ['other_details' => 'Bitte beschreiben Sie die gewünschte sonstige Leistung.'],
        ],
    ],
    'optional_fields' => [
        'floor' => ['office', 'window', 'general', 'carpet', 'upholstery', 'clearance', 'graffiti', 'solar', 'other'],
        'furnishing' => ['office', 'general', 'carpet', 'clearance', 'other'],
    ],
    'salutations' => ['', 'Frau', 'Herr', 'Divers', 'Keine Angabe'],
    'object_types' => ['Wohnung', 'Einfamilienhaus', 'Mehrfamilienhaus', 'Büro / Gewerbe', 'Praxis / Kanzlei', 'Gastronomie / Hotel', 'Öffentliche Einrichtung', 'Industrie / Lager', 'Sonstiges Objekt'],
    'furnishing_values' => ['', 'Unmöbliert / leer', 'Teilweise möbliert', 'Voll möbliert', 'Nicht relevant'],
    'appointment_preferences' => ['Schnellstmöglich', 'Flexibel', 'Konkreter Termin'],
    'appointment_times' => ['Vormittags', 'Nachmittags', 'Abends', 'Flexibel'],
    'count_fields' => ['upholstery_two_seater', 'upholstery_three_seater', 'upholstery_corner_small', 'upholstery_corner_large', 'upholstery_armchair', 'upholstery_stool', 'upholstery_chair_seat', 'upholstery_chair_back', 'upholstery_custom_seats'],
    'mail_fields' => [
        'office_area' => 'Büro / Gewerbe – Fläche', 'office_frequency' => 'Büro / Gewerbe – Turnus', 'office_rooms' => 'Büro / Gewerbe – Räume', 'office_soiling' => 'Büro / Gewerbe – Verschmutzung', 'office_notes' => 'Büro / Gewerbe – Hinweise',
        'window_max_height' => 'Fenster – maximale Höhe', 'window_sashes' => 'Fenster – Anzahl / Flügel', 'window_scope' => 'Fenster – Reinigungswunsch', 'window_soiling' => 'Fenster – Verschmutzung', 'window_notes' => 'Fenster – Hinweise',
        'general_area' => 'Allgemeine Reinigung – Fläche', 'general_reason' => 'Allgemeine Reinigung – Anlass', 'general_soiling' => 'Allgemeine Reinigung – Verschmutzung', 'general_notes' => 'Allgemeine Reinigung – Hinweise',
        'carpet_loose_count' => 'Teppich – lose Teppiche', 'carpet_loose_area' => 'Teppich – Fläche lose', 'carpet_fitted_area' => 'Teppich – festverlegte Fläche', 'carpet_scope' => 'Teppich – Reinigungswunsch', 'carpet_soiling' => 'Teppich – Verschmutzung', 'carpet_notes' => 'Teppich – Hinweise',
        'upholstery_two_seater' => 'Polster – 2-Sitzer', 'upholstery_three_seater' => 'Polster – 3-Sitzer', 'upholstery_corner_small' => 'Polster – Ecksofa klein', 'upholstery_corner_large' => 'Polster – Ecksofa groß', 'upholstery_armchair' => 'Polster – Sessel', 'upholstery_stool' => 'Polster – Hocker', 'upholstery_chair_seat' => 'Polster – Polsterstuhl ohne Lehne', 'upholstery_chair_back' => 'Polster – Polsterstuhl mit Lehne', 'upholstery_custom_seats' => 'Polster – Individuelles Sofa / Sitzflächen', 'upholstery_scope' => 'Polster – Reinigungswunsch', 'upholstery_soiling' => 'Polster – Verschmutzung', 'upholstery_notes' => 'Polster – Hinweise',
        'clearance_area' => 'Entrümpelung – Objektfläche', 'clearance_volume' => 'Entrümpelung – Volumen', 'clearance_elevator' => 'Entrümpelung – Aufzug', 'clearance_scope' => 'Entrümpelung – Umfang', 'clearance_notes' => 'Entrümpelung – Hinweise',
        'graffiti_area' => 'Fassade / Graffiti – Fläche', 'graffiti_surface' => 'Fassade / Graffiti – Untergrund', 'graffiti_scope' => 'Fassade / Graffiti – Reinigungswunsch', 'graffiti_notes' => 'Fassade / Graffiti – Hinweise',
        'solar_modules' => 'Solar – Module', 'solar_area' => 'Solar – Fläche', 'solar_access' => 'Solar – Zugang', 'solar_soiling' => 'Solar – Verschmutzung', 'solar_notes' => 'Solar – Hinweise',
        'other_details' => 'Sonstige Leistung',
    ],
    'area_fields' => ['office_area', 'general_area', 'carpet_loose_area', 'carpet_fitted_area', 'graffiti_area', 'solar_area', 'clearance_area'],
];
