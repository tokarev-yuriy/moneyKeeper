<?php
namespace MoneyKeeper\Accounting\Repositories;

use Illuminate\Support\Collection;
use MoneyKeeper\Accounting\Entities\CategoryEntity;
use MoneyKeeper\Accounting\Entities\UserEntity;
use MoneyKeeper\Accounting\ValueObjects\TransactionTypeValue;

/**
 * Interface of categories repository
 */
Interface ICategoriesRepository {   
    /**
     * Repository depends on user and does not work without it
     *
     * @param UserEntity $user
     */
    public function __construct(UserEntity $user);

    /**
     * Returns a collection of user's categories filtered by type
     *
     * @param TransactionTypeValue|null $type
     * @return Collection
     */
    public function getCategories(?TransactionTypeValue $type = null): Collection;

    /**
     * Returns an category entity
     *
     * @param integer $id
     * @return CategoryEntity
     */
    public function getCategoryById(int $id): CategoryEntity;

    /**
     * Delete an category by id
     *
     * @param integer $id
     * @return boolean
     */
    public function deleteCategory(int $id): bool;

    /**
     * Save an category and returns updated entity
     *
     * @param CategoryEntity $account
     * @return CategoryEntity
     */
    public function saveCategory(CategoryEntity $category): CategoryEntity;

    /**
     * returns avail icons
     *
     * @return Collection
     */
    public function getAvailIcons(): Collection;
}
