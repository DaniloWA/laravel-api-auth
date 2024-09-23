<?php

namespace Danilowa\LaravelApiAuth\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Danilowa\LaravelApiAuth\DTOs\UserLoginData;
use Danilowa\LaravelApiAuth\DTOs\UserLogoutData;
use Danilowa\LaravelApiAuth\DTOs\UserRegistrationData;
use Danilowa\LaravelApiAuth\Services\AccessTokenService;
use Danilowa\LaravelResponseBuilder\JsonResponse as JsonResponseBuilder;

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
     * This method handles the registration of a new user.
     * It validates the provided data, creates a new user in the database,
     * and generates an access token for the user.
     *
     * @param UserRegistrationData $request The user registration data transfer object.
     * @return JsonResponse A JSON response containing the newly created user and their access token.
     */
    public function register(UserRegistrationData $request): JsonResponse
    {
        $data = $request->only(array_keys(config('apiauth.validation.registration.rules')));
        $data['password'] = Hash::make($request->password);

        $user = $this->userModel::create($data);

        $token = $this->accessTokenService->createToken($user, $request->token_name ?? $this->defaultTokenName);

        return JsonResponseBuilder::success([
            'user' => $user,
            'token' => $token->plainTextToken,
        ], $this->getMessage('user_created'), 201);
    }

    /**
     * Log a user in and create an access token.
     *
     * This method attempts to authenticate a user using the provided credentials.
     * If successful, it generates an access token for the authenticated user.
     *
     * @param UserLoginData $request The user login data transfer object.
     * @return JsonResponse A JSON response containing the access token and the authenticated user.
     */
    public function login(UserLoginData $request): JsonResponse
    {
        if (!Auth::attempt($request->only(array_keys(config('apiauth.validation.login.rules'))))) {
            return JsonResponseBuilder::error(401, $this->getMessage('credentials_incorrect'));
        }

        $user = Auth::user();
        $token = $this->accessTokenService->createToken($user, $request->token_name ?? $this->defaultTokenName);

        return JsonResponseBuilder::success([
            'token' => $token->plainTextToken,
            'user' => $user,
        ], $this->getMessage('user_logged_in'));
    }

    /**
     * Log the user out, revoking their access tokens.
     *
     * This method allows a user to log out by revoking their access tokens.
     * It checks whether the user is authenticated and whether they have any active tokens.
     *
     * @param UserLogoutData $request The user logout data transfer object.
     * @return JsonResponse A JSON response indicating the outcome of the logout process.
     */
    public function logout(UserLogoutData $request): JsonResponse
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return JsonResponseBuilder::error(401, $this->getMessage('credentials_incorrect'));
        }

        $user = $this->userModel::find($request->user()->id);
        $revokeAll = config('apiauth.revoke_all_tokens');

        if ($user->tokens()->count() === 0) {
            return JsonResponseBuilder::error(404, $this->getMessage('no_active_token'));
        }

        if ($revokeAll) {
            $user->tokens()->delete();
            return JsonResponseBuilder::success([], $this->getMessage('tokens_revoked'));
        }

        $token = $user->tokens()->first();
        $this->accessTokenService->revokeToken($token);
        return JsonResponseBuilder::success([], $this->getMessage('token_revoked'));
    }

    /**
     * Get the currently authenticated user.
     *
     * This method retrieves the currently authenticated user's information.
     *
     * @return JsonResponse A JSON response containing the authenticated user's data.
     */
    public function currentUser(): JsonResponse
    {
        return JsonResponseBuilder::success(Auth::user());
    }

    /**
     * Retrieve a message from the configuration.
     *
     * This private method fetches a message from the configuration based on the provided key.
     * If the key does not exist, it returns a default message.
     *
     * @param string $key The key for the message in the configuration.
     * @return string The corresponding message or a default message if not found.
     */
    private function getMessage(string $key): string
    {
        return $this->messages[$key] ?? 'Message not found';
    }
}
