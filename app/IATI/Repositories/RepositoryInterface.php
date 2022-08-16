<?php

declare(strict_types=1);

namespace App\IATI\Repositories;

use Illuminate\Database\Eloquent\Collection;

/**
 * Interface RepositoryInterface.
 */
interface RepositoryInterface
{
    /**
     * Get all resources.
     *
     * @param array $columns
     *
     * @return Collection
     */
    public function all(array $columns = ['*']): Collection;

    /**
     * Stores newly created resource.
     *
     * @param array $data
     *
     * @return object
     */
    public function store(array $data): object;

    /**
     * Update specific resource.
     *
     * @param array $data
     * @param       $id
     *
     * @return bool
     */
    public function update($id, array $data): bool;

    /**
     * Delete specific resource.
     *
     * @param $id
     *
     * @return bool
     */
    public function delete($id): bool;

    /**
     * Find specific resource.
     *
     * @param       $id
     * @param array $columns
     *
     * @return object|null
     */
    public function find($id, array $columns = ['*']): ?object;

    /**
     * Find specific resource by given attribute.
     *
     * @param       $attribute
     * @param       $value
     * @param array $columns
     *
     * @return object
     */
    public function findBy($attribute, $value, array $columns = ['*']): object;
}
