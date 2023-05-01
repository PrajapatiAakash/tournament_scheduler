<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Tournament Scheduler

Tournament Scheduler is a web application for generate tournament matches based on total no of teams into the group. In this project we first ask for enter the tournament name and total no of teams in on group and based on this we have schedule the matches. Also, we have on assumption like in group b we have added on extra team and that team is directly qualified for the quarter final matches.

# Getting started

## Installation

Clone the repository

    git clone git@github.com:PrajapatiAakash/tournament_scheduler.git

Switch to the repo folder

    cd tournament_scheduler

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Install all the dependencies using npm

    npm install

Build CSS and JS assets

    npm run build

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

**TL;DR command list**

    git clone git@github.com:PrajapatiAakash/tournament_scheduler.git
    cd tournament_scheduler
    composer install
    cp .env.example .env
    php artisan key:generate
    php artisan migrate
    npm install
    npm run build
    
**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan migrate
    php artisan serve

## Environment variables

- `.env` - Environment variables can be set in this file

***Note*** : You can quickly set the database information and other variables in this file and have the application fully working.

## License

The Tournament Scheduler is open-sourced project licensed under the [MIT license](https://opensource.org/licenses/MIT).
