<?php

namespace App\DataAdapter\Area;

use Illuminate\Database\Eloquent\Model;
use Kiryanov\Adapter\DataAdapter\DataAdapter;

class ActivityCategoryAdapter extends DataAdapter
{

    function getModelData(Model $category): array
    {
        return [
            'name' => $category->name,
            'description' => $category->description,
            'price' => $category->price,
            'priceSubscription' => $category->price_subscription,
        ];
    }
}
