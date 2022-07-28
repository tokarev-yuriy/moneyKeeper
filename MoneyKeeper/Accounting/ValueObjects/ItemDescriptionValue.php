<?php
namespace MoneyKeeper\Accounting\ValueObjects;

use Exception;

/**
 * Item Description Value class
 */
class ItemDescriptionValue {

    /**
     * Name of an item
     *
     * @var string
     */
    protected $name = '';
    
    /**
     * Icon of an item
     *
     * @var string
     */
    protected $icon = '';

    /**
     * Sort index of an item
     *
     * @var int
     */
    protected $sort = 10;

    /**
     * Create category description
     *
     * @param string $name
     * @param string $icon
     * @param integer $sort
     * @throws Exception
     */
    public function __construct(string $name, string $icon, int $sort)
    {
        if (strlen($name)==0) {
            throw new Exception('Item name is required');
        }
        $this->name = $name;
        $this->icon = $icon;
        $this->sort = $sort;
    }

    /**
     * Name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Icon
     *
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * Sort
     *
     * @return int
     */
    public function getSort(): int
    {
        return $this->sort;
    }
}