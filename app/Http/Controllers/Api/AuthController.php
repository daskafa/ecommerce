<?php

namespace App\Http\Controllers\Api;

use App\Constants\CommonConstants;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\User;
use Exception;
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
}
