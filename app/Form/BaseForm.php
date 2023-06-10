<?php

namespace App\Form;

use Illuminate\Contracts\Validation\Validator as ValidatorProperty;

abstract class BaseForm
{
    protected ValidatorProperty $validator;
    protected string|bool $error;

    abstract function load(array $data): bool;

    abstract protected function createValidator(): void;

    public function validate(): bool
    {
        $this->createValidator();
        $this->error = $this->validator->fails() ? $this->validator->errors() : false;

        return !$this->validator->fails();
    }

    function getError(): bool|string
    {
        return $this->error;
    }

}
