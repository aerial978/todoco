# Todo&Co

The ToDo & Co project is a daily task management application developed using the Symfony PHP framework. 

Project 8 of the Openclassrooms training "PHP/Symfony Application Developer".

The Todo & Co company recently secured funding to continue developing the app. My role as an experienced developer is to improve the overall quality of the application.

## 🔗 Links
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/5405f8abe3c541698154ad31cc899b40)](https://app.codacy.com/gh/aerial978/todoco/dashboard?utm_source=gh&utm_medium=referral&utm_content=&utm_campaign=Badge_grade)

## Tech Stack

* Symfony 6.3

## Launch

* Wampserver 64bit 3.2.6
* MySQL 5.7.36
* github/aerial978

## Set Up

* Symfony, Faker PHP

```bash
    composer create-project symfony/skeleton
    composer require api
    composer require fakerphp/faker
```

* Git clone the project

```bash
    https://github.com/aerial978/todoco.git
```

* Database

Update .env file your database configuration

```bash
    DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name"
```

* Create database

```bash
    php bin/console doctrine:database:create
```

* Create an entity

```bash
    php bin/console --dev symfony/maker-bundle
    php bin/console make:entity
```

* Create database structure

```bash
    php bin/console make:migration
```

* Database up-to-date

```bash
    php bin/console doctrine:migrations:migrate
```

* Insert data fixtures

```bash
    php bin/console doctrine:fixtures:load
```

* Code coverage report

```bash
    http://localhost/todoco/tests/coverage/index.html
```

