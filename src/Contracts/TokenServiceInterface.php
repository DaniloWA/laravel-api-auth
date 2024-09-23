<?php

namespace Danilowa\LaravelApiAuth\Contracts;

/**
 * --------------------------------------------------------------------------
 * Token Service Interface
 * --------------------------------------------------------------------------
 *
 * Interface for the token service that handles the creation and revocation
 * of access tokens for users in the authentication system.
 */
interface TokenServiceInterface
{
    /**
     * Create a new access token for the given user.
     *
     * @param mixed $user The user for whom the token is being created.
     * @param string $tokenName The name to be assigned to the token.
     *                          Defaults to 'default_token'.
     * @return \Laravel\Sanctum\PersonalAccessTokenResult The created token result.
     */
    public function createToken($user, string $tokenName = 'default_token');

    /**
     * Revoke the specified access token.
     *
     * @param mixed $token The token to be revoked.
     * @return void
     */
    public function revokeToken($token);
}
