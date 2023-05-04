#!/bin/bash

# Vérifier que deux arguments ont été fournis
if [ $# -ne 2 ]; then
  echo "Usage: $0 [nom du modèle] [nom du module]"
  exit 1
fi

function file_path() {
  folder="$1"
  name="$2"
  find "$folder" -type f -iname "*$name*" -print
}

# Variables
model=$1
module=$2

# Créer le modèle
php artisan make:model $model -sf

# Récupérer les noms de fichiers créés
model_file=$(file_path "app/Models" $model)
seeder_file=$(file_path "database/seeders" $model)
factory_file=$(file_path "database/factories" $model)
migration_file=$(file_path "database/migrations" $model)

mkdir -p "modules/${module}/Infrastructure/Models"
mkdir -p "modules/${module}/Infrastructure/Database/Seeders"
mkdir -p "modules/${module}/Infrastructure/Database/Factories"
mkdir -p "modules/${module}/Infrastructure/Database/Migrations"

# # # Déplacer les fichiers dans le module
phpactor class:move "$model_file" "modules/${module}/Infrastructure/Models/"
phpactor class:move "$seeder_file" "modules/${module}/Infrastructure/Database/Seeders/"
phpactor class:move "$factory_file" "modules/${module}/Infrastructure/Database/Factories/"
mv "$migration_file" "modules/${module}/Infrastructure/Database/Migrations"

# # # Confirmer l'achèvement
echo "Le modèle, le seeder et le factory ont été déplacés avec succès dans le module."
