<?php
namespace MoneyKeeper\Accounting\Services;

use Exception;
use Illuminate\Support\Collection;
use MoneyKeeper\Accounting\Entities\CategoryEntity;
use MoneyKeeper\Accounting\Entities\UserEntity;
use MoneyKeeper\Accounting\Repositories\ICategoriesRepository;
use MoneyKeeper\Accounting\ValueObjects\CategoryDescriptionValue;
use MoneyKeeper\Accounting\ValueObjects\TransactionTypeValue;
use MoneyKeeper\Exceptions\NotFoundException;
use MoneyKeeper\Exceptions\ValidationException;
use Throwable;

/**
 * Category services class
 */
class CategoryServices implements ICrudServices {

    /**
     * @var UserEntity
     */
    public UserEntity $user;
    /**
     * @var ICategoriesRepository
     */
    public ICategoriesRepository $repository;
    
    /**
     * Create a service with all dependencies
     *
     * @param UserEntity $user
     * @param ICategoriesRepository $repository
     */
    public function __construct(UserEntity $user, ICategoriesRepository $repository)
    {
        $this->user = $user;
        if (!$this->user->getId()) {
            throw new Exception('User not found');
        }
        $this->repository = $repository;
    }

    /**
     * Get category by id
     *
     * @param integer $id
     * @return CategoryEntity
     * @throws Exception
     */
    public function getById(int $id): CategoryEntity
    {
        $item = $this->repository->getCategoryById($id);
        if ($item->getId()!=$id) {
            throw new NotFoundException('Category not found');
        }
        return $item;
    }

    /**
     * Get all categories
     *
     * @return Collection
     * @throws Exception
     */
    public function getAll(): Collection
    {
        $items = $this->repository->getCategories();
        return $items;
    }

    /**
     * Updates a category
     *
     * @param int $id
     * @param array $fields
     * @return CategoryEntity
     * @throws NotFoundException
     */
    public function update(int $id, array $fields): CategoryEntity
    {
        $item = $this->repository->getCategoryById($id);
        if ($item->getId()!=$id) {
            throw new NotFoundException('Category not found');
        }
        $description = new CategoryDescriptionValue(
            $fields['name'] ?? '',
            $fields['icon'] ?? '',
            $fields['sort'] ?? 0
        );
        $this->validateDescription($description);
        $item->setDescription($description);
        $types = [];
        if(is_array($fields['types'])) {
            foreach($fields['types'] as $type) {
                $types[] = new TransactionTypeValue($type);
            }
        }
        $item->setTypes($types);

        $item = $this->repository->saveCategory($item);
        return $item;
    }

    /**
     * Add a category
     *
     * @param array $fields
     * @return CategoryEntity
     * @throws Exception
     */
    public function add(array $fields): CategoryEntity
    {
        $description = new CategoryDescriptionValue(
            $fields['name'] ?? '',
            $fields['icon'] ?? '',
            $fields['sort'] ?? 0
        );
        $this->validateDescription($description);
        $types = [];
        if(is_array($fields['types'])) {
            foreach($fields['types'] as $type) {
                $types[] = new TransactionTypeValue($type);
            }
        }
               
        $category = new CategoryEntity(null, $description, $types, true);
        $category = $this->repository->saveCategory($category);
        return $category;
    }

    /**
     * Delete a category
     *
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public function delete(int $id): bool
    {
        $item = $this->repository->getCategoryById($id);
        if ($item->getId()!=$id) {
            throw new NotFoundException('Category not found');
        }
        $this->repository->deleteCategory($id);
        return true;
    }

    /**
     * Validate description
     *
     * @param CategoryDescriptionValue $description
     * @return boolean
     * @throws ValidationException
     */
    protected function validateDescription(CategoryDescriptionValue $description): bool
    {
        $errors = [];
        if ($description->getIcon() && !$this->repository->getAvailIcons()->contains($description->getIcon())) {
            $errors['icon'] = 'Icon not found';
        }
        if (count($errors) > 0) {
            throw new ValidationException($errors);
        }
        return true;
    }
}
