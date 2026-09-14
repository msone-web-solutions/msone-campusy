#!/usr/bin/env bash
# Deploy auf school.campusy.de – lokal ausführen: ./deploy.sh
set -e
ssh root@178.104.124.100 'set -e; cd /var/www/campusy
  sudo -u deploy php artisan down --retry=10 || true
  sudo -u deploy git pull -q
  sudo -u deploy -H composer install --no-dev --optimize-autoloader --no-interaction --quiet
  sudo -u deploy npm ci --silent && sudo -u deploy npm run build >/dev/null
  sudo -u deploy php artisan migrate --force -q
  sudo -u deploy php artisan content:sync -q
  sudo -u deploy php artisan optimize -q
  sudo -u deploy php artisan up
  echo "deployed $(sudo -u deploy git rev-parse --short HEAD)"'
