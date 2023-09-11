#!/bin/bash

# Vérifier que deux arguments ont été fournis
if [ $# -ne 2 ]; then
  echo "Usage: $0 [nom du modèle] [nom du module]"
  exit 1
fi

file_path() {
  folder="$1"
  name="$2"

  if [ ! -d "$folder" ]; then
    echo ""
    return
  fi

  find "$folder" -type f -iname "*$name*" -print
}

# Variables
model=$1
module=$2

# Récupérer les noms de fichiers créés
notification_file=$(file_path "app/Notifications" $model)
model_file=$(file_path "app/Models" $model)
seeder_file=$(file_path "database/seeders" $model)
factory_file=$(file_path "database/factories" $model)
migration_file=$(file_path "database/migrations" $model)
resource_file=$(file_path "app/Http/Resources" $model)
controller_file=$(file_path "app/Http/Controllers" $model)
policy_file=$(file_path "app/Policies" $model)

echo "$resource_file"

[ -n "$notification_file" ] && mkdir -p "modules/${module}/Infrastructure/Notifications"
[ -n "$model_file" ] && mkdir -p "modules/${module}/Infrastructure/Models"
[ -n "$seeder_file" ] && mkdir -p "modules/${module}/Infrastructure/Database/Seeders"
[ -n "$factory_file" ] && mkdir -p "modules/${module}/Infrastructure/Database/Factories"
[ -n "$migration_file" ] && mkdir -p "modules/${module}/Infrastructure/Database/Migrations"
[ -n "$resource_file" ] && mkdir -p "modules/${module}/Infrastructure/Resources"
[ -n "$controller_file" ] && mkdir -p "modules/${module}/Infrastructure/Http/Controllers"
[ -n "$policy_file" ] && mkdir -p "modules/${module}/Infrastructure/Policies"

# # # # Déplacer les fichiers dans le module
[ -n "$notification_file" ] && phpactor class:move "$notification_file" "modules/${module}/Infrastructure/Notifications/"
[ -n "$model_file" ] && phpactor class:move "$model_file" "modules/${module}/Infrastructure/Models/"
[ -n "$seeder_file" ] && phpactor class:move "$seeder_file" "modules/${module}/Infrastructure/Database/Seeders/"
[ -n "$factory_file" ] && phpactor class:move "$factory_file" "modules/${module}/Infrastructure/Database/Factories/"
[ -n "$resource_file" ] && phpactor class:move "$resource_file" "modules/${module}/Infrastructure/Resources/"
[ -n "$controller_file" ] && phpactor class:move "$controller_file" "modules/${module}/Infrastructure/Http/Controllers/"
[ -n "$migration_file" ] && mv "$migration_file" "modules/${module}/Infrastructure/Database/Migrations/"
[ -n "$policy_file" ] && phpactor class:move "$policy_file" "modules/${module}/Infrastructure/Policies/"

# # # Confirmer l'achèvement
echo "fichiers déplacés: "$notification_file $model_file $seeder_file $factory_file $resource_file $controller_file $migration_file $policy_file"
