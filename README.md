# Translation-service

The Translation-service is a backend service designed to manage translations for multiple locales. It provides a RESTful interface to interact with translation data, allowing you to create, update, retrieve, search, and list translations efficiently. This API is ideal for applications that need dynamic and localized content management across different languages and regions.

Key features of the API include:
- Support for various locales, enabling easy translation management for different regions.
- CRUD (Create, Read, Update, Delete) operations for managing translation entries.
- Search functionality to quickly retrieve translations based on criteria.
- Seamless integration with your application, allowing you to fetch and manage translations in real-time.

Whether you're building a multilingual website, app, or any system that requires localization, the Translation-service serves as a flexible solution to handle your translation needs.


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

Generate Application Key
To generate the application key, run the following command:

php artisan key:generate

Run Migrations and Seed the Database
php artisan migrate:fresh --seed

php artisan serve

Running Tests
To run the tests, use the following command:

php artisan test

to see swagger documentation
http://127.0.0.1:8000/docs