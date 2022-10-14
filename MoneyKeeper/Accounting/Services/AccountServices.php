<?php
namespace MoneyKeeper\Accounting\Services;

use Exception;
use Illuminate\Support\Collection;
use MoneyKeeper\Accounting\Entities\AccountEntity;
use MoneyKeeper\Accounting\Entities\UserEntity;
use MoneyKeeper\Accounting\Repositories\IAccountsRepository;
use MoneyKeeper\Accounting\ValueObjects\AccountDescriptionValue;
use MoneyKeeper\Exceptions\NotFoundException;

/**
 * Account services class
 */
class AccountServices implements ICrudServices {

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
        if (!$this->user->getId()) {
            throw new Exception('User not found');
        }
        $this->repository = $repository;
    }

    /**
     * Get account by id
     *
     * @param integer $id
     * @return AccountEntity
     * @throws Exception
     */
    public function getById(int $id): AccountEntity
    {
        $account = $this->repository->getAccountById($id);
        if ($account->getId()!=$id) {
            throw new NotFoundException('Account not found');
        }
        return $account;
    }

    /**
     * Get all accounts
     *
     * @return Collection
     * @throws Exception
     */
    public function getAll(): Collection
    {
        $groups = $this->repository->getAccounts();
        return $groups;
    }

    /**
     * Updates account group
     *
     * @param int $id
     * @param array $fields
     * @return AccountEntity
     * @throws NotFoundException
     */
    public function update(int $id, array $fields): AccountEntity
    {
        $account = $this->repository->getAccountById($id);
        if ($account->getId()!=$id) {
            throw new NotFoundException('Account not found');
        }
        $description = new AccountDescriptionValue(
            $fields['name'] ?? '',
            $fields['icon'] ?? '',
            $fields['color'] ?? '',
            $fields['sort'] ?? 0
        );
        $account->setDescription($description);

        $account = $this->repository->saveAccount($account);
        return $account;
    }

    /**
     * Add account
     *
     * @param array $fields
     * @return AccountEntity
     * @throws Exception
     */
    public function add(array $fields): AccountEntity
    {
        $description = new AccountDescriptionValue(
            $fields['name'] ?? '',
            $fields['icon'] ?? '',
            $fields['color'] ?? '',
            $fields['sort'] ?? 0
        );
        $account = new AccountEntity(null, $description, true);
        $account = $this->repository->saveAccount($account);
        return $account;
    }

    /**
     * Delete account
     *
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public function delete(int $id): bool
    {
        $group = $this->repository->getAccountById($id);
        if ($group->getId()!=$id) {
            throw new NotFoundException('Account not found');
        }
        $this->repository->deleteAccount($id);
        return true;
    }
}
