<?php

namespace App\Infrastructure\Database\Transaction\Interface;

interface ITransactionManager
{
    /**
     * @return void
     */
    public function beginTransaction(): void;

    /**
     * @return void
     */
    public function rollback(): void;

    /**
     * @return void
     */
    public function commit(): void;
}
