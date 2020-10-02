Note:

Commands important for this project

composer install or update

php artisan migrate

If supervisor is installed Do

php artisan queue:restart after editing a Job. 

ALso do  

tail -f ../queue_log/worker.log ( this is on aws server ) to monitor que processes


Test session without logging out

test from pbdigital.com.au