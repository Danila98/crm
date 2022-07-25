<?php

namespace App\Services;

use App\Models\Accounting\Account;
use App\Models\Accounting\Transaction;
use App\Models\User;

class TransactionService
{

    public function updateAccountTotal(Transaction $transaction, $user)
    {
        $account = Account::where(['user_id' => $user->id])->first();
        if ($transaction->type === Transaction::INCOME_TYPE)
        {
            $account->total += $transaction->amount;
        }
        if ($transaction->type === Transaction::OUTCOME_TYPE)
        {
            $account->total -= $transaction->amount;
        }
        $account->save();
    }

}
