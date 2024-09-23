<?php

namespace Danilowa\LaravelApiAuth\DTOs;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Danilowa\LaravelApiAuth\Traits\HttpResponseException;

/**
 * --------------------------------------------------------------------------
 * User Login Data Transfer Object
 * --------------------------------------------------------------------------
 *
 * This class handles the validation rules for user login requests.
 * It extends the FormRequest class to utilize Laravel's validation features
 * and provides a structured way to validate user login data.
 */
class UserLoginData extends FormRequest
{
    use HttpResponseException;

    /**
     * Get the validation rules that apply to the request.
     *
     * This method retrieves the validation rules defined in the configuration
     * for user login, ensuring that the data meets the specified criteria.
     *
     * @return array The validation rules for user login.
     */
    public function rules(): array
    {
        return config('apiauth.validation.login.rules');
    }

    /**
     * Handle a failed validation attempt.
     *
     * This method is triggered when validation fails, providing a custom
     * response that includes the validation errors.
     *
     * @param Validator $validator The validator instance containing the errors.
     * @return void
     */
    protected function failedValidation(Validator $validator): void
    {
        $this->HttpResponseException($validator, 422);
    }
}
