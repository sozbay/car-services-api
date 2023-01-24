<?php

namespace App\Repositories;

use Cron\AbstractField;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Contracts\Database\Query\Builder as QueryBuilder;
use Illuminate\Testing\Constraints\SoftDeletedInDatabase;

abstract class AbstractRepository
{
    protected static string $model = '';

    /**
     * @return string
     */
    public static function getTable(): string
    {
        return (new (static::$model)())->getTable();
    }

    /**
     * @return Builder
     * @noinspection PhpUndefinedMethodInspection
     */
    protected function query(): Builder
    {
        return (static::$model)::query();
    }

    /**
     * @param array $properties
     * @param bool $reselect
     * @return Model|null
     */
    public function create(array $properties, bool $reselect = false): ?Model
    {
        /** @var Model $model */
        $model = $this->query()->create($properties);
        $id = $model->id ?? 0;
        if (!$id) {
            return null;
        }

        return $reselect ? $this->find($id) : $model;
    }

    /**
     * @param array $columns
     * @return Collection
     * @noinspection PhpUndefinedMethodInspection
     */
    public function all(array $columns = ['*']): Collection
    {
        return (static::$model)::all($columns);
    }

    /**
     * @param array<int, AbstractField> $filters
     * @param array $with
     * @return LengthAwarePaginator
     */
    public function paginate(array $filters = [], array $with = [], array $columns = ["*"]): LengthAwarePaginator
    {
        /** @var Request $request */
        $request = request();
        $perPage = $request->get('per-page', 25);

        $query = $this->query();
        if (count($with) > 0) {
            $query->with($with);
        }

        $this->commonFilter($query, $filters);

        if ($request->get('with-trashed')) {
            $query->withTrashed();
        }

        return $query->paginate($perPage, $columns);
    }

    /**
     * @param array $where
     * @param array $columns
     * @param array $order
     * @param array $with
     * @return Model|null
     */
    public function first(array $where, array $columns = ['*'], array $order = ['id', 'ASC'], array $with = []): ?Model
    {
        $query = $this->query();
        if ($with) {
            $query->with($with);
        }

        return $query->where($where['column'], ($where['operator'] ?? '='), $where['value'])
            ->orderBy($order[0], $order[1])
            ->first($columns);
    }

    /**
     * @param int $id
     * @param array $columns
     * @param array $with
     * @return Model|null
     */
    public function find(int $id, array $columns = ['*'], array $with = []): ?Model
    {
        $query = $this->query();
        if ($with) {
            $query->with($with);
        }

        return $query->find($id, $columns);
    }

    /**
     * @param array $columns
     * @param array<int, AbstractField> $filters
     * @return Collection
     * @noinspection PhpUndefinedMethodInspection
     */
    public function getDataForExport(array $columns = ['*'], array $filters = []): Collection
    {
        $query = $this->query();
        $query->select($columns);
        $this->commonFilter($query, $filters);

        return $query->get();
    }

    /**
     * @param Builder $query
     * @param array<int, AbstractField> $filters
     * @return void
     */
    private function commonFilter(Builder $query, array $filters = []): void
    {
        /** @var Request $request */
        $request = request();

        foreach ($filters as $filter) {
            $filter->addWhere($query);
        }

        $sortable = $request->get('sort');
        if ($sortable) {
            $sort = explode('_', $sortable);
            $query->orderBy(Str::snake(last($sort)), $sort[0]);
        }

    }

    /**
     * @param int $id
     * @return void
     */
    public function restore(int $id): void
    {
        $this->query()->withTrashed()
            ->where('id',$id)
            ->restore();
    }
}
