<?php

namespace App\DataAdapter\Area;

use Illuminate\Database\Eloquent\Model;
use Kiryanov\Adapter\DataAdapter\DataAdapter;

class GroupCategoryAdapter extends DataAdapter
{

    function getModelData(Model $category): array
    {
        return [
            'id' => $category->id,
            'name' => $category->name
        ];
    }
}
