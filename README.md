# Copier et configurer l'environnement
cp .env.example .env

# Modifier .env pour configurer la base de données et Pusher

# Installer les dépendances PHP
composer install

# Générer la clé Laravel
php artisan key:generate

# Générer la clé JWT
php artisan jwt:secret

# Lancer les migrations
php artisan migrate

# Démarrer le serveur Laravel
php artisan serve