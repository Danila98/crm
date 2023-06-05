<?php

namespace App\DataAdapter\Area;

use App\Models\Area\GroupCategory;
use Illuminate\Database\Eloquent\Model;
use Kiryanov\Adapter\DataAdapter\DataAdapter;

class GroupCategoryAdapter extends DataAdapter
{
    /**
     * @param GroupCategory $category
     * @return array
     */
    function getModelData(Model $category): array
    {
        return [
            'id' => $category->id,
            'name' => $category->name
        ];
    }
}
