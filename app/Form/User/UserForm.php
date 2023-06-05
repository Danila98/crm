<?php

namespace App\Form\User;

use App\Form\Form;
use Exception;
use Illuminate\Support\Facades\Validator;

class UserForm implements Form
{
    private ?string $firstName;
    private ?string $lastName;
    private ?string $middleName;
    private ?string $phone;
    private ?string $email;
    private ?string $password;
    private string|bool $error;

    public function load(array $data): bool
    {
        try {
            $this->firstName = $data['name'] ?? $data['firstName'] ?? null;
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
        $validator = Validator::make([
            'name' => $this->firstName,
            'lastName' => $this->lastName,
            'middleName' => $this->middleName,
            'phone' => $this->phone,
            'email' => $this->email,
            'password' => $this->password
        ], [
            'email' => 'required|string|email|max:255|unique:users',
            'name' => 'required|string|max:255|',
            'firstName' => 'string|max:255|',
            'lastName' => 'string|max:255|',
            'middleName' => 'string|max:255|',
            'phone' => 'string|max:10|',
        ]);
        $this->error = $validator->fails() ? $validator->errors() : false;

        return !$validator->fails();
    }

    public function getError(): bool|string
    {
        return $this->error;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
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
}
