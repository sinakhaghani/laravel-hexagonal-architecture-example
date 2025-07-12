<?php

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
