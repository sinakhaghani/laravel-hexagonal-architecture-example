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
