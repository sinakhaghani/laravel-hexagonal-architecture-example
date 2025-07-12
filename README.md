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

### 1.1 Domain Layer → Entity + Port (app/Domain/User/User.php)

```php
<?php

namespace App\Domain\User;

class User
{
    public function __construct(
        public readonly ?int $id,
        public string $name,
        public string $email
    ) {}
}
```

### 1.2

```php
<?php

namespace App\Domain\User;

interface UserRepositoryInterface
{
    public function create(User $user): User;

    public function findById(int $id): ?User;
}
```

### 2.1 Application Layer: app/Application/User/CreateUserService.php

```php
<?php

namespace App\Application\User;

use App\Domain\User\User;
use App\Domain\User\UserRepositoryInterface;

class CreateUserService
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function execute(string $name, string $email): User
    {
        $user = new User(
            id: null,
            name: $name,
            email: $email
        );

        return $this->userRepository->create($user);
    }
}
```

### 2.2 app/Application/User/GetUserService.php

```php
<?php

namespace App\Application\User;

use App\Domain\User\UserRepositoryInterface;

class GetUserService
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function execute(int $id)
    {
        return $userRepository->findById($id);
    }
}
```

### 3. Adapter: app/Infrastructure/Eloquent/EloquentUserRepository.php

```php
namespace App\Infrastructure\Eloquent;

use App\Domain\User\User;
use App\Domain\User\UserRepositoryInterface;
use App\Models\User as EloquentUser;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function create(User $user): User
    {
        $eloquentUser = EloquentUser::create([
            'name' => $user->name,
            'email' => $user->email,
        ]);

        return new User(
            id: $eloquentUser->id,
            name: $eloquentUser->name,
            email: $eloquentUser->email,
        );
    }

    public function findById(int $id): ?User
    {
        $eloquentUser = EloquentUser::find($id);

        if (!$eloquentUser) {
            return null;
        }

        return new User(
            id: $eloquentUser->id,
            name: $eloquentUser->name,
            email: $eloquentUser->email,
        );
    }
}
```

### 4. Bind Interface In Service Provider

```php
use App\Domain\User\UserRepositoryInterface;
use App\Infrastructure\Eloquent\EloquentUserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
```

### 5. Adapter: app/Http/Controllers/Api/UserController.php

```php
namespace App\Http\Controllers\Api;

use App\Application\User\CreateUserService;
use App\Application\User\GetUserService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private CreateUserService $createUserService,
        private GetUserService $getUserService
    ) {}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
        ]);

        $user = $this->createUserService->execute(
            $validated['name'],
            $validated['email']
        );

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function show(int $id)
    {
        $user = $this->getUserService->execute($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }
}
```

### 6. Route

```php
use App\Http\Controllers\Api\UserController;

Route::post('/users', [UserController::class, 'store']);
Route::get('/users/{id}', [UserController::class, 'show']);
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

