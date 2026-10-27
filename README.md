# Hot Wheels Treasure Hunt Market Tracker

A web application for tracking **Hot Wheels Treasure Hunt (TH)** and **Super Treasure Hunt (STH)** vehicles, including collector accounts, saved favorites, vehicle information, and future market price tracking.

This project is being developed as a capstone project using **Laravel**, **Livewire**, and **Fortify**.

---

## Project Overview

The Hot Wheels Treasure Hunt Market Tracker is designed to help Hot Wheels collectors search, organize, and eventually track the market value of Treasure Hunt and Super Treasure Hunt vehicles.

Collectors will be able to:

* Create and manage an account
* Search Hot Wheels vehicles
* View vehicle information
* Save vehicles to a personal favorites list
* View historical market pricing
* Filter vehicles by year, series, model, and category

Administrators will have additional permissions to manage application data.

---

## Technology Stack

* **PHP 8.5**
* **Laravel 13**
* **Livewire**
* **Laravel Fortify**
* **Blade**
* **SQLite / MySQL**
* **HTML**
* **CSS**
* **JavaScript**
* **Git / GitHub**
* **Postman**
* **Newman**
* **PHPUnit / Laravel Testing**

---

# Current Development Status

## Milestone 1

Milestone 1 focuses on implementing the foundation of the application, including authentication, collector account management, favorites, administrator authorization, and testing.

### Completed Features

#### User Registration

Collectors can create an account using:

* Username
* Email address
* Password
* Password confirmation

New users automatically receive the role:

```text
collector
```

User accounts support the following roles:

```text
collector
administrator
```

---

#### User Authentication

The application currently supports:

* Registration
* Login
* Logout
* Password reset
* Email verification
* Password confirmation

Laravel Fortify is used to manage authentication functionality.

---

#### User Roles

A `role` field has been added to the `users` table.

Available roles currently include:

```text
collector
administrator
```

Newly registered users receive the `collector` role by default.

---

#### Collector Profile Management

Collectors can update their profile information.

Current profile fields include:

* Username
* Email address

When a collector changes their email address, the application resets the email verification status so the new email address can be verified.

The application also keeps the user's `name` field synchronized with the username.

---

#### Password Management

Collectors can securely update their password.

Password validation uses Laravel's default password requirements.

The password system requires:

* Current password validation
* New password
* Password confirmation

---

## Saved Favorites

Collectors can save Hot Wheels vehicles to their profile.

A many-to-many relationship is used between:

```text
users
cars
```

through a favorites pivot table.

Example vehicles currently used during development include:

* Bone Shaker
* Twin Mill
* Batmobile
* Porsche 935
* Mazda 787B

A collector can have multiple favorite vehicles, and a vehicle can be favorited by multiple collectors.

---

## Administrator Access

Administrator functionality is protected using custom middleware.

The middleware verifies that the authenticated user has the:

```text
administrator
```

role.

Non-administrator users attempting to access administrator routes receive:

```text
403 Forbidden
```

This prevents collectors from accessing protected administrative functionality.

---

# Testing

Testing is an important part of the project and is being implemented alongside application development.

## Laravel Automated Tests

Tests have been created for:

* User registration
* Login
* Logout
* Password validation
* Email validation
* Password management
* Profile management
* Role assignment
* Authentication
* Email verification
* Password confirmation
* Password reset
* Collector favorites
* Administrator authorization

Authentication tests are currently passing.

---

## API Testing

Postman is being used to test application endpoints.

The project contains:

```text
tests/Postman/
```

Current Postman files include:

```text
Hot Wheels Market Tracker.postman_collection.json
Hot Wheels Local.postman_environment.json
```

Milestone 1 API tests can also be executed using **Newman**.

Example:

```bash
newman run "tests/Postman/Hot Wheels Market Tracker - Milestone 1.postman_collection.json" \
-e "tests/Postman/Hot Wheels Local.postman_environment.json"
```

The Milestone 1 Postman/Newman tests are currently passing.

---

## Front-End Testing

Milestone 1 also includes front-end testing for important collector workflows.

Testing covers functionality such as:

* Registration
* Login
* Profile management
* Password management
* Favorites
* Protected administrator functionality

---

# Current Git Milestone History

The project was developed incrementally using separate commits for major features and tests.

Recent Milestone 1 development includes:

