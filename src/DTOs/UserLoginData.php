<?php

namespace Danilowa\LaravelApiAuth\DTOs;

use Illuminate\Foundation\Http\FormRequest;

/**
 * --------------------------------------------------------------------------
 * User Login Data
 * --------------------------------------------------------------------------
 *
 * This class handles the validation rules for user login requests.
 * It extends the FormRequest class to utilize Laravel's validation features.
 */
class UserLoginData extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array The validation rules for user login.
     */
    public function rules()
    {
        // Retrieve the validation rules from the configuration
        $rules = config('apiauth.validation.login.rules');

        return $rules;
    }
}
