<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface BaseRepositoryInterface
{
  public function findById(int $id, array $fields): ?Model;

  public function findAll(array $fields): Collection;

  public function findAllByIds(array $ids, array $fields): Collection;

  public function create(array $entity): Model;

  public function createAll(array $entities): bool;

  public function update(int $id, array $entity): bool;

  public function deleteById(int $id): bool;

  public function existsById(int $id): bool;

  public function where(string|array $fields = '*', array $conditions = []): Collection;

  public function select(array $fields, ?string $searchValue, array $searchFields = [], string $orderBy = 'id', string $orderType = 'DESC', int $currentPage = 1, int $perPage = 20, array $conditions = []): LengthAwarePaginator;

  public function __call(string $method, mixed $parameters): Collection;

  public function createFromData(array $data): Model|bool;
}
