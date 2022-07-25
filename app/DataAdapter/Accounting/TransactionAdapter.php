<?php

namespace App\DataAdapter\Accounting;

use App\DataAdapter\User\UserAdapter;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Kiryanov\Adapter\DataAdapter\DataAdapter;

class TransactionAdapter extends DataAdapter
{
    protected UserAdapter $userAdapter;
    protected CategoryAdapter $categoryAdapter;

    public function __construct(UserAdapter $userAdapter, CategoryAdapter $categoryAdapter)
    {
        $this->userAdapter = $userAdapter;
        $this->categoryAdapter = $categoryAdapter;
    }

    function getModelData(Model $transaction): array
    {
        $date = new DateTime($transaction->created_at);

        return [
            'id' => $transaction->id,
            'description' => $transaction->description,
            'amount' => $transaction->amount,
            'date' => $date->format('d-m-Y H:i:s'),
            'type' => $transaction->type,
            'user' => $this->userAdapter->getModelData($transaction->user),
            'category' => $this->categoryAdapter->getModelData($transaction->category),
        ];
    }
}
