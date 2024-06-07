<?php

namespace App\Infrastructure\Database\Repositories;

use Exception;
use Illuminate\Support\Collection;
use App\Application\DTO\AbstractDto;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Infrastructure\Database\Models\Filters\AbstractFilter;
use App\Application\Contracts\Out\Repositories\IBaseRepository;
use App\Application\DTO\Collection\CursorDto;
use Illuminate\Contracts\Pagination\CursorPaginator;

abstract class BaseRepository implements IBaseRepository
{

    protected Model $model;

    public function __construct()
    {
        $this->makeModel();
    }

    abstract protected function model(): string;

    abstract protected function mapper(): string;


    private function makeModel(): void
    {
        $model = app()->make($this->model());

        if (!$model instanceof Model) {
            throw new Exception("Переданный класс не является наследником класса Illuminate\Database\Eloquent\Model");
        }

        $this->model = $model;
    }

    protected function resetModel(): void
    {
        $this->makeModel();
    }

    private function parseResult(Collection|Model|CursorPaginator $result): Collection|AbstractDto|CursorDto
    {
        if ($result instanceof Collection) {
            return $result->map(fn (Model $model) => $this->mapper()::fromModel($model));
        }

        if ($result instanceof CursorPaginator) {
            return $this->mapper()::fromPaginator($result);
        }

        return $this->mapper()::fromModel($result);
    }

    public function get(): Collection
    {
        if ($this->model instanceof Builder) {
            $result = $this->model->get();
        } else {
            $result = $this->model->all();
        }

        return $this->parseResult($result);
    }

    public function all(): Collection
    {
        $result = $this->get();
        return $this->parseResult($result);
    }

    public function findById(int $id): AbstractDto
    {
        $result = $this->model->query()->find($id);
        return $this->parseResult($result);
    }

    public function deleteById(int $id): int
    {
        $this->resetModel();
        return $this->model->query()
            ->where('id', $id)
            ->delete();
    }

    public function filter(AbstractFilter $filter): self
    {
        $this->model->filter($filter);
        return $this;
    }

    public function update(int $id, array $attributes): AbstractDto
    {
        $model = $this->model->query()->find($id);
        $model->update($attributes);
        $this->resetModel();
        return $this->parseResult($model->refresh());
    }

    public function create(array $attributes): AbstractDto
    {
        $this->resetModel();
        $model = $this->model->query()->create($attributes);
        $this->resetModel();
        return $this->parseResult($model);
    }


    public function where(string $column, string $operator = null, mixed $value = null): self
    {
        if ($this->model instanceof Builder) {
            $this->model->where($column, $operator, $value);
        } else {
            $this->model->query()->where($column, $operator, $value);
        }
        return $this;
    }

    public function cursorPaginate(string $limit = null, string $cursor = null) {
        if ($this->model instanceof Builder) {
            $result = $this->model->cursorPaginate(perPage: $limit, cursor: $cursor);
        } else {
            $result = $this->model->query()->cursorPaginate(perPage: $limit, cursor: $cursor);
        }

        $this->resetModel();

        return $this->parseResult($result);
    }
}
