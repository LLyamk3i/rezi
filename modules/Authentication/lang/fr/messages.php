<?php

declare(strict_types=1);

return [
    'disconnected' => 'Utilisateur déconnecté.',
    'uploads' => [
        'identity-card' => [
            'success' => "Bienvenue ! Votre carte a été téléchargée avec succès. \nNous avons bien reçu votre fichier et nous le traitons actuellement. \nSi vous avez d'autres besoins ou des questions, n'hésitez pas à nous contacter. Merci pour votre confiance !",
            'errors' => [
                'upload' => "Désolé, l'upload de votre carte n'a pas réussi. Veuillez réessayer plus tard ou nous contacter pour de l'aide.",
                'save' => "Une erreur est survenue lors de la sauvegarde de votre carte. Veuillez réessayer ultérieurement ou contacter notre support technique pour obtenir de l'aide.",
            ],
        ],
    ],
    'login' => [
        'success' => "L'utilisateur s'est connecté avec succès.",
        'errors' => [
            'credentials' => "Les informations d'identification fournies sont incorrectes.",
        ],
    ],
    'profile' => [
        'update' => 'Votre profil a été mis à jour avec succès.',
    ],
    'register' => [
        'errors' => [
            'creation' => "Échec de la création d'un utilisateur. Veuillez réessayer plus tard.",
            'binding' => "Échec de l'association du rôle à l'utilisateur. Veuillez réessayer.",
            'otp' => "Échec de l'envoi d'otp",
        ],
        'success' => "L'enregistrement a été effectué avec succès. Vous pouvez maintenant vous connecter.",
        'opt' => [
            'sms' => "Votre code d'authentification est : :code. N'oubliez pas de ne pas partager ce code avec d'autres. Merci!",
            'mail' => "Veuillez vérifier votre adresse électronique à l'aide du code suivant :",
        ],
    ],
];
