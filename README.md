# Project Setup and Usage

Welcome to the project! This project include 5 endpoints connected with book. Also we have swagger. Follow these steps to set up the development environment, run migrations, and execute tests.

## Table of Contents

1. [Build Docker Container](#build-docker-container)
2. [Install Composer Dependencies](#install-composer-dependencies)
3. [Run Migrations](#run-migrations)
4. [Create Test Database](#create-test-database)
5. [Create Database Schema](#create-database-schema)
6. [Run Tests](#run-tests)
7. [Access API Documentation](#access-api-documentation)

## Build Docker Container

Build and start the Docker containers:

```bash
docker compose up -d --build
```

## Install Composer Dependencies

Install Composer:

```bash
docker exec php composer install
```

## Run Migrations

```bash
docker exec php bin/console do:mi:mi
```

## Create test db

```bash
docker exec php symfony console doctrine:database:create --env=test
```

## Create scheme

```bash
docker exec php symfony console doctrine:schema:create --env=test
```

## Run tests

```bash
docker exec php ./vendor/bin/phpunit
```

## You can visit swagger and try endpoints on this site

http://localhost:8080/api/doc

