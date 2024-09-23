<?php

namespace Danilowa\LaravelApiAuth\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Danilowa\LaravelApiAuth\DTOs\UserLoginData;
use Danilowa\LaravelApiAuth\DTOs\UserRegistrationData;
use Danilowa\LaravelApiAuth\Services\AccessTokenService;

class AuthenticationController extends Controller
{
    private $userModel;
    private array $messages;
    private string $defaultTokenName;
    private AccessTokenService $accessTokenService;

    public function __construct(AccessTokenService $accessTokenService)
    {
        $this->userModel = config('apiauth.user_model');
        $this->messages = config('apiauth.messages');
        $this->defaultTokenName = config('apiauth.default_token_name');
        $this->accessTokenService = $accessTokenService;
    }

    /**
     * Register a new user and create an access token.
     *
     * @param UserRegistrationData $request
     * @return JsonResponse
     */
    public function register(UserRegistrationData $request): JsonResponse
    {
        $user = $this->userModel::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $this->accessTokenService->createToken($user, $request->token_name ?? $this->defaultTokenName);

        return JsonResponse::success([
            'user' => $user,
            'token' => $token->plainTextToken,
        ], $this->getMessage('user_created'), 201);
    }

    /**
     * Log a user in and create an access token.
     *
     * @param UserLoginData $request
     * @return JsonResponse
     */
    public function login(UserLoginData $request): JsonResponse
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return JsonResponse::error(401, $this->getMessage('credentials_incorrect'));
        }

        $user = Auth::user();
        $token = $this->accessTokenService->createToken($user, $request->token_name ?? $this->defaultTokenName);

        return JsonResponse::success([
            'token' => $token->plainTextToken,
            'user' => $user,
        ], $this->getMessage('user_logged_in'));
    }

    /**
     * Log the user out, revoking their access tokens.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $revokeAll = config('apiauth.revoke_all_tokens');

        if ($revokeAll) {
            $request->user()->tokens()->delete();
            return JsonResponse::success([], $this->getMessage('tokens_revoked'));
        }

        $token = $request->user()->currentAccessToken();
        if (!$token) {
            return JsonResponse::error(404, $this->getMessage('no_active_token'));
        }

        $this->accessTokenService->revokeToken($token);
        return JsonResponse::success([], $this->getMessage('tokens_revoked'));
    }

    /**
     * Get the currently authenticated user.
     *
     * @return JsonResponse
     */
    public function currentUser(): JsonResponse
    {
        return JsonResponse::success(Auth::user());
    }

    /**
     * Retrieve a message from the configuration.
     *
     * @param string $key
     * @return string
     */
    private function getMessage(string $key): string
    {
        return $this->messages[$key] ?? 'Message not found';
    }
}
