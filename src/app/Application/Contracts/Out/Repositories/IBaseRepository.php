<?php

namespace App\Application\Contracts\Out\Repositories;

use Illuminate\Support\Collection;
use App\Application\DTO\AbstractDto;
use App\Infrastructure\Database\Models\Filters\AbstractFilter;

interface IBaseRepository
{

    public function get(): Collection;

    public function all(): Collection;

    public function findById(int $id): AbstractDto;

    public function deleteById(int $id): int;

    public function where(string $column, string $operator = null, mixed $value = null): self;

    public function update(int $id, array $attributes): AbstractDto;

    public function create(array $attributes): AbstractDto;

    public function filter(AbstractFilter $filter): self;
}
