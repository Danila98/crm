<?php

namespace App\Filter\Area;

use Kiryanov\Filter\Filter\QueryFilter;

class AreaFilter extends QueryFilter
{
    public function name(string $name): void
    {
        $this->builder->where('name', 'like', '%' . $name . '%');
    }
}
