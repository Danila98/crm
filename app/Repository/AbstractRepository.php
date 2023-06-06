<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;
use Spatie\FlareClient\Http\Exceptions\NotFound;

abstract class AbstractRepository
{
    protected abstract function getClass(): string;

    /**
     * @throws NotFound
     */
    public function get(int $id)
    {
        $class = $this->getClass();
        $model = $class::find($id);
        if ($model) {
            return $model;
        } else {
            throw new NotFound();
        }
    }

    public function create(array $params) : Model
    {
        $class = $this->getClass();
        return $class::create($params);
    }

    public function update(int $id, array $params) : Model
    {
        $model = $this->find($id);
        if ($model) {
            foreach ($params as $attribute => $value) {
                $model->$attribute = $value;
            }
            $model->save();
        } else {
            throw new NotFoundException();
        }

        return $model;
    }

    public function delete(int $id): void
    {
        $class = $this->getClass();
        $model = $class::find($id);
        if ($model) {
            $model->delete();
        } else {
            throw new NotFoundException();
        }
    }
}
