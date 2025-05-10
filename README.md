# Translation-service

This is a RESTful API for managing translations. The API provides endpoints to list, create, update, retrieve, and search translations in various locales.

## Table of Contents
- [Installation](#installation)
  - [Set Up Project](#set-up-project)
  - [Run Migrations](#run-migrations)
- [Running the Project](#running-the-project)
  - [PHP Artisan Serve](#php-artisan-serve)
  - [Running Tests](#running-tests)
- [Swagger Documentation](#swagger-documentation)
- [API Documentation](#api-documentation)
- [Error Handling](#error-handling)
- [License](#license)

## Installation

Follow these steps to set up the project locally:

### 1. Clone the Repository
bash
git clone https://github.com/yourusername/translation-api.git
cd translation-api

Install Dependencies
composer install

Make a copy of the .env.example file:
cp .env.example .env

Run Migrations and Seed the Database
php artisan migrate:fresh --seed

php artisan serve

Running Tests
To run the tests, use the following command:

php artisan test

http://127.0.0.1:8000/docs