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

    'favorite' => [
        'listing' => 'Voici la liste de vos résidences favoris.',
        'add' => 'La résidence a été ajoutée à votre liste de favoris avec succès.',
        'remove' => [
            'success' => 'La résidence #:id a été retirée de votre liste de favoris avec succès.',
            'error' => "La résidence #:id n'existe pas dans votre liste de favoris.",
        ],
    ],

    'view' => [
        'add' => [
            'success' => 'La résidence a été marquée comme vue par :id avec succès.',
            'error' => 'La résidence a été déjà marquée comme vue par :id.',
        ],
    ],

    'rating' => [
        'add' => [
            'success' => 'La résidence a été notée par :id avec succès.',
            'error' => 'La résidence a été déjà notée par :id.',
        ],
    ],
    'details' => [
        'success' => 'Les détails de la résidence :id ont été récupérés avec succès.',
        'error' => 'Une erreur est survenue lors de la récupération des détails de la résidence :id.',
    ],
];
