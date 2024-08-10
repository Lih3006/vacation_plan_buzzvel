# Vacation Plan API 2024

This project is a RESTful API built using Laravel for managing holiday plans for the year 2024. The API supports CRUD operations (Create, Read, Update, Delete) on holiday plans, allowing users to easily organize and manage their vacations.

## Technologies Used

- **Laravel**: A PHP framework for building web applications.
- **Sanctum**: Laravel's lightweight API authentication package.

## Getting Started

### Prerequisites

Make sure your environment meets the following requirements:

- Linux-based operating system
- Docker and Docker Compose installed
- PHP 8.x
- Composer

### Installation

1. **Clone the Repository**

   ```bash
   git clone git@github.com:Lih3006/vacation_plan_buzzvel.git
   cd vacation_plan_buzzvel
   
2. **Set Up Environment Variables**
   
Create a copy of the .env.example file and update it with your credentials:

```bash
cp .env.example .env
# Edit the .env file with your configuration
```

3. **Start the Application with Docker Compose**
    ```bash
    docker compose up -d
    ```
4. **Install Composer Dependencies in Docker Bash and run Migrations and Seed the Database in Docker Bash**

Execute the following commands:
```bash
docker compose exec app bash
composer install
php artisan migrate && php artisan db:seed
 ```

## Testing the API

Once the setup is complete, you can test the API using the documentation or through a REST client.

For testing purposes, the following users have been created in the system. These users have different roles and can be used to test various functionalities and permissions.

### Admin User
- **Name**: admin
- **Email**: admin@admin.com
- **Password**: admin


### Manager User
- **Name**: manager
- **Email**: manager@manager.com
- **Password**: manager


### Employee User
- **Name**: employee
- **Email**: employee@employee.com
- **Password**: employee

### API Documentation
- **API Documentation**: [http://localhost:8002/api/documentation](http://localhost:8002/api/documentation)

### Database Management
- **PHPMyAdmin**: Access the database at [http://localhost:8082/](http://localhost:8082/).

### Testing with Insomnia
An Insomnia configuration file is provided in the root of the project. You can import this file to easily test the API endpoints.

- **Insomnia Configuration File**: `Insomnia_2024-08-09.json`

### API Endpoints

Below are some of the main routes/endpoints you can interact with. For a full list of routes, use the `php artisan route:list` command.

- **Swagger Documentation**: `GET api/documentation`

#### Holiday Plans:
- `GET api/holidays`
- `POST api/holidays`
- `GET api/holidays/{holiday_id}`
- `PUT/PATCH api/holidays/{holiday_id}`
- `DELETE api/holidays/{holiday_id}`

#### Holiday Plan PDFs:
- `GET api/holiday/pdf`
- `GET api/holiday/{holiday_id}/pdf`

#### Authentication:
- `POST api/login`
- `POST api/logout`
- `POST api/register`

## Future Enhancements
- Approval of holiday plans
- Role-based access control for users
- Frontend implementation



