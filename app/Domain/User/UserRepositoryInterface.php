<?php

namespace App\Domain\User;

interface UserRepositoryInterface
{
    public function create(User $user): User;

    public function findById(int $id): ?User;
}
