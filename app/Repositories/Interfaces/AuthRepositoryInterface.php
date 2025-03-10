<?php

namespace App\Repositories\Interfaces;

interface AuthRepositoryInterface
{
    public function findByEmail($data);
    public function register(array $data);
    // public function logout();
    // public function refresh();
}
