# Restful API Project

This is an API project that provides endpoints for managing tasks.


## Getting Started

Follow these instructions to get the project up and running on your local machine:

Clone the repository:


git clone https://github.com/your-username/your-repository.git
Install the dependencies:
cd your-repository
composer install
Set up the database:

Create a new MySQL database.

Rename the .env.example file to .env and update the database configuration.

Run the database migrations:

php artisan migrate
Generate an application key:


php artisan key:generate
Start the development server:

php artisan serve
Now you can access the API at http://localhost:8000.

### API Endpoints

The following endpoints are available in the API:

GET /api/tasks: Get a list of all tasks.
GET /api/tasks/{id}: Get a specific task by ID.
POST /api/tasks: Create a new task.
PUT /api/tasks/{id}: Update an existing task.
DELETE /api/tasks/{id}: Delete a task.

### Dependecies

The project uses the following main dependencies:

Laravel: a PHP web framework for building the API.
MySQL: a relational database management system.
PHPUnit: a unit testing framework for testing the API endpoints.
For a full list of dependencies, please refer to the composer.json file.

## Unit Tests

You can run unit tests for each endpoint using "php artisan test" in the terminal.




