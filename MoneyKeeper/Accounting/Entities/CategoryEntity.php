<?php
namespace MoneyKeeper\Accounting\Entities;
use MoneyKeeper\Accounting\ValueObjects\TransactionTypeValue;
use MoneyKeeper\Accounting\ValueObjects\CategoryDescriptionValue;
use MoneyKeeper\Exceptions\ValidationException;

/**
 * Category Entity class
 */
class CategoryEntity extends ItemEntity {

    /**
     * Description of a Category
     *
     * @var CategoryDescriptionValue
     */
    private $description;

    /**
     * Type of a Category
     *
     * @var array of TransactionTypeValue
     */
    private $types;

    /**
     * Create category
     *
     * @param integer|null $id
     * @param CategoryDescriptionValue $description
     * @param array $types
     * @param boolean $active
     */
    public function __construct(
        ?int $id,
        CategoryDescriptionValue $description,
        array $types,
        bool $active = true
    )
    {
        $this->id = $id;
        $this->description = $description;
        $this->setTypes($types);
        $this->active = $active;
    }


    /**
     * Get types
     *
     * @return array of TransactionTypeValue
     */
    public function getTypes(): array
    {
        return $this->types;
    }

    /**
     * Set types
     *
     * @param array $type
     * @return void
     */
    public function setTypes(array $types)
    {
        if (count($types) == 0) {
            throw new ValidationException(['types' => 'Types are required']);
        }
        $this->types =  $types;
    }

    /**
     * Get description
     *
     * @return CategoryDescriptionValue
     */
    public function getDescription(): CategoryDescriptionValue
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param CategoryDescriptionValue $description
     * @return void
     */
    public function setDescription(CategoryDescriptionValue $description)
    {
        $this->description =  $description;
    }

    /**
     * Return fields
     *
     * @return array
     */
    public function toArray(): array
    {
        $types = [];
        foreach($this->types as $type) {
            /**
             * @var TransactionTypeValue $type
             */
            $types[] = $type->getValue();
        }
        return [
            'id' => $this->getId(),
            'active' => $this->getActive(),
            'name' => $this->getDescription()->getName(),
            'sort' => $this->getDescription()->getSort(),
            'icon' => $this->getDescription()->getIcon(),
            'types' => $types
        ];
    }
}
