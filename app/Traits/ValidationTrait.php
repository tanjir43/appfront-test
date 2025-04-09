<?php

namespace App\Traits;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

trait ValidationTrait
{
    public function validate(
        array $data,
        array $rules,
        array $messages = [],
        array $customAttributes = []
    ): array {
        $validator = Validator::make($data, $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }

    public function validateSafe(
        array $data,
        array $rules,
        array $messages = [],
        array $customAttributes = []
    ): array|false {
        $validator = Validator::make($data, $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            return false;
        }

        return $validator->validated();
    }

    public function getValidationErrors(
        array $data,
        array $rules,
        array $messages = [],
        array $customAttributes = []
    ): array {
        $validator = Validator::make($data, $rules, $messages, $customAttributes);

        return $validator->errors()->toArray();
    }
}
