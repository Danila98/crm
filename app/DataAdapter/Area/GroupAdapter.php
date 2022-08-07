<?php

namespace App\DataAdapter\Area;

use App\Models\Area\Group;
use App\Repository\Area\AreaRepository;
use Illuminate\Database\Eloquent\Model;
use Kiryanov\Adapter\DataAdapter\DataAdapter;

class GroupAdapter extends DataAdapter
{

    protected AreaDataAdapter $areaAdapter;
    protected AreaRepository $areaRepository;

    public function __construct(AreaDataAdapter $areaAdapter, AreaRepository $areaRepository)
    {
        $this->areaAdapter = $areaAdapter;
        $this->areaRepository = $areaRepository;
    }

    function getModelData(Model $group): array
    {
        $area = $this->areaAdapter->getModelData($this->areaRepository->find($group->area_id));
        return [
            'name' => $group->name,
            'description' => $group->description,
            'area' => $area,
            'status' => Group::mapStatuses($group->status),
            'category' => $group->category->name
        ];
    }
}
