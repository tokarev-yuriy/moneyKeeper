<?php
namespace MoneyKeeper\Accounting\Entities;

use Exception;

/**
 * User Entity class
 */
class UserEntity {

    /**
     * Id of a User
     *
     * @var int|null
     */
    private $id = null;
    
    /**
     * Email of a User
     *
     * @var string
     */
    private $email = '';

    /**
     * Name of a User
     *
     * @var string
     */
    private $name = '';

    /**
     * Create user item
     *
     * @param integer|null $id
     * @param string $email
     * @param string $name
     */
    public function __construct(
        ?int $id, 
        string $email, 
        string $name
    )
    {
        if (strlen($email) == 0) {
            throw new Exception('Email is required');
        }
        if (strlen($name) == 0) {
            throw new Exception('Name is required');
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Email is incorrect');
        }
        $this->id = $id;
        $this->email = $email;
        $this->name = $name;
    }

    /**
     * Returns id
     *
     * @return integer|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Returns name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns email
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}
