<?php

namespace App\DataAdapter\Area;

use Illuminate\Database\Eloquent\Model;
use Kiryanov\Adapter\DataAdapter\DataAdapter;

class ActivityAdapter extends DataAdapter
{

    protected GroupAdapter $groupAdapter;
    protected AreaDataAdapter $areaAdapter;

    public function __construct(GroupAdapter $groupAdapter, AreaDataAdapter $areaAdapter)
    {
        $this->groupAdapter = $groupAdapter;
        $this->areaAdapter = $areaAdapter;
    }

    function getModelData(Model $activity): array
    {
        return [
            'name' => $activity->name,
            'start' => $activity->start,
            'end' => $activity->end,
            'group' => $activity->group ? $this->groupAdapter->getModelData($activity->group) : null,
            'area' => $this->areaAdapter->getModelData($activity->area),
            'category' => $activity->category->name,
        ];
    }
}
