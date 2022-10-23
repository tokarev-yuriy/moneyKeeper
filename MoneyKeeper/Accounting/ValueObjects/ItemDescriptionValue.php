<?php
namespace MoneyKeeper\Accounting\ValueObjects;

use Exception;
use MoneyKeeper\Exceptions\ValidationException;

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
        $errors = [];
        if (strlen($name)==0) {
            $errors['name'] = 'Account name is required';
        }
        $this->name = $name;
        $this->icon = $icon;
        $this->sort = $sort;
        if (count($errors) > 0) {
            throw new ValidationException($errors);
        }
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