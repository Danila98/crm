<?php

namespace App\Form\Accounting;

use App\Form\Form;
use App\Models\Accounting\TrainerAccount;
use Exception;
use Illuminate\Support\Facades\Validator;

class TrainerAccountForm implements Form
{
    private int $userId;
    private ?int $maxPupils;
    private ?int $pupils;
    private string|bool $error;

    public function load(array $data): bool
    {
        try {
            $this->userId = $data['userId'];
            $this->maxPupils = $data['maxPupils'] ?? TrainerAccount::DEFAULT_MAX_PUPILS;
            $this->pupils = $data['pupils'] ?? TrainerAccount::DEFAULT_PUPILS;
        } catch (Exception $e) {
            $this->error = 'Не смог распарсить массив';

            return false;
        }

        return true;
    }

    public function validate(): bool
    {
        $validator = Validator::make([
            'userId' => $this->userId,
            'maxPupils;' => $this->maxPupils,
            'password' => $this->pupils
        ], [
            'userId' => 'required|numeric',
            'name' => 'numeric',
            'pupils' => 'numeric'
        ]);
        $this->error = $validator->fails() ? $validator->errors() : false;

        return !$validator->fails();
    }

    public function getError(): bool|string
    {
        return $this->error;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getMaxPupils(): ?int
    {
        return $this->maxPupils;
    }

    public function getPupils(): ?int
    {
        return $this->pupils;
    }

}
