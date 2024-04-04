<?php

namespace App\Repositories\BaseRepository\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface IBaseRepository
{
    /**
     * @return Collection<int,Model>
     */
    public function all(): Collection;

    /**
     * @param array<int,mixed> $attributes
     * @return Model
     * 
     */
    public function create(array $attributes): Model;

    /**
     * @param int $id
     * @return Model
     */
    public function findById(int $id): Model;

    /**
     * @param int $id
     * @param array<int,mixed> $attributes
     * @return Model
     */
    public function update(int $id, array $attributes): Model;

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool;

}