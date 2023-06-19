<?php

namespace App\Http\Controllers\Api;

use App\Constants\CommonConstants;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthenticateRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try {
            User::create([
                'role' => CommonConstants::USER_ROLE,
                'first_name' => $request->get('first_name'),
                'last_name' => $request->get('last_name'),
                'identity' => $request->get('identity'),
                'email' => $request->get('email'),
                'phone' => $request->get('phone'),
                'password' => Hash::make($request->get('password')),
            ]);

            return responseJson(
                type: 'message',
                message: 'User created successfully.',
                status: 201
            );
        } catch (Exception $exception) {
            return exceptionResponseJson(
                message: CommonConstants::GENERAL_EXCEPTION_ERROR_MESSAGE,
                exceptionMessage: $exception->getMessage()
            );
        }
    }

    public function authenticate(AuthenticateRequest $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');

        try {
            if (!Auth::attempt(['email' => $email, 'password' => $password])) {
                return responseJson(
                    type: 'message',
                    message: 'Invalid email or password. Please try again.',
                    status: 401
                );
            }

            $user = Auth::user();
            $authToken = $user->createToken('auth_token')->plainTextToken;

            return responseJson(
                type: 'dataAndMessage',
                data: [
                    'token' => $authToken,
                    'user' => $user
                ],
                message: 'Login was successful.'
            );
        } catch (Exception $exception) {
            return exceptionResponseJson(
                message: CommonConstants::GENERAL_EXCEPTION_ERROR_MESSAGE,
                exceptionMessage: $exception->getMessage()
            );
        }
    }
}
