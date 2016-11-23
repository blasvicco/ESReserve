# ESReserve
This is a complete example of a Symfony2.8 project configured as a Rest API.
The frontend is separated from the Symfony framework and was developed using ReactJS.
The user can log in to the system in order to search for events on a map. They can select the event to see the details and book a stand.
The application will show the stands on a floor map. The user can see the details of the company that booked a stand or can select an available stand to book.
In order to book a stand the user must complete the company registration form.


##### Live project:
http://www.esreserve.tk/index.html

##### Some of the technologies used in this project are:
  - Symfony 2.8 (http://symfony.com/)
  - MySql/MariaDb (https://mariadb.org/)
  - ReactJS (https://facebook.github.io/react/)

##### Some external libs:
  - FOSUserBundle (https://github.com/FriendsOfSymfony/FOSUserBundle)
  - FOSRestBundle (https://github.com/FriendsOfSymfony/FOSRestBundle)
  - FOSOAuthServerBundle (https://github.com/FriendsOfSymfony/FOSOAuthServerBundle/)
  - JQuery (https://jquery.com/)
  - Google Map Api (https://developers.google.com/maps/documentation/javascript/)
  - Bootstrap 3.0 (http://getbootstrap.com/)

### Installation
```sh
$ git clone [git-repo-url] folder-name
$ cd folder-name
```

Create the DB and import the structure with docs/schema.sql

Add also data with docs/data.sql


Use the config file tempalte (parameters.yml.dist) to create the config file (parameters.yml).

Execute composer install

```sh
$ composer install -vvv
```

Check if you have the app/bootstrap.php.cache if not:

```sh
$php vendor/sensio/distribution-bundle/Resources/bin/build_bootstrap.php
```

Give permission to the var folder for Symfony:
```sh
$ chmod 0777 app/cache/ -R
$ chmod 0777 var/logs/ -R
```

### Run PHPUnit test
```sh
$ cd cloned-folder-name
$ ./vendor/phpunit/phpunit/phpunit -c app/ tests/
```
