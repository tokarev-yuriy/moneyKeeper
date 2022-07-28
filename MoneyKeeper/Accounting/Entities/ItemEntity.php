<?php
namespace MoneyKeeper\Accounting\Entities;
use MoneyKeeper\Accounting\ValueObjects\CategoryTypeValue;
use MoneyKeeper\Accounting\ValueObjects\CategoryDescriptionValue;

/**
 * Item Entity class
 */
class ItemEntity {

    /**
     * Id of an Item
     *
     * @var int|null
     */
    protected $id = false;

    /**
     * Activity of an Item
     *
     * @var bool
     */
    protected $active = true;

    /**
     * Create user item
     *
     * @param integer|null $id
     * @param boolean $active
     */
    public function __construct(
        ?int $id, 
        bool $active = true
    )
    {
        $this->id = $id;
        $this->active = $active;
    }

    /**
     * Get id
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set id
     *
     * @param int $id
     * @return void
     */
    public function setId(int $id)
    {
        $this->id =  $id;
    }

    /**
     * Get active
     *
     * @return bool
     */
    public function getActive(): bool
    {
        return $this->active;
    }

    /**
     * Set active
     *
     * @param bool $active
     * @return void
     */
    public function setActive(bool $active)
    {
        $this->active =  $active;
    }
}
