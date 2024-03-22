# Local Environment
> Using Docker for our local environment

## Requirements

1. Having [Docker installed](https://www.docker.com/products/docker-desktop) (you will need to create a Hub account)
2. Having [Git installed](https://git-scm.com/downloads)

## Installation

1. Clone this repository into your projects folder using the `git clone` command.

## Instructions

1. After cloning the project, open your terminal and access the root folder using the `cd /path/to/the/folder` command.
2. Edit the `.env` file with the desired information for your project.
3. To run the containers, execute the command `docker compose up -d` in your terminal.

**Note:** The first time you run this command it will take some time because it will download all the required images from the Hub.

At this point, if you execute the command `docker compose ps` you should see a total of 6 containers running (this table is using the default ports of each service. Those values should be configured in the `.env` file):

```
NAME                                                   COMMAND                  SERVICE             STATUS              PORTS
----------------------------------------------------------------------------------------------------------------------------------------------------
{PROJECT_PREFIX}-local-environment_app            "docker-php-entrypoi..."   app                 running             9000/tcp
{PROJECT_PREFIX}-local-environment_db             "docker-entrypoint.s..."   mysql               running             0.0.0.0:{MYSQL_PORT}->3306/tcp
{PROJECT_PREFIX}-local-environment_nginx          "/docker-entrypoint...."   nginx               running             0.0.0.0:{NGINX_PORT}->80/tcp
{PROJECT_PREFIX}-local-environment_phpmyadmin     "/docker-entrypoint...."   phpmyadmin          running             0.0.0.0:{PHPMYADMIN_PORT}->80/tcp
```

At this point, you should be able to access the application by visiting the following address in your browser [http://localhost:{NGINX_PORT}/](http://localhost:8080/).

### Databases

There are multiple ways to access the databases inside the docker container. In this case we are going to cover two options:

1. Manually accessing the container
2. Using your browser

#### [MySQL] Manually

In order to manually access the database, we need the name of the database container. Use `docker compose ps`. The name should be something like `{PROJECT_PREFIX}-local-environment_db`.

Now, we are going to ssh into the container using the command `docker exec -it container_id bash`. At this point, you should be able to notice that the terminal prompt has changed because now you are inside of the container.

To access the database, execute the command `mysql -u root -p`. (The username and password are specified in the .env file.)

#### [MySQL] Browser

To access to the admin page, visit the URL [http://localhost:{PHPMYADMIN_PORT}/](http://localhost:8081/) in your browser.

### Shared files and directories

1. In the root of the environment folder, you'll find a `.env` file with some useful information like the DB usernames and passwords used to create the environment by default (It should be initially modified with the information of your project).
2. All the content of the website should be placed inside a shared directory called `./www`. The public content should be placed in `./www/public`.
3. Inside the folder `./docker-compose` you'll find some interesting folders:
   1. The `mysql` folder can be used to load a database when you run the `docker compose up -d` command. If you place a .sql file inside this folder, it'll be imported to the MySQL database automatically.
   2. The `nginx` folder contains a file with the custom configuration of the Nginx server (It shouldn't be modified unless you know what are you doing).
   3. The `php` folder contains modular configurations for certain aspects of PHP, including the limits on uploads (It shouldn't be modified unless you know what are you doing).
   4. The `xdebug` folder contains the configuration for PHP's debugging system (It shouldn't be modified unless you know what are you doing).

### Composer

If you need to run composer to manage/install/update your project dependencies, open your terminal and execute the command `docker compose exec app composer {command}` where `{command}` is the action that you want to perform (for example install/update/...).

### PHP Extensions

Those PHP extensions are included in the environment:

   - pdo_mysql
   - mbstring
   - exif
   - pcntl
   - bcmath
   - gd
   - zip
   - intl
   - mysqli
   - xdebug
