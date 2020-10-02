web: vendor/bin/heroku-php-apache2 public/
worker: php artisan queue:restart && php artisan queue:work
supervisor: supervisord -c supervisor.conf -n
supervisorctl: supervisorctl reread && supervisorctl update && supervisorctl start laravel-worker:*
