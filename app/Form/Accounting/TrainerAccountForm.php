<?php

namespace App\Form\Accounting;

use App\Form\BaseForm;
use App\Models\Accounting\TrainerAccount;
use Exception;
use Illuminate\Support\Facades\Validator;

class TrainerAccountForm extends BaseForm
{
    private ?int $userId = null;
    private ?int $maxPupils = null;
    private ?int $pupils = null;
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
        $this->createValidator();
        $this->error = $this->validator->fails() ? $this->validator->errors() : false;

        return !$this->validator->fails();
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

    function createValidator(): void
    {
        $this->validator = Validator::make([
            'userId' => $this->userId,
            'maxPupils;' => $this->maxPupils,
            'password' => $this->pupils
        ], [
            'userId' => 'required|numeric',
            'name' => 'numeric',
            'pupils' => 'numeric'
        ]);
    }
}
