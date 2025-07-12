<?php
namespace App\Domain\User;
class User
{
    public function __construct(
        public readonly ?int $id,
        public string $name,
        public string $email
    ){}
}
