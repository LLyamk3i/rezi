# Tasks

## Global

- [x] Ajouter une command app:setup pour migrate and seed elements.
- [x] Créé une class commande app:setup.
- [] Trouver comment rendre la monnaie "Franc CFA" réutilisable.
- [+] Régler le bug se suppression de final par ./bin/pint

## Module Residence

- [x] Ajouter la recherche de résidence.
- [x] Demander a chatgpt comment faire une recherche avec: le nom de la vile, les dates d'enté et sorti de la réservation.
- [x] Ajouter la vésication de disponibilité d'une résidence.

## Module Payment

- [] Ajouter le paiement de sa réservation.

## Module Reservations

- [] Ajouter l'annulation de réservation.
- [] Notifiez le propriétaire d'une nouvelle réservation.

## Module Admin

- [] Ajouter les widgets cotés admin, provider.
- [x] Ajouter ResidenceResource
- [x] Ajouter ReservationResource
- [x] Ajouter TypeResource
- [x] Ajouter FeatureResource
- [x] Ajouter AdminResource
- [x] Ajouter ClientResource
- [x] Ajouter la traduction dans le fichier fr.json
- [x] Créer un ... contenant retournant [Hidden, FileUpload].


### ResidenceResource

- [x] Trouver où mettre la clé "auth".
- [x] Empêcher un provider de voir, de modifier ou de supprimer les résidences des autres.
- [x] Permettre a un admin de validé ou de rejeté une résidence fournie par un provider.
- [x] Ajouter la monnaie "Franc CFA" sur la colonne de type prix.
- [x] Ajouter la monnaie "Franc CFA" sur les champs de type prix.
- [x] Ajouter sortable sur name et rent.
- [x] Ajouter searchable sur name et rent.
- [x] Ajouter poster et galerie.
- [x] Ajouter une couverture d'image dans le listage des résidences.
- [x] Ajouter un style css pour mettre la première lettre des labels, les titles nécessaires en majuscule.
- [x] Ajouter les champs:
  - [x] Type de résidence.
  - [x] Nombre de chambres.
  - [x] les points forts d'une résidence.
- [x] Ajouter le bouton plus pour mettre au Providers d'ajouter un point fort s'il n'existe pas par default.
- [x] Fixer la suppression de la map.
- [x] Changer l'icon.
- [x] Refonte des label en utilisant la fonction "translateLabel".
- [x] Créé des enums pour la réutilisation:
  - [x] les labels. (check les enums)
  - [x] les dossiers.
- [x] Vérifier la création
- [] Ajouter une page de "viewing records" pour permettre à l'admin de voir la résidence.
- [] Ajouter un BULK Action pour ajouter plusieurs  images

### ClientResource

- [] Blocker l’accès au provider.
- [x] Changer l'icon.

### AdminResource

- [] restreindre seulement au panel owner
- [x] Changer l'icon.

## Module Authentication

- [] Ajouter les champs:
  - [] carte d'identité (rector, verso).
- [] Vérifier le compte avec un code OPT.

## Seeding

- [x] trouver comment injecter les donner appropriés dans la méthode run de chaque seeder.
- [x] trouver comment rendre les positions random
- [x] seeder la table residences
  - [x] la colonne user_id (le propriétaire)
  - [x] le colonne type_id
  - [x] les point forts (features) dans la table feature_residence
- [x] seeder la table reservation
  - [x] seule les residence visible peuvent être réservées
- [x] ajouter use \Illuminate\Database\Console\Seeds\WithoutModelEvents; dans toutes les seeders
