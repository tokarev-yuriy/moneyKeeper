<?php
namespace MoneyKeeper\Accounting\Entities;
use MoneyKeeper\Exceptions\ValidationException;

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
     * @throws ValidationException
     */
    public function __construct(
        ?int $id, 
        string $name, 
        int $sort,
        bool $active = true
    )
    {
        $errors = [];
        if (strlen(trim($name)) == 0) {
            $errors['name'] = 'Name is required';
        }
        $this->id = $id;
        $this->name = $name;
        $this->sort = $sort;
        $this->active = $active;
        if (count($errors) >0) {
            throw new ValidationException($errors);
        }
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
        if (strlen(trim($name)) == 0) {
            throw new ValidationException(['name' => 'Name is required']);
        }
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
