<?php

namespace App\Repositories\Implements;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class BaseRepository implements BaseRepositoryInterface
{
  private $model;
  protected $fields;

  public function __construct($model)
  {
    $this->model = $model;
    $this->fields = defined("$model::FIELDS") ? $model::FIELDS : [];
  }

  public function getModel(): string
  {
    return $this->model;
  }

  public function getInstance(): Model
  {
    return new $this->model();
  }

  /**
   * Find an item by its ID and a specified field
   * @param int $id The ID of the item to find
   * @param array $fields The fields to fetch
   * @return \Illuminate\Database\Eloquent\Model|null
   */
  public function findById(int $id, array $fields): ?Model
  {
    return $this->model::select($fields)->find($id);
  }

  /**
   * Get all items based on the specified fields
   * @param array $fields The fields to fetch
   * @return \Illuminate\Support\Collection
   */
  public function findAll(array $fields): Collection
  {
    return $this->model::select($fields)->get();
  }

  /**
   * Get all items based on the specified IDs and fields
   * @param array $ids The IDs of the items to find
   * @param array $fields The fields to fetch
   * @return \Illuminate\Support\Collection
   */
  public function findAllByIds(array $ids, array $fields): Collection
  {
    return $this->model::select($fields)->whereIn('id', $ids)->get();
  }

  /**
   * Create a new item with the provided data
   * @param array $entity The data of the new item
   * @return \Illuminate\Database\Eloquent\Model
   */
  public function create(array $entity): Model
  {
    return $this->model::create($entity);
  }

  /**
   * Create multiple new items with the provided data
   * @param array $entities The data of the new items
   * @return bool
   */
  public function createAll(array $entities): bool
  {
    return $this->getInstance()->insert($entities);
  }

  /**
   * Update an item by ID with the provided new data
   * @param int $id The ID of the item to update
   * @param array $entity The new data for the item
   * @return bool
   */
  public function update(int $id, array $entity): bool
  {
    return $this->model::where('id', $id)->update($entity);
  }

  /**
   * Delete an item by ID
   * @param int $id The ID of the item to delete
   * @return bool
   */
  public function deleteById(int $id): bool
  {
    return (bool) $this->model::destroy($id);
  }

  /**
   * Check if an item exists based on the given ID
   * @param int $id The ID of the item to check
   * @return bool
   */
  public function existsById(int $id): bool
  {
    return $this->model::where('id', $id)->exists();
  }

  /**
   * Get all items based on specific conditions
   * @param string|array $fields The fields to fetch or custom conditions
   * @param array $conditions Custom conditions for the query
   * @return \Illuminate\Support\Collection
   */
  public function where(string|array $fields = '*', $conditions = []): Collection
  {
    return $this->model::where($conditions)->select($fields)->get();
  }

  /**
   * Perform a query based on conditions and options
   * @param array $fields The fields to fetch
   * @param string|null $searchValue The search value
   * @param array $searchFields The fields to search in
   * @param string $orderBy The order by field
   * @param string $orderType The order type (ASC or DESC)
   * @param int $currentPage The current page
   * @param int $perPage The number of items per page
   * @param array $conditions Optional conditions (array of 2 elements, e.g. [['field', '=', 'value']])
   * @return \Illuminate\Pagination\LengthAwarePaginator
   */
  public function select(array $fields, ?string $searchValue, array $searchFields = [], string $orderBy = 'id', string $orderType = 'DESC', int $currentPage = 1, int $perPage = 20, array $conditions = []): LengthAwarePaginator
  {
    $items = $this->model::select($fields)->orderBy($orderBy, $orderType);

    if ($searchValue && $searchFields && is_array($searchFields)) {
      $items->where(function (Builder $items) use ($searchValue, $searchFields) {
        foreach ($searchFields as $field) {
          $items->orWhere($field, 'like', "%{$searchValue}%");
        }
      });
    }

    if (!empty($conditions)) {
      foreach ($conditions as $condition) {
        $items->where(...$condition);
      }
    }

    $items = $items->paginate($perPage, ['*'], 'page', $currentPage);
    $items->withPath(LengthAwarePaginator::resolveCurrentPath());
    return $items;
  }

  /**
   * Handle dynamic method calls to perform queries based on 'findBy...' conditions
   * @param string $method The name of the called method
   * @param array $parameters The parameters passed to the method
   * @return \Illuminate\Support\Collection
   * @throws \BadMethodCallException Throws an exception if the method does not exist or is invalid
   */
  public function __call(string $method, mixed $parameters): Collection
  {
    if (strpos($method, 'findBy') === 0 && $method !== 'findById') {
      $field = lcfirst(substr($method, 6));
      $field = $this->camelToSnakeCase($field);
      if (in_array($field, $this->fields)) {
        return $this->model::where($field, $parameters[0])->get();
      }
    }

    throw new \BadMethodCallException("Phương thức $method không tồn tại.");
  }

  /**
   * Create a new instance from provided data and save it to the database.
   *
   * @param array $data
   * @return Model|boolean
   */
  public function createFromData(array $data): Model|bool
  {
    $object = $this->getInstance();
    foreach ($this->fields as $field) {
      if (array_key_exists($field, $data)) {
        $object->$field = $data[$field];
      }
    }
    if ($object->save()) {
      return $object;
    }

    return false;
  }

  private function camelToSnakeCase(string $input): string
  {
    return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $input));
  }
}
