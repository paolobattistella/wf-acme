
# Team Management Application

This repository contains the source code of an application platform built with framework `Symfony 5.4`.
This application allows to manage a developers team.

## System requirements

PrestaShop needs the following server configuration in order to run:
- **System**: Unix, Linux or Windows.
- **PHP**: PHP 7.4 or later.
- **SQLite**.

## Setup

1. `composer install`
2. `bin/console doctrine:database:create` to create the database `acme.db` into folder `/var/`. 
3. `bin/console doctrine:fixtures:load --group=init` to init application database.

## Demo

`bin/console doctrine:fixtures:load --group=demo` to write demo data into application database.

## Console commands

All commands require the parameter `id_user` (`u`).

This parameter is the user that executes the command. It will be used to check the permissions according the role of the user.

Only the commands `app:user:list` and `app:user:view` haven't required the parameter `id_user`.

### app:permission:list

To list all permissions.

### app:role:list

To list all roles.

### app:team:list

To list all teams.

### app:team:view <id>

To show details of given team.

### app:user:list

To list all users.

### app:user:new

To create a new user.

### app:user:view <id>

To show details of given user.

### app:user:assign-team <id>

To assign a team to given user.

### app:work-log:list

To list all work logs.

### app:work:in

To log the start of work day.

### app:work:out

To log the end of work day.

## Contributing

Paolo Battistella (paolo.battistella@gmail.com)
