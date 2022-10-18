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
     * Starting balance
     *
     * @var float
     */
    private $startBalance;

    /**
     * Account group id
     *
     * @var int|null
     */
    private $groupId;

    /**
     * Create Account
     *
     * @param integer|null $id
     * @param AccountDescriptionValue $description
     * @param float $startBalance
     * @param integer|null $groupId
     * @param boolean $active
     */
    public function __construct(
        ?int $id, 
        AccountDescriptionValue $description,
        float $startBalance,
        ?int $groupId = null,
        bool $active = true
    )
    {
        $this->id = $id;
        $this->description = $description;
        $this->startBalance = $startBalance;
        $this->groupId = $groupId;
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
     * Get Account group Id
     *
     * @return integer|null
     */
    public function getGroupId(): ?int
    {
        return $this->groupId;
    }

    /**
     * Set Account group Id
     *
     * @param integer|null $groupId
     * @return void
     */
    public function setGroupId(?int $groupId)
    {
        $this->groupId =  $groupId;
    }

    /**
     * Get start balance
     *
     * @return float
     */
    public function getStartBalance(): float
    {
        return $this->startBalance;
    }

    /**
     * Set start balance
     *
     * @param float $startBalance
     * @return void
     */
    public function setStartBalance(float $startBalance)
    {
        $this->startBalance =  $startBalance;
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
            'groupId' => $this->getGroupId(),
            'startBalance' => $this->getStartBalance(),
            'name' => $this->getDescription()->getName(),
            'sort' => $this->getDescription()->getSort(),
            'icon' => $this->getDescription()->getIcon(),
            'color' => $this->getDescription()->getColor(),
        ];
    }
    
}
