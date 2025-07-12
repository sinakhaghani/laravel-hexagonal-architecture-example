<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Laravel Hexagonal Architectural Example

An example of implementing **Hexagonal Architecture (Ports and Adapters)** in Laravel, featuring simple user registration and retrieval APIs.

This project demonstrates how to:

✅ Separate your core business logic from frameworks (Laravel, Eloquent, etc.)  
✅ Make your application easily testable and maintainable  
✅ Plug different persistence technologies without changing the core logic  
✅ Keep Controllers “thin” and focused only on HTTP concerns

## ✨ Features

- Register a new user
- Retrieve user details
- Clean separation of:
    - **Domain Layer** (entities + ports)
    - **Application Layer** (use cases)
    - **Infrastructure Layer** (Eloquent adapter)
    - **Framework Layer** (controllers, routes)

---

## 🔧 Project Structure

```
app/
├── Domain/
│   └── User/
│       ├── User.php
│       └── UserRepositoryInterface.php
│
├── Application/
│   └── User/
│       ├── CreateUserService.php
│       └── GetUserService.php
│
├── Infrastructure/
│   └── Eloquent/
│       └── EloquentUserRepository.php
│
├── Http/
│   └── Controllers/
│       └── Api/
│           └── UserController.php
│
├── Models/
│   └── User.php
│
├── Providers/
│   └── AppServiceProvider.php


```

## 🚀 Getting Started

```bash
git clone https://github.com/sinakhaghani/laravel-hexegonal-architectural-example.git
cd laravel-hexegonal-architectural-example
```

```bash
composer install
```

```bash
php artisan migrate
```

```bash
php artisan serve
```

