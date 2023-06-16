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

# Récupérer les noms de fichiers créés
model_file=$(file_path "app/Models" $model)
seeder_file=$(file_path "database/seeders" $model)
factory_file=$(file_path "database/factories" $model)
migration_file=$(file_path "database/migrations" $model)
resource_file=$(file_path "app/Http/Resources" $model)

echo "$resource_file"

[ -n "$model_file" ] && mkdir -p "modules/${module}/Infrastructure/Models"
[ -n "$seeder_file" ] && mkdir -p "modules/${module}/Infrastructure/Database/Seeders"
[ -n "$factory_file" ] && mkdir -p "modules/${module}/Infrastructure/Database/Factories"
[ -n "$migration_file" ] && mkdir -p "modules/${module}/Infrastructure/Database/Migrations"
[ -n "$resource_file" ] && mkdir -p "modules/${module}/Infrastructure/Resources"

# # # # Déplacer les fichiers dans le module
[ -n "$model_file" ] && phpactor class:move "$model_file" "modules/${module}/Infrastructure/Models/"
[ -n "$seeder_file" ] && phpactor class:move "$seeder_file" "modules/${module}/Infrastructure/Database/Seeders/"
[ -n "$factory_file" ] && phpactor class:move "$factory_file" "modules/${module}/Infrastructure/Database/Factories/"
[ -n "$migration_file" ] && phpactor class:move "$resource_file" "modules/${module}/Infrastructure/Resources/"
[ -n "$resource_file" ] && mv "$migration_file" "modules/${module}/Infrastructure/Database/Migrations"

# # # Confirmer l'achèvement
echo "fichiers déplacés: $model_file $seeder_file $factory_file $migration_file $resource_file"
