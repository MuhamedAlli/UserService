<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    protected UserService $userService;


    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function update($id, UpdateUserRequest $request)
    {
        try {
            $validatedData = $request->validated();

            // $validatedData = $request->validate([
            //     'name' => 'sometimes|required|string|max:255',
            //     'email' => 'sometimes|required|email|unique:users,email,' . $id,
            // ]);

            $response =  $this->userService->update($id, $validatedData);
        } catch (Exception $e) {
            return [
                'statusCode' => $e->getCode() | 400,
                'message' => 'Error',
                'error' => $e->getMessage()
            ];
        }
        return response()->json([
            'message' => "success",
            'data' => $response ?? null,
        ]);
    }

    public function delete($id)
    {
        try {
            $response = $this->userService->delete($id);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Fail',
                'error' => $e->getMessage()
            ], 400);
        }
        return response()->json([
            'message' => "success",
            'data' => $response ?? null
        ], 200);
    }

    public function getUserById($id ,Request $request)
    {
        // $data = $request->all();
        // dd($data);
        try {
           
            $response = $this->userService->getUserById($id);
        } catch (Exception $e) {

            return response()->json([
                'message' => 'Fail',
                'error' => $e->getMessage()
            ], 400);
        }

        return response()->json([
            'message' => "success",
            'data' => $response ?? null
        ], 200);
    }

    public function getImage($userId)
    {
        try {
            $response = $this->userService->getImage($userId);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Fail',
                'error' => $e->getMessage()
            ], 400);
        }
        return response()->json([
            'message' => "success",
            'data' => $response->json()
        ], 200);
    }
}
