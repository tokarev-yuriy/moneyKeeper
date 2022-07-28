<?php
namespace MoneyKeeper\Accounting\ValueObjects;
use Exception;

/**
 * Account Description Value class
 */
class AccountDescriptionValue extends ItemDescriptionValue {

    /**
     * Color of an Account 
     *
     * @var string
     */
    private $color;

    /**
     * Create Account description
     *
     * @param string $name
     * @param string $icon
     * @param string $color
     * @param integer $sort
     * @throws Exception
     */
    public function __construct(string $name, string $icon, string $color, int $sort)
    {
        if (strlen($name)==0) {
            throw new Exception('Account name is required');
        }
        $this->name = $name;
        $this->icon = $icon;
        $this->color = $color;
        $this->sort = $sort;
    }

    /**
     * Color
     *
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }
}