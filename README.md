# TAYL
PHP project check application

#Laravel <br>
php artisan key:generate<br>
php artisan migrate:refresh<br>
php artisan db:seed<br>

#Code Sniffer
/* Install pear*/
sudo apt-get install php-pear
/*update pear*/
sudo bash -c "command pear channel-update pear.php.net && command pear upgrade PEAR"
/*install code sniffer with pear*/
sudo pear install PHP_CodeSniffer
/* Use CodeSniffer*/
phpcs /yourFolder/


/*Creat table*/
php artisan make:migration create_logTests_table
