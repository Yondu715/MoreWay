<?php

namespace App\Infrastructure\Managers\Transaction;

use App\Application\Contracts\Out\Managers\ITransactionManager;
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
