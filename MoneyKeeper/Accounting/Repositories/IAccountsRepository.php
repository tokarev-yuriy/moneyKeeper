<?php
namespace MoneyKeeper\Accounting\Repositories;

use MoneyKeeper\Accounting\Entities\AccountEntity;
use MoneyKeeper\Accounting\Entities\AccountGroupEntity;
use MoneyKeeper\Accounting\Entities\UserEntity;
use MoneyKeeper\Support\ICollection;

/**
 * Interface of account repository
 */
Interface IAccountsRepository {   
    /**
     * Repository depends on user and does not work without it
     *
     * @param UserEntity $user
     */
    public function __construct(UserEntity $user);

    /**
     * Returns a collection of user's accounts filtered by group
     *
     * @param AccountGroupEntity|null $group
     * @return ICollection of AccountEntity
     */
    public function getAccounts(?AccountGroupEntity $group = null): ICollection;

    /**
     * Returns an account entity
     *
     * @param integer $id
     * @return AccountEntity
     */
    public function getAccountById(int $id): AccountEntity;

    /**
     * Delete an account by id
     *
     * @param integer $id
     * @return boolean
     */
    public function deleteAccount(int $id): bool;

    /**
     * Save an account and returns updated entity
     *
     * @param AccountEntity $account
     * @return AccountEntity
     */
    public function saveAccount(AccountEntity $account): AccountEntity;

   /**
     * Returns a collection of user's account groups
     *
     * @return ICollection of AccountGroupEntity
     */
    public function getAccountGroups(): ICollection;

    /**
     * Returns an account group entity
     *
     * @param integer $id
     * @return AccountGroupEntity
     */
    public function getAccountGroupById(int $id): AccountGroupEntity;

    /**
     * Delete an account group by id
     *
     * @param integer $id
     * @return boolean
     */
    public function deleteAccountGroup(int $id): bool;

    /**
     * Save an account group and returns updated entity
     *
     * @param AccountGroupEntity $group
     * @return AccountGroupEntity
     */
    public function saveAccountGroup(AccountGroupEntity $group): AccountGroupEntity;
}
