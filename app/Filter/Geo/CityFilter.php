<?php

namespace App\Filter\Geo;

use Kiryanov\Filter\Filter\QueryFilter;

class CityFilter extends QueryFilter
{
    public function name(string $name): void
    {
        $this->builder->where('name', 'like', '%' . $name . '%');
    }
}
