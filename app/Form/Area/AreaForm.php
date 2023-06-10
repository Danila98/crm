<?php

namespace App\Form\Area;

use App\Form\BaseForm;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Exception;

class AreaForm extends BaseForm
{
    private ?string $name = null;
    private ?string $description = null;
    private ?int $cityId = null;
    private ?int $street = null;
    private ?int $house = null;
    private ?string $building = null;

    function load(array $data): bool
    {
        try {
            $this->name = $data['name'] ?? null;
            $this->description = $data['description'] ?? null;
            $this->cityId = $data['city_id'] ?? null;
            $this->street = $data['street'] ?? null;
            $this->house = $data['house'] ?? null;
            $this->building = $data['building'] ?? null;

        } catch (Exception $exception) {
            $this->error = 'Не смог распарсить массив';

            return false;
        }

        return true;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getCityId(): ?int
    {
        return $this->cityId;
    }

    public function getStreet(): ?int
    {
        return $this->street;
    }

    public function getHouse(): ?int
    {
        return $this->house;
    }

    public function getBuilding(): ?string
    {
        return $this->building;
    }

    protected function createValidator(): void
    {
        $this->validator = Validator::make([
            'name' => $this->name,
            'description;' => $this->description,
            'city_id' => $this->cityId,
            'street' => $this->street,
            'house' => $this->house,
            'building' => $this->building,
        ], [
            'name' => 'required|string',
            'description' => 'required|string',
            'city_id' => 'required|numeric',
            'street' => 'required|string',
            'house' => 'required|numeric',
            'building' => 'nullable|string',
        ]);
    }

}
