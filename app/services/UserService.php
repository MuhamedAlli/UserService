<?php

namespace App\Services;

use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
class UserService
{
    protected UserRepositoryInterface $userRepository;
    private string $baseUrl;
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->baseUrl = env('IMAGE_SERVICE_URL');
    }
    public function update($id, array $data)
    {
        $user =  $this->userRepository->update($id, $data);
        if (!$user) {
            throw new ModelNotFoundException("User not found.");
        }
        return $user;
    }

    public function delete($id)
    {
        $user = $this->userRepository->delete($id);
        if (!$user) {
            throw new ModelNotFoundException("User not found.");
        }
        // Delete image from image microservice 
        Http::delete("{$this->baseUrl}/api/images/{$id}");

        return $user;
    }

    public function getUserById($id)
    {
        $user = $this->userRepository->getOne($id);
        return $user;
    }

    public function getImage($userId)
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])
                ->get("{$this->baseUrl}/api/external/images/{$userId}");

            return $response;
        } catch (\Exception $e) {
            throw new \Exception(
                "Failed to retrieve image",
            );
        }
    }
}
