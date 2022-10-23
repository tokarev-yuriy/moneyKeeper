<?php
namespace App\MoneyKeeper\Accounting\Repositories;

use App\MoneyKeeper\Models\Category;
use Illuminate\Support\Collection;
use MoneyKeeper\Accounting\Entities\CategoryEntity;
use MoneyKeeper\Accounting\Entities\UserEntity;
use MoneyKeeper\Accounting\Repositories\ICategoriesRepository;
use MoneyKeeper\Accounting\ValueObjects\TransactionTypeValue;
use MoneyKeeper\Exceptions\ForbiddenException;
use MoneyKeeper\Exceptions\NotFoundException;

/**
 * Eloquent realisation of categories repository
 */
final class CategoriesEloquentRepository implements ICategoriesRepository {

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
   * Returns a collection of user's categories filtered by type
   *
   * @param TransactionTypeValue|null $type
   * @return Collection of AccountEntity
   */
  public function getCategories(?TransactionTypeValue $type = null): Collection
  {
    $items = new Collection();
    $list = Category::where('user_id', '=', $this->user->getId())->get();
    foreach($list as $model) {
      $items->add($model->toEntity());
    }
    return $items;
  }

  /**
   * Returns an category entity
   *
   * @param integer $id
   * @return CategoryEntity
   */
  public function getCategoryById(int $id): CategoryEntity
  {
    $model = Category::find($id);
    if (!$model) {
      throw new NotFoundException('Category not found');
    } elseif ($model->user_id != $this->user->getId()) {
      throw new ForbiddenException("Category is forbidden");
    }
    return $model->toEntity();
  }

  /**
   * Delete an account by id
   *
   * @param integer $id
   * @return boolean
   */
  public function deleteCategory(int $id): bool
  {
    $item = $this->getCategoryById($id);
    $model = Category::find($item->getId());
    $model->active = false;
    $model->save();
    return true;
  }

  /**
   * Save an category and returns updated entity
   *
   * @param CategoryEntity $category
   * @return CategoryEntity
   */
  public function saveCategory(CategoryEntity $category): CategoryEntity
  {
    $model = new Category();
    if ($category->getId() > 0) {
      $model = Category::find($category->getId());
      if (!$model || $model->user_id != $this->user->getId()) {
        throw new ForbiddenException("Account is forbidden");
      }
    }

    $model->user_id = $this->user->getId();
    $model->name = $category->getDescription()->getName();
    $model->sort = $category->getDescription()->getSort();
    $model->icon = $category->getDescription()->getIcon();
    $model->types = $category->getTypesArray();
    $model->save();

    return $model->toEntity();
  }

  /**
   * returns avail icons
   *
   * @return Collection
   */
  public function getAvailIcons(): Collection
  {
    return new Collection([
      'car',
      'tv',
      'shopping-basket',
      'child',
      'phone',
      'plane',
      'gift',
      'utensils',
      'pump-soap',
      'tshirt',
      'glass-cheers',
      'hand-holding-medical',
      'laptop-house',
      'couch',
      'user-tie',
      'tools',
      'swimmer',
      'cocktail',
      'globe',
      'code',
      'laptop-code',
      'diagnoses',
      'hands',
      'wrench',
      'weight-hanging',
      'certificate',
      'magic',
      'female',
      'taxi',
      'apple',
    ]);
  }
}
