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
        return $this->userRepository->findById($id);
    }
}
