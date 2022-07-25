<?php

namespace App\DataAdapter\Accounting;

use App\Models\Accounting\Category;
use Illuminate\Database\Eloquent\Model;
use Kiryanov\Adapter\DataAdapter\DataAdapter;

class CategoryAdapter extends DataAdapter
{
    /**
     * @param Category $category
     */
    public function getModelData(Model $category) : array
    {
        return [
            'id' => $category->id,
            'name' => $category->name,
            'limit' => $category->limit,
        ];
    }
}
