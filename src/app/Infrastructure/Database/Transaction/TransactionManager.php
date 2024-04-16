<?php

namespace App\Infrastructure\Database\Transaction;

use App\Infrastructure\Database\Transaction\Interface\ITransactionManager;
use Illuminate\Support\Facades\DB;

class TransactionManager implements ITransactionManager
{
    /**
     * @return void
     */
    public function beginTransaction(): void
    {
        DB::beginTransaction();
    }

    /**
     * @return void
     */
    public function rollback(): void
    {
        DB::rollBack();
    }

    /**
     * @return void
     */
    public function commit(): void
    {
        DB::commit();
    }
}
