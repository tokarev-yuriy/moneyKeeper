<?php
namespace MoneyKeeper\Accounting\Entities;
use MoneyKeeper\Accounting\ValueObjects\AccountDescriptionValue;

/**
 * Account Entity class
 */
class AccountEntity extends ItemEntity {

    /**
     * Description of an account
     *
     * @var AccountDescriptionValue
     */
    private $description;

    /**
     * Create Account
     *
     * @param integer|null $id
     * @param AccountDescriptionValue $description
     * @param boolean $active
     */
    public function __construct(
        ?int $id, 
        AccountDescriptionValue $description, 
        bool $active = true
    )
    {
        $this->id = $id;
        $this->description = $description;
        $this->active = $active;
    }


    /**
     * Get description
     *
     * @return AccountDescriptionValue
     */
    public function getDescription(): AccountDescriptionValue
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param AccountDescriptionValue $description
     * @return void
     */
    public function setDescription(AccountDescriptionValue $description)
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
        return [
            'id' => $this->getId(),
            'active' => $this->getActive(),
            'name' => $this->getDescription()->getName(),
            'sort' => $this->getDescription()->getSort(),
            'icon' => $this->getDescription()->getIcon(),
        ];
    }
    
}
