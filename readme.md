## Requirements
- PHP >= 7.2.5
- MySQL

## Setup
1. Clone the repository.
1. Go to the main path `cd src`.
1. Install project dependencies (make sure you have installed composer on your machine) `composer install`.
1. Create .env file from .env.example and set database configuration in your .env file.
1. Run this command for creating tables and insert default data in tables `php artisan migrate:fresh --seed`.
1. Run the server by this command (make sure your 8000 port is free in your machine) `php artisan serve`.
1. Go to this path on your browser `http://127.0.0.1:8000`.

## How to run tests
1. Go to the main path `cd src`.
1. Run this command for running tests `php artisan dusk`.

## How to use the project
After the project is installed successfully on your machine on the main route you can find the related form and table of books and work with the project.
