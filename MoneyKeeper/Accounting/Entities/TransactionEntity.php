<?php
namespace MoneyKeeper\Accounting\Entities;

use DateTime;
use Exception;
use MoneyKeeper\Accounting\ValueObjects\TransactionTypeValue;

/**
 * Transaction Entity class
 */
class TransactionEntity {

    /**
     * @var integer|null Id
     */
    private ?int $id;

    /**
     * @var TransactionTypeValue type of a transaction
     */
    private TransactionTypeValue $type;

    /**
     * @var float value of a transaction
     */
    private float $value;

    /**
     * @var string
     */
    private string $comment;

    /**
     * @var CategoryEntity
     */
    private CategoryEntity $category;

    /**
     * @var DateTime
     */
    private DateTime $date;

        
    /**
     * @var AccountEntity source account
     */
    private AccountEntity $accountSrc;

    /**
     * @var ?AccountEntity destination account (required for transfer transactions)
     */
    private AccountEntity $accountDest;

    /**
     * Create transaction
     *
     * @param integer|null $id
     * @param TransactionTypeValue $type
     * @param float $value
     * @param string $comment
     * @param DateTime $date
     * @param AccountEntity $accountSrc
     * @param AccountEntity|null $accountDest
     * @throws Exception
     */
    public function __construct(
        ?int $id, 
        TransactionTypeValue $type,
        float $value,
        string $comment,
        DateTime $date,
        AccountEntity $accountSrc,
        ?AccountEntity $accountDest = null
    )
    {
        if (!$accountSrc->getId()) {
            throw new Exception('Source Account is required');
        }
        if ($type->isTransfer() && ($accountDest == null || !$accountDest->getId())) {
            throw new Exception('Destination Account is required');
        }
        
        $this->id = $id;
        $this->type = $type;
        $this->value = $value;
        $this->comment = $comment;
        $this->date = $date;
        $this->accountSrc = $accountSrc;
        if ($type->isTransfer()) {
            $this->accountDest = $accountDest;
        }
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
     * Get value
     *
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    
    /**
     * Get type
     *
     * @return TransactionTypeValue
     */
    public function getType(): TransactionTypeValue
    {
        return $this->type;
    }

    /**
     * Get date
     *
     * @return DateTime
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * Get source account
     *
     * @return AccountEntity
     */
    public function getAccountSrc(): AccountEntity
    {
        return $this->accountSrc;
    }

    /**
     * Get destination account
     *
     * @return AccountEntity|null
     */
    public function getAccountDest(): ?AccountEntity
    {
        return $this->accountDest;
    }

    /**
     * Set value
     *
     * @param float $value
     * @return void
     */
    public function setValue(float $value)
    {
        $this->value =  $value;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return void
     */
    public function setComment(string $comment)
    {
        $this->comment =  $comment;
    }

    /**
     * Set date
     *
     * @param DateTime $date
     * @return void
     */
    public function setDate(DateTime $date)
    {
        $this->date =  $date;
    }

    /**
     * Set type and accounts
     *
     * @param TransactionTypeValue $type
     * @param AccountEntity $accountSrc
     * @param AccountEntity|null $accountDest
     * @return void
     * 
     * @throws Exception
     */
    public function setTypeAndAccounts(TransactionTypeValue $type, AccountEntity $accountSrc, ?AccountEntity $accountDest = null)
    {
        if (!$accountSrc->getId()) {
            throw new Exception('Source Account is required');
        }
        if ($type->isTransfer() && ($accountDest==null || !$accountDest->getId())) {
            throw new Exception('Destination Account is required');
        }
        $this->type = $type;
        $this->accountSrc = $accountSrc;
        if ($type->isTransfer()) {
            $this->accountDest = $accountDest;
        }
    }
    
}
