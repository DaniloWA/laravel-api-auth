<?php

namespace Danilowa\LaravelApiAuth\Services;

use Danilowa\LaravelApiAuth\Contracts\TokenServiceInterface;

/**
 * --------------------------------------------------------------------------
 * Access Token Service
 * --------------------------------------------------------------------------
 *
 * This service class implements the TokenServiceInterface and handles
 * the creation and revocation of access tokens for users.
 */
class AccessTokenService implements TokenServiceInterface
{
    /**
     * Create a new access token for the specified user.
     *
     * @param mixed $user The user for whom the token is being created.
     * @param string $tokenName The name of the token to be created.
     * @return \Laravel\Sanctum\NewAccessToken The newly created access token.
     */
    public function createToken($user, string $tokenName = 'default_token')
    {
        return $user->createToken($tokenName);
    }

    /**
     * Revoke the specified access token.
     *
     * @param mixed $token The token to be revoked.
     * @return void
     */
    public function revokeToken($token)
    {
        $token->delete();
    }
}
