<?php

namespace App\Form\User;

use App\Form\BaseForm;
use Exception;
use Illuminate\Support\Facades\Validator;

class UserForm extends BaseForm
{
    private ?string $firstName = null;
    private ?string $lastName = null;
    private ?string $middleName = null;
    private ?string $phone = null;
    private ?string $email = null;
    private ?string $password = null;
    private string|bool $error;


    public function load(array $data): bool
    {
        try {
            $this->firstName = $data['firstName'] ?? null;
            $this->lastName = $data['lastName'] ?? '';
            $this->middleName = $data['middleName'] ?? '';
            $this->phone = $data['phone'] ?? '';
            $this->email = $data['email'] ?? null;
            $this->password = $data['password'] ?? null;
        } catch (Exception $exception) {
            $this->error = 'Не смог распарсить массив';

            return false;
        }

        return true;
    }

    public function validate(): bool
    {
        $this->createValidator();
        $this->error = $this->validator->fails() ? $this->validator->errors() : false;

        return !$this->validator->fails();
    }

    public function getError(): bool|string
    {
        return $this->error;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    protected function createValidator(): void
    {
        $this->validator = Validator::make([
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'middleName' => $this->middleName,
            'phone' => $this->phone,
            'email' => $this->email,
            'password' => $this->password
        ], [
            'email' => 'required|string|email|max:255|unique:users',
            'firstName' => 'required|string|max:255|',
            'password' => 'required|string|max:255|',
            'lastName' => 'string|max:255|',
            'middleName' => 'string|max:255|',
            'phone' => 'string|max:10|',
        ]);
    }
}
