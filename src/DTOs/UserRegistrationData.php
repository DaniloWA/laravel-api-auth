<?php

namespace Danilowa\LaravelApiAuth\DTOs;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Danilowa\LaravelApiAuth\Traits\HttpResponseException;

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
    use HttpResponseException;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array The validation rules for user registration.
     */
    public function rules(): array
    {
        // Retrieve the validation rules from the configuration
        return config('apiauth.validation.registration.rules');
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator The validator instance containing the validation errors.
     * @throws Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator): void
    {
        $this->HttpResponseException($validator, 422);
    }
}
