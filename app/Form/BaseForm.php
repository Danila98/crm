<?php

namespace App\Form;

use Illuminate\Contracts\Validation\Validator as ValidatorProperty;
use Illuminate\Support\Facades\Validator;

abstract class BaseForm
{
    protected ValidatorProperty $validator;

    abstract function load(array $data): bool;

    abstract function validate(): bool;

    abstract function getError(): bool|string;

    protected function createValidator(): void
    {
        $this->validator = Validator::make([], []);
    }
}
