<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use OpenApi\Annotations as OA;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Register a new user",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *     required={"name","email","password","password_confirmation"},
     *     @OA\Property(property="name", type="string", example="John Doe", description="Name of the user"),
     *     @OA\Property(property="email", type="string", example="john@mail.com", description="Email of the user"),
     *     @OA\Property(property="password", type="string", example="password", description="Password of the user"),
     *     @OA\Property(property="password_confirmation", type="string", example="password", description="Password confirmation of the user"),
     *     )
     *    ),
     *     @OA\Response(
     *     response=201,
     *     description="User registered successfully",
     *     @OA\JsonContent(
     *     @OA\Property(property="user", type="object", ref="#/components/schemas/UserResponse"),
     *     @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjMwZjIwZjQw"),
     *     )
     *   ),
     *     @OA\Response(
     *     response=400,
     *     description="Bad request",
     *     @OA\JsonContent(
     *     @OA\Property(property="message", type="string", example="The given data was invalid."),
     *     @OA\Property(property="errors", type="object", example="{'name': ['The name field is required.'], 'email': ['The email field is required.'], 'password': ['The password field is required.'], 'password_confirmation': ['The password confirmation field is required.']}"),
     *     )))
     */

    public function register(StoreAuthRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['password'] = bcrypt($validatedData['password']);
        $user = User::create($validatedData);

        $name = $user->name;
        $name = iconv('UTF-8', 'ASCII//TRANSLIT', $name);
        $name = str_replace(' ', '_', $name);
        $name = strtolower($name);

        $token = $user->createToken('auth_token' . $name)->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token,], 201);
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Login a user",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *     required={"email","password"},
     *     @OA\Property(property="email", type="string", example="john@mail.com", description="Email of the user"),
     *     @OA\Property(property="password", type="string", example="password", description="Password of the user"),
     *     )
     *   ),
     *     @OA\Response(
     *     response=200,
     *     description="User logged in successfully",
     *     @OA\JsonContent(
     *     @OA\Property(property="user", type="object", ref="#/components/schemas/User"),
     *     @OA\Property(property="token", type="string", example="
     *   eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjMwZjIwZjQw"),
     *     )
     *  ),
     *     @OA\Response(
     *     response=401,
     *     description="Unauthorized",
     *     @OA\JsonContent(
     *     @OA\Property(property="message", type="string", example="The provide credentials are incorrect."),
     *     )
     *  )
     * )
     */


    public function login(Request $request)
    {
        $request->validate(['email' => 'required|string|exists:users', 'password' => 'required|string',]);

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'The provide credentials are incorrect.'], 401);
        }
        $name = $user->name;
        $name = iconv('UTF-8', 'ASCII//TRANSLIT', $name);
        $name = str_replace(' ', '_', $name);
        $name = strtolower($name);
        $user->tokens()->delete();
        $token = $user->createToken('auth_token' . $name)->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token,], 200);

    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Logout a user",
     *     tags={"Auth"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *     response=200,
     *     description="User logged out successfully",
     *     @OA\JsonContent(
     *     @OA\Property(property="message", type="string", example="Logged out"),
     *     )
     *   )
     * )
     *
     */

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out'], 200);
    }
}
