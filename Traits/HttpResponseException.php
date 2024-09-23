<?php

namespace Danilowa\LaravelApiAuth\Traits;

use Danilowa\LaravelResponseBuilder\JsonResponse;
use Illuminate\Http\Exceptions\HttpResponseException as IlluminateHttpResponseException;
use Illuminate\Contracts\Validation\Validator;

/**
 * --------------------------------------------------------------------------
 * HTTP Response Exception Trait
 * --------------------------------------------------------------------------
 *
 * This trait provides a method to handle validation exceptions by throwing
 * an HttpResponseException with a structured JSON response containing the
 * validation errors.
 */
trait HttpResponseException
{
    /**
     * Handle a failed validation attempt and throw an HttpResponseException.
     *
     * This method constructs a JSON error response using the validation errors
     * and throws an IlluminateHttpResponseException with the specified status code.
     *
     * @param Validator $validator The validator instance containing the validation errors.
     * @param int $statusCode The HTTP status code for the response (default is 422).
     * @throws IlluminateHttpResponseException
     */
    protected function HttpResponseException(Validator $validator, int $statusCode = 422): void
    {
        throw new IlluminateHttpResponseException(
            JsonResponse::error($statusCode, $validator->errors()->all())
        );
    }
}
