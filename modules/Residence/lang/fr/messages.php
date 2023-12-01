<?php

declare(strict_types=1);

return [
    'nearest' => [
        'error' => "Aucune résidence proche n'a été trouvée pour l'adresse demandée.",
        'success' => 'Une résidence a été trouvée dans la localité demandée.|:count résidences ont été trouvées dans la localité demandée.',
    ],
    'search' => [
        'error' => "Aucune résidence n'a été trouvé pour les paramètres de recherche donnés.",
        'success' => 'Une résidence a été trouvée pour les paramètres de recherche donnés.|:count résidences ont été trouvées pour les paramètres de recherche donnés.',
    ],
    'listing' => [
        'error' => "Aucune résidence n'a été trouvée.",
        'success' => 'La récupération des résidences a été effectuée avec succès.',
    ],

    'type' => [
        'listing' => 'La récupération des types résidences a été effectuée avec succès.',
    ],
    'feature' => [
        'listing' => 'La récupération des points forts résidentiels a été menée à bien.',
    ],
];
