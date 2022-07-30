<?php
namespace MoneyKeeper\Accounting\Services;

use Exception;
use Illuminate\Support\Collection;
use MoneyKeeper\Accounting\Entities\AccountGroupEntity;
use MoneyKeeper\Accounting\Entities\UserEntity;
use MoneyKeeper\Accounting\Repositories\IAccountsRepository;

/**
 * Account group services class
 */
class AccountGroupService {

    /**
     * @var UserEntity
     */
    public UserEntity $user;
    /**
     * @var IAccountsRepository
     */
    public IAccountsRepository $repository;
    
    /**
     * Create a service with all dependencies
     *
     * @param UserEntity $user
     * @param IAccountsRepository $repository
     */
    public function __construct(UserEntity $user, IAccountsRepository $repository)
    {
        $this->user = $user;
        $this->repository = $repository;
    }

    /**
     * Get account group by id
     *
     * @param integer $id
     * @return AccountGroupEntity
     * @throws Exception
     */
    public function getById(int $id): AccountGroupEntity
    {
        if (!$this->user->getId()) {
            throw new Exception('User not founded');
        }
        $group = $this->repository->getAccountGroupById($id);
        return $group;
    }

    /**
     * Get all account groups
     *
     * @return Collection
     * @throws Exception
     */
    public function getAll(): Collection
    {
        if (!$this->user->getId()) {
            throw new Exception('User not founded');
        }
        $groups = $this->repository->getAccountGroups();
        return $groups;
    }

    /**
     * Updates account group
     *
     * @param int $id
     * @param array $fields
     * @return AccountGroupEntity
     * @throws Exception
     */
    public function update(int $id, array $fields): AccountGroupEntity
    {
        if (!$this->user->getId()) {
            throw new Exception('User not founded');
        }
        $group = $this->repository->getAccountGroupById($id);

        if (isset($fields['name'])) {
            $group->setName($fields['name']);
        }
        if (isset($fields['sort'])) {
            $group->setSort($fields['sort']);
        }

        $group = $this->repository->saveAccountGroup($group);
        return $group;
    }

    /**
     * Add account group
     *
     * @param array $fields
     * @return AccountGroupEntity
     * @throws Exception
     */
    public function add(array $fields): AccountGroupEntity
    {
        if (!$this->user->getId()) {
            throw new Exception('User not founded');
        }
        $group = new AccountGroupEntity(null, $fields['name'], $fields['sort'], true);
        $group = $this->repository->saveAccountGroup($group);
        return $group;
    }

    /**
     * Delete account group
     *
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public function delete(int $id): bool
    {
        if (!$this->user->getId()) {
            throw new Exception('User not founded');
        }
        $group = $this->repository->getAccountGroupById($id);
        if ($group->getId()!=$id) {
            throw new Exception('Account Group not founded');
        }
        $this->repository->deleteAccountGroup($id);
        return true;
    }
}
