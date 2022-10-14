<?php
namespace MoneyKeeper\Accounting\ValueObjects;
use Exception;
use MoneyKeeper\Exceptions\ValidationException;

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
     * @throws ValidationException
     */
    public function __construct(string $name, string $icon, string $color, int $sort)
    {
        $errors = [];
        if (strlen($name)==0) {
            $errors['name'] = 'Account name is required';
        }
        $this->name = $name;
        $this->icon = $icon;
        $this->color = $color;
        $this->sort = $sort;
        if (count($errors) > 0) {
            throw new ValidationException($errors);
        }
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