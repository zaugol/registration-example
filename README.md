# User Registration System

This is a simple MVC-based PHP user registration system with email verification. It includes features such as bcrypt password hashing and PHPMailer integration for sending verification emails.

## Features

- User registration with name, email, and password
- Password hashing using bcrypt
- Email verification using PHPMailer
- MVC architecture
- Unit tests using PHPUnit

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Composer

## Installation

1. Clone the repository:
   ```
   git clone https://github.com/zaugol/registration-example.git
   cd registration-example
   ```

2. Install dependencies:
   ```
   composer install
   ```

3. Set up the database:
    - Create a new MySQL database
    - Import the database structure from `database/structure.sql`
   ```
   mysql -u your_username -p your_database_name < database/structure.sql
   ```

4. Configure the application:
    - Copy `config/config.example.php` to `config/config.php`
    - Edit `config/config.php` and update the database and SMTP settings

## Usage

1. Start the PHP built-in server (for development):
   ```
   php -S localhost:8000 -t public
   ```

2. Open your web browser and navigate to `http://localhost:8000`

3. Use the registration form to create a new user account

4. Check your email for the verification link

## Running Tests

To run the unit tests, use the following command:

```
./vendor/bin/phpunit
```

## Project Structure

```
project_root/
├── config/
│   └── config.php
├── database/
│   └── structure.sql
├── src/
│   ├── Model/
│   │   └── User.php
│   ├── Controller/
│   │   └── UserController.php
│   └── View/
│       └── register.php
├── public/
│   ├── index.php
│   ├── process_registration.php
│   └── verify.php
├── tests/
│   ├── Model/
│   │   └── UserTest.php
│   └── Controller/
│       └── UserControllerTest.php
├── vendor/
├── composer.json
├── phpunit.xml
└── README.md
```
