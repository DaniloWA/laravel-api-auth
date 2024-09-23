<?php

namespace Danilowa\LaravelApiAuth\DTOs;

use Illuminate\Foundation\Http\FormRequest;

/**
 * --------------------------------------------------------------------------
 * User Registration Data
 * --------------------------------------------------------------------------
 *
 * This class handles the validation rules for user registration requests.
 * It extends the FormRequest class to utilize Laravel's validation features.
 */
class UserRegistrationData extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array The validation rules for user registration.
     */
    public function rules()
    {
        // Retrieve the validation rules from the configuration
        $rules = config('apiauth.validation.registration.rules');

        return $rules;
    }
}
