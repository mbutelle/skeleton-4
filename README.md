# Website skeleton

This symfony-flex skeleton using docker to start a local environment for website.

## Prerequisites

- docker : https://www.docker.com/
- docker-compose : https://docs.docker.com/compose/
- docker-hostmanager : https://hub.docker.com/r/iamluc/docker-hostmanager/dockerfile

## Install

Rename container to avoid conflict with another project

```shell
sed -i 's/skeleton/$PROJECT_NAME/g' Makefile docker/nginx/app.conf docker-compose.yml
```

#### database

if you need database, follow the next steps :

- uncomment db section in docker-compose file
- uncomment db check on ready recipe of Makefile
- add require ymfony/orm-pack and in composer.json
- if you neded, add require-dev doctrine/doctrine-fixtures-bundle in composer.json

Finally, you have to fill env variable :

```dotenv
DATABASE_URL=mysql://root:root@db.$PROJECT_NAME:3306/db_name
```

#### start the project

To start the environment :

```shell
make start
```

#### Go to homepage

To going to the hompeage :

```shell
make open
```

#### database

To connecting to the database :

```shell
make mysql
``` 