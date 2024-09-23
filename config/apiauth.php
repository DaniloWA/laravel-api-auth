<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Route Prefix
    |--------------------------------------------------------------------------
    |
    | Define the prefix for all authentication routes. You can customize this
    | prefix by setting the `API_AUTH_ROUTE_PREFIX` environment variable.
    | If not set, it defaults to 'auth'. You can also change this to a versioned
    | prefix like 'v1/auth' or another custom value to better fit your API structure.
    |
    */
    'route_prefix' => env('API_AUTH_ROUTE_PREFIX', 'auth'),

    /**
     * --------------------------------------------------------------------------
     * User Model Configuration
     * --------------------------------------------------------------------------
     *
     * The fully qualified class name of the user model that will be used
     * for authentication. Update this value if you have a custom user model.
     */
    'user_model' => 'App\Models\User::class',

    /**
     * --------------------------------------------------------------------------
     * Default Token Name
     * --------------------------------------------------------------------------
     *
     * The default name assigned to access tokens created for users.
     * This can be overridden during token creation in the registration or
     * login process.
     */
    'default_token_name' => 'default_token',

    /**
     * --------------------------------------------------------------------------
     * Token Revocation Strategy
     * --------------------------------------------------------------------------
     *
     * Indicates whether to revoke all tokens for a user upon logout.
     *
     * true: All tokens will be revoked.
     * false: Only the current token will be revoked.
     */
    'revoke_all_tokens' => true,

    /**
     * --------------------------------------------------------------------------
     * Customizable Messages
     * --------------------------------------------------------------------------
     *
     * Messages used throughout the authentication process. These can be
     * customized to fit your application's requirements.
     */
    'messages' => [
        'user_created' => 'User created successfully!',
        'user_logged_in' => 'User logged in!',
        'credentials_incorrect' => 'The provided credentials are incorrect.',
        'tokens_revoked' => 'Tokens revoked successfully!',
        'default_error' => 'An error occurred.',
    ],

    /**
     * --------------------------------------------------------------------------
     * Validation Rules
     * --------------------------------------------------------------------------
     *
     * Defines the validation rules for user login and registration requests.
     * Customize these rules as necessary to enforce your application's policies.
     */
    'validation' => [
        'login' => [
            'rules' => [
                'email' => 'required|email',
                'password' => 'required|string',
                // You can add or remove custom rules as needed here
            ],
        ],
        'registration' => [
            'rules' => [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:8',
                'token_name' => 'nullable|string',
                // You can add or remove custom rules as needed here
            ],
        ],
    ],
];