```text
test: add milestone 1 frontend tests
test: add milestone 1 API tests
feat: restrict administrator functionality
feat: add collector favorites list
test: verify collector password management
feat: add collector profile management
test: add collector authentication validation tests
feat: customize collector registration
feat: add username and user roles
chore: initialize Laravel Livewire project
```

Development for Milestone 1 is being maintained on:

```text
milestone-1
```

---

# Installation

## 1. Clone the Repository

```bash
git clone https://github.com/Rishyu/Hot-Wheels-Treasure-Hunt-Market-Tracker.git
```

Move into the project directory:

```bash
cd Hot-Wheels-Treasure-Hunt-Market-Tracker
```

---

## 2. Install PHP Dependencies

```bash
composer install
```

---

## 3. Install JavaScript Dependencies

```bash
npm install
```

---

## 4. Create Environment File

```bash
cp .env.example .env
```

---

## 5. Generate Application Key

```bash
php artisan key:generate
```

---

## 6. Configure Database

Update the database configuration inside:

```text
.env
```

Then run:

```bash
php artisan migrate
```

Optional development data can be generated using:

```bash
php artisan db:seed
```

---

## 7. Start the Application

Start Laravel:

```bash
php artisan serve
```

Start the frontend development server:

```bash
npm run dev
```

The application will normally be available at:

```text
http://127.0.0.1:8000
```

---

# Running Tests

Run Laravel tests:

```bash
php artisan test
```

Run a specific test:

```bash
php artisan test --filter=RegistrationTest
```

Run Postman/Newman tests:

```bash
newman run "tests/Postman/Hot Wheels Market Tracker - Milestone 1.postman_collection.json" \
-e "tests/Postman/Hot Wheels Local.postman_environment.json"
```

---

# Project Structure

Important project areas include:

```text
app/
├── Actions/
├── Http/
│   └── Middleware/
├── Livewire/
├── Models/
│   ├── User.php
│   └── Car.php

database/
├── factories/
├── migrations/
└── seeders/

resources/
├── css/
├── js/
└── views/

tests/
├── Feature/
├── Unit/
└── Postman/
```

---

# Current Models

## User

The `User` model currently supports:

* Username
* Email
* Password
* Role
* Email verification
* Password management
* Favorites relationship
* Two-factor authentication support
* Passkey authentication support

---

## Car

The `Car` model represents Hot Wheels vehicles.

Development vehicle data currently includes fields such as:

* Model name
* Series
* Year
* Category

Future versions will expand the car model to support market price information and price history.

---

# Planned Features

Future development will include:

* Hot Wheels vehicle search
* Search by model
* Search by year
* Search by series
* Filter by Treasure Hunt category
* TH and STH identification
* Vehicle detail pages
* Market price tracking
* Historical price data
* Price history charts
* Collector dashboard
* Improved favorites management
* Administrator dashboard
* Vehicle management
* Market data management
* Responsive mobile interface

---

# User Roles

| Role          | Access                                                         |
| ------------- | -------------------------------------------------------------- |
| Collector     | Profile, favorites, vehicle browsing and collector features    |
| Administrator | Collector features plus protected administrative functionality |

---

# Milestone 1 Status

| Feature                  | Status     |
| ------------------------ | ---------- |
| Registration             | ✅ Complete |
| Login                    | ✅ Complete |
| Logout                   | ✅ Complete |
| Password Reset           | ✅ Complete |
| Email Verification       | ✅ Complete |
| Username Support         | ✅ Complete |
| User Roles               | ✅ Complete |
| Collector Profile        | ✅ Complete |
| Password Management      | ✅ Complete |
| Saved Favorites          | ✅ Complete |
| Administrator Protection | ✅ Complete |
| Laravel Automated Tests  | ✅ Complete |
| Postman API Tests        | ✅ Complete |
| Newman Testing           | ✅ Complete |
| Front-End Tests          | ✅ Complete |
| Vehicle Search           | 🚧 Planned |
| Price Tracking           | 🚧 Planned |
| Price History            | 🚧 Planned |
| Admin Dashboard          | 🚧 Planned |

---

# Repository

GitHub:

```text
https://github.com/Rishyu/Hot-Wheels-Treasure-Hunt-Market-Tracker
```

---

# Developer

**Rishyu Babariya**

Software Development – Computer Systems Technology

Mohawk College

---

## Project Status

**Milestone 1 foundation completed.**

The project currently has a working authentication and collector account system, role-based authorization, collector profile management, saved favorites, and automated testing.

Development will continue with the core Hot Wheels market tracking functionality.
