<?php
namespace MoneyKeeper\Accounting\Entities;
use Exception;

/**
 * Account Group Entity class
 */
class AccountGroupEntity extends ItemEntity {

    /**
     * Name of an account group
     *
     * @var string
     */
    private $name;

    /**
     * Sort index of an account group
     *
     * @var int
     */
    private $sort;

    /**
     * Create Account group
     *
     * @param integer|null $id
     * @param string $name
     * @param int $sort
     * @param boolean $active
     */
    public function __construct(
        ?int $id, 
        string $name, 
        int $sort,
        bool $active = true
    )
    {
        if (strlen($name) == 0) {
            throw new Exception('Name is required');
        }
        $this->id = $id;
        $this->name = $name;
        $this->sort = $sort;
        $this->active = $active;
    }


    /**
     * Get name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return void
     */
    public function setName(string $name)
    {
        $this->name =  $name;
    }

    /**
     * Get Sort
     *
     * @return int
     */
    public function getSort(): int
    {
        return $this->sort;
    }

    /**
     * Set sort
     *
     * @param int $sort
     * @return void
     */
    public function setSort(int $sort)
    {
        $this->sort =  $sort;
    }

    /**
     * Deactivate group
     *
     * @return void
     */
    public function deactivate()
    {
        $this->active =  false;
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
            'name' => $this->getName(),
            'sort' => $this->getSort()
        ];
    }
    
}
