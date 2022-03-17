<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Services\UserService\UserServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class RegisterController extends Controller
{
    /**
     * @param UserServiceInterface $userService
     */
    public function __construct(
        private UserServiceInterface $userService
    ) {}

    /**
     * @param \App\Http\Requests\UserRegisterRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(UserRegisterRequest $request): JsonResponse
    {
        try {
            $this->userService->register(
                $request->get('name'),
                $request->get('email'),
                $request->get('password'),
            );

            return response()->json(['message' => 'User registered.'], Response::HTTP_CREATED);
        } catch (\Exception $exception) {
            return response()->json(['message' => 'User can`t be registered.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
