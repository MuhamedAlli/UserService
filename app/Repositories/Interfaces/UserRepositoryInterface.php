<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function getOne($id);
    public function update($id, array $data);
    public function delete($id);
}
