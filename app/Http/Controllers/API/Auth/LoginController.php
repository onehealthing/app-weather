<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Services\LaravelPassportService\LaravelPassportServiceInterface;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    /**
     * @param \App\Http\Services\LaravelPassportService\LaravelPassportServiceInterface $laravelPassportService
     */
    public function __construct(
        private LaravelPassportServiceInterface $laravelPassportService
    ) {}

    /**
     * @param \App\Http\Requests\UserLoginRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(UserLoginRequest $request): JsonResponse
    {
        try {
            $tokenData = $this->laravelPassportService->login(
                $request->get('email'),
                $request->get('password')
            );

            return response()->json($tokenData, Response::HTTP_OK);
        } catch (GuzzleException $exception) {
            return response()->json(['message' => 'Can`t login user'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
