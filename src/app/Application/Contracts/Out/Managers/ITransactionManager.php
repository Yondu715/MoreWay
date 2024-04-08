<?php

namespace App\Application\Contracts\Out\Managers;

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
