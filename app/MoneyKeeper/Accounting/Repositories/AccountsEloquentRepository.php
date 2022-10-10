<?php
namespace App\MoneyKeeper\Accounting\Repositories;

use App\MoneyKeeper\Models\AccountGroup;
use Exception;
use Illuminate\Support\Collection;
use MoneyKeeper\Accounting\Entities\AccountEntity;
use MoneyKeeper\Accounting\Entities\AccountGroupEntity;
use MoneyKeeper\Accounting\Entities\UserEntity;
use MoneyKeeper\Accounting\Repositories\IAccountsRepository;
use MoneyKeeper\Accounting\ValueObjects\AccountDescriptionValue;
use MoneyKeeper\Exceptions\ForbiddenException;
use MoneyKeeper\Exceptions\NotFoundException;

/**
 * Eloquent realisation of account repository
 */
final class AccountsEloquentRepository implements IAccountsRepository {

  /**
   * Current User
   *
   * @var UserEntity
   */
  protected UserEntity $user;

  /**
   * Repository depends on user and does not work without it
   *
   * @param UserEntity $user
   */
  public function __construct(UserEntity $user) {
    $this->user = $user;
  }

  /**
   * Returns a collection of user's accounts filtered by group
   *
   * @param AccountGroupEntity|null $group
   * @return Collection of AccountEntity
   */
  public function getAccounts(?AccountGroupEntity $group = null): Collection
  {
    $accounts = new Collection();
    return $accounts;
  }

  /**
   * Returns an account entity
   *
   * @param integer $id
   * @return AccountEntity
   */
  public function getAccountById(int $id): AccountEntity
  {
    throw new Exception('Account not found');
    return new AccountEntity(null, new AccountDescriptionValue('', '', '', 0));
  }

  /**
   * Delete an account by id
   *
   * @param integer $id
   * @return boolean
   */
  public function deleteAccount(int $id): bool
  {
    return false;
  }

  /**
   * Save an account and returns updated entity
   *
   * @param AccountEntity $account
   * @return AccountEntity
   */
  public function saveAccount(AccountEntity $account): AccountEntity
  {
    return $account;
  }

  /**
   * Returns a collection of user's account groups
   *
   * @return Collection of AccountGroupEntity
   */
  public function getAccountGroups(): Collection
  {
    $groups = new Collection();
    $list = AccountGroup::where('user_id', '=', $this->user->getId())->get();
    foreach($list as $model) {
      $groups->add($model->toEntity());
    }
    return $groups;
  }

  /**
   * Returns an account group entity
   *
   * @param integer $id
   * @return AccountGroupEntity
   */
  public function getAccountGroupById(int $id): AccountGroupEntity
  {
    $model = AccountGroup::find($id);
    if (!$model) {
      throw new NotFoundException('Account group not found');
    } elseif ($model->user_id != $this->user->getId()) {
      throw new ForbiddenException("Account group is forbidden");
    }
    return $model->toEntity();
  }

  /**
   * Delete an account group by id
   *
   * @param integer $id
   * @return boolean
   */
  public function deleteAccountGroup(int $id): bool
  {
    $group = $this->getAccountGroupById($id);
    $model = AccountGroup::find($group->getId());
    $model->delete();
    return true;
  }

  /**
   * Save an account group and returns updated entity
   *
   * @param AccountGroupEntity $group
   * @return AccountGroupEntity
   * @throws ForbiddenException
   */
  public function saveAccountGroup(AccountGroupEntity $group): AccountGroupEntity
  {
    $model = new AccountGroup();
    if ($group->getId() > 0) {
      $model = AccountGroup::find($group->getId());
      if (!$model || $model->user_id != $this->user->getId()) {
        throw new ForbiddenException("Account group is forbidden");
      }
    }

    $model->user_id = $this->user->getId();
    $model->name = $group->getName();
    $model->sort = $group->getSort();
    $model->save();

    return $model->toEntity();
  }
}
