# TAYL
PHP project check application

#Laravel <br>
php artisan key:generate<br>
php artisan migrate:refresh<br>
php artisan db:seed<br>


#Installation redis
Do this command as sudo

`cd /usr/src` <br>
`wget -c http://download.redis.io/redis-stable.tar.gz` <br>
`wget -c http://download.redis.io/redis-stable.tar.gz` <br>
`tar xvzf redis-stable.tar.gz` <br>
`cd redis-stable` <br>
`make` <br>
`make install` <br>
`utils/install_server.sh` <br>

Check if redis is install :  <br>
`redis-cli ping`   <br>
and return pong

copy .env with queue driver as redis

`php artisan cache:clear`

`php artisan vendor:publish --provider="Laravel\Horizon\HorizonServiceProvider"`


`http://127.0.0.1:8000/queues/startTestProcess?urlGit=https://github.com/Timmyfirst/TAYL-back.git`

#Code Sniffer
/* Install pear*/<br>
sudo apt-get install php-pear<br>
/*update pear*/<br>
sudo bash -c "command pear channel-update pear.php.net && command pear upgrade PEAR"<br>
/*install code sniffer with pear*/<br>
sudo pear install PHP_CodeSniffer<br>
/* Use CodeSniffer*/<br>
phpcs /yourFolder/<br>

do 'php artisan migrate' for add table : logTests

/* create directory */
mkdir storage/app/public/logProject /* For code test stored */
mkdir storage/app/public/project   /* files log stored */ 

git clone in  storage/app/public/project

push in url : http://127.0.0.1:8000/sniff

