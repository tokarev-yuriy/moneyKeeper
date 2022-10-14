<?php
namespace MoneyKeeper\Accounting\Services;

use Exception;
use Illuminate\Support\Collection;
use MoneyKeeper\Accounting\Entities\ItemEntity;

/**
 * Crud services class
 * @todo remove dependency from Illuminate\Support\Collection
 */
interface ICrudServices {

    /**
     * Get an entity by id
     *
     * @param integer $id
     * @return ItemEntity
     * @throws Exception
     */
    public function getById(int $id): ItemEntity;

    /**
     * Get all entities
     *
     * @return Collection
     * @throws Exception
     */
    public function getAll(): Collection;

    /**
     * Update an entity
     *
     * @param int $id
     * @param array $fields
     * @return ItemEntity
     * @throws Exception
     */
    public function update(int $id, array $fields): ItemEntity;

    /**
     * Add an entity
     *
     * @param array $fields
     * @return ItemEntity
     * @throws Exception
     */
    public function add(array $fields): ItemEntity;

    /**
     * Delete an entity
     *
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public function delete(int $id): bool;
}
