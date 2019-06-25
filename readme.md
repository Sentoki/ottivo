# Vacation utility

[![Build Status](https://travis-ci.com/Sentoki/ottivo.svg?branch=master)](https://travis-ci.com/Sentoki/ottivo)

Coding task

## Installation

```bash
$ git clone https://github.com/Sentoki/ottivo.git
$ cd ottivo
$ composer install --no-dev

```

## Running tests
 
Phpunit tests

```bash
$ composer install
$ ./vendor/bin/phpunit

```
## Checking tests quality

Project using mutation testing, so infection [package required](https://infection.github.io/guide/installation.html#Composer).

```bash
$ infection

```

## Creating dummy database

This command creating 1000 of workers with different parameters.

```bash
$ php console.php  app:create-database

```

## Generating vacations report

```bash
$ php console.php app:vacation-days 2019

```

