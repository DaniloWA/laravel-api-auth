<p align="center">
  <strong>Streamline API Authentication with Laravel API Auth!</strong> This simple and configurable package provides an easy solution for managing API authentication in Laravel applications using Laravel Sanctum. It includes features for user registration, login, logout, and retrieving current user data, all with standardized JSON responses.
</p>

## Index

- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [API Endpoints](#api-endpoints)
- [Usage Examples](#usage-examples)
- [Documentation](#documentation)
- [Contributing](#contributing)
- [License](#license)
- [Contact](#contact)

## Features

- **Seamless User Authentication:** Easily manage user authentication using Laravel Sanctum.
- **Standardized JSON Responses:** Consistent response structure for all API interactions, simplifying error handling and data management.
- **Flexible Configuration:** Customize response formats and API settings according to your application's needs.

## Requirements

Ensure your project meets the following requirements before using this package:

- **Laravel Framework:** Version 9.0 or higher.
- **PHP:** Version 8.0 or higher.
- **Composer:** PHP dependency manager.

## Installation

To integrate the Laravel API Auth into your Laravel project, follow these steps:

1. **Install via Composer:**

Run the following command in your terminal:

```bash
composer require danilowa/laravel-api-auth
```

2. **Publish the Configuration (Optional):**

After installation, publish the configuration file:

```bash
php artisan vendor:publish --provider="Danilowa\LaravelApiAuth\Providers\ApiAuthServiceProvider"
```

This will create a configuration file at `config/apiauth.php`, where you can customize the package settings.

## Configuration

The package configuration can be found in the `config/apiauth.php` file. This file allows you to customize various aspects of the API authentication system according to your project's needs.

### Key Configurations:

1. **Route Prefix:**

   - **`route_prefix`:** Allows you to define a custom prefix for all authentication routes. By default, it's set to `auth`. You can customize this via the `API_AUTH_ROUTE_PREFIX` environment variable, making it easy to change to `v1/auth`, for example.

2. **User Model Configuration:**

   - **`user_model`:** Specify the class name of the user model that will be used for authentication. The default is `App\Models\User::class`. If you have a custom user model, change this value accordingly.

3. **Token Settings:**

   - **`default_token_name`:** Defines the default name for the access tokens generated during registration or login. You can use a different name for each token if desired.

4. **Token Revocation Strategy:**

   - **`revoke_all_tokens`:** A boolean value that determines whether all tokens for a user should be revoked upon logout. If set to `true`, all tokens will be revoked; if `false`, only the current token will be revoked.

5. **Customizable Messages:**

   - **`messages`:** Allows you to customize the messages returned during the authentication process. For example, you can modify messages like "User created successfully!" to fit your communication style.

6. **Validation Rules:**

   - **`validation`:** Defines the validation rules for login and registration requests. You can adjust these rules to meet your application's policies, including format requirements for email or password strength.

### Configuration Example

```php
return [
    'route_prefix' => env('API_AUTH_ROUTE_PREFIX', 'auth'),
    'user_model' => 'App\Models\User::class',
    'default_token_name' => 'default_token',
    'revoke_all_tokens' => true,
    'messages' => [
        'user_created' => 'User created successfully!',
        'user_logged_in' => 'User logged in!',
        'credentials_incorrect' => 'The provided credentials are incorrect.',
        'tokens_revoked' => 'Tokens revoked successfully!',
        'default_error' => 'An error occurred.',
    ],
    'validation' => [
        'login' => [
            'rules' => [
                'email' => 'required|email',
                'password' => 'required|string',
            ],
        ],
        'registration' => [
            'rules' => [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:8',
                'token_name' => 'nullable|string',
            ],
        ],
    ],
];
```

## API Endpoints

This package provides the following API endpoints for user authentication:

- **POST /auth/register**: Register a new user.
- **POST /auth/login**: Log in an existing user.
- **POST /auth/logout**: Log out the authenticated user.
- **GET /auth/user**: Retrieve the current authenticated user's information.

## Usage Examples

### Register User

To register a new user, send a POST request to `/auth/register` with the following JSON body:

```json
{
  "name": "John Doe",
  "email": "john.doe@example.com",
  "password": "password123"
}
```

### Login User

To log in, send a POST request to `/auth/login`:

```json
{
  "email": "john.doe@example.com",
  "password": "password123"
}
```

### Logout User

To log out the authenticated user, send a POST request to `/auth/logout`.

### Retrieve Current User

To retrieve the current user's data, send a GET request to `/auth/user` with the appropriate authentication token.

## Documentation

### API Endpoints

#### Register

- **Description:** This endpoint allows a new user to register for the application by providing their name, email, and password.
- **Example Request:**

```http
POST /auth/register
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john.doe@example.com",
  "password": "password123"
}
```

- **Example Response:**

```json
{
  "status": "success",
  "message": "User registered successfully.",
  "data": {
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john.doe@example.com"
    }
  }
}
```

#### Login

- **Description:** This endpoint allows an existing user to log in by providing their email and password.
- **Example Request:**

```http
POST /auth/login
Content-Type: application/json

{
  "email": "john.doe@example.com",
  "password": "password123"
}
```

- **Example Response:**

```json
{
  "status": "success",
  "message": "User logged in successfully.",
  "data": {
    "token": "your_jwt_token_here"
  }
}
```

#### Logout

- **Description:** This endpoint allows the authenticated user to log out of the application.
- **Example Request:**

```http
POST /auth/logout
Authorization: Bearer your_jwt_token_here
```

- **Example Response:**

```json
{
  "status": "success",
  "message": "User logged out successfully."
}
```

#### Current User

- **Description:** This endpoint retrieves the current authenticated user's information.
- **Example Request:**

```http
GET /auth/user
Authorization: Bearer your_jwt_token_here
```

- **Example Response:**

```json
{
  "status": "success",
  "message": "User data retrieved successfully.",
  "data": {
    "id": 1,
    "name": "John Doe",
    "email": "john.doe@example.com"
  }
}
```

## Contributing

You can contribute by forking the repository and submitting a pull request.

## License

This package is licensed under the MIT License.

## Contact

For any questions or feedback, please reach out to:

- **Danilo Oliveira:** daniloworkdev@gmail.com
- **Website:** [daniloo.dev](http://www.daniloo.dev)
