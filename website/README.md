# Installation instructions.

Please execute the following commands to set-up your Symfony instance.

## 0. Install the required packets on your server (describe here for Debian 9).

Install Neo4j.
```
echo "deb http://httpredir.debian.org/debian jessie-backports main" | sudo tee -a /etc/apt/sources.list.d/jessie-backports.list
sudo apt-get update
sudo apt-get install neo4j
```

Install PHP (we recommand the 7.2).
```
sudo apt-get install apt-transport-https lsb-release ca-certificates
sudo wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | sudo tee /etc/apt/sources.list.d/php.list
sudo apt-get update
sudo apt-get install php7.2-cli php7.2-curl php7.2-xml php7.2-json
```

Install MySQL.
```
apt install mysql-server
```

## 1. Change the MySQL and Neo4j database credentials in Symfony.

Inside `./website/app/config/parameters.yml` for the MySQL database.

Inside `./website/src/ApiBundle/DefaultController.php`, inside the `initNeo4j()` method.

Inside `./website/src/AppBundle/RegisterController.php` at line `37` and `38`.

Change the API key under `./website/src/ApiBundle/DefaultController.php` at the top of the file (`private $_api_key`).

## 2. Install composer.

Go to the `/website` directory.

```
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```

## 3. Install the dependencies of the website.

```
./composer.phar install
php bin/console doctrine:database:create
```

## 4. Start the Symfony server.

```
php bin/console server:start

# OR

php bin/console server:start {your_ip}:8000

```
