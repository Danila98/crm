<?php

namespace App\Form;

interface Form
{
    public function load(array $data): bool;

    public function validate(): bool;

    public function getError(): bool|string;
}
