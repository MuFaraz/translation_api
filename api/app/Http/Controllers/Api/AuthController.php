<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="User login",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Successful login"),
     *     @OA\Response(response=401, description="Invalid credentials")
     * )
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => auth()->user(),
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/me",
     *     summary="Get authenticated user",
     *     tags={"Authentication"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="Authenticated user info"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function me()
    {
        return response()->json(auth()->user());
    }
    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Logout user",
     *     tags={"Authentication"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="Logout success"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
}
