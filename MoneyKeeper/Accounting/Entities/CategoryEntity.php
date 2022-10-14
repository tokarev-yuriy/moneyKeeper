<?php
namespace MoneyKeeper\Accounting\Entities;
use MoneyKeeper\Accounting\ValueObjects\TransactionTypeValue;
use MoneyKeeper\Accounting\ValueObjects\CategoryDescriptionValue;

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
     * @var TransactionTypeValue
     */
    private $type;

    /**
     * Create category
     *
     * @param integer|null $id
     * @param CategoryDescriptionValue $description
     * @param TransactionTypeValue $type
     * @param boolean $active
     */
    public function __construct(
        ?int $id,
        CategoryDescriptionValue $description,
        TransactionTypeValue $type,
        bool $active = true
    )
    {
        $this->id = $id;
        $this->description = $description;
        $this->type = $type;
        $this->active = $active;
    }


    /**
     * Get type
     *
     * @return TransactionTypeValue
     */
    public function getType(): TransactionTypeValue
    {
        return $this->type;
    }

    /**
     * Set type
     *
     * @param TransactionTypeValue $type
     * @return void
     */
    public function setType(TransactionTypeValue $type)
    {
        $this->type =  $type;
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
}
