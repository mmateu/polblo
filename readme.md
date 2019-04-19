Aby zainstalować, potrzebny jest vagrant box o nazwie laravel/homestead, lub alternatywnie: 

INSTALACJA MANUALNA: 

mysql (Mariadb 10.3.12)+
composer 1.8.0+
php 7.2.11+
    -OpenSSL PHP Extension
    -PDO PHP Extension
    -Mbstring PHP Extension
    -Tokenizer PHP Extension
    -XML PHP Extension
    -Ctype PHP Extension
    -JSON PHP Extension
    -BCMath PHP Extension
npm 6.4.1+
nginx 1.15.5+
ubuntu 18.04.1+

*INSTALOWANIE*

*Wejść do root folderu projektu

cp .env.example .env 

composer install

php artisan key:generate

mysql -u root

W konsoli db: 
    CREATE DATABASE homestead; 
    CREATE USER homestead@localhost IDENTIFIED BY secret;
    GRANT ALL PRIVILEGES ON homestead.* TO homestead@localhost; 

php artisan migrate

php artisan db:seed

npm install 

npm run dev 
 
php artisan serve 

*TESTY*

phpunit