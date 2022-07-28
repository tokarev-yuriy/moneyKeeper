<?php
namespace MoneyKeeper\Accounting\ValueObjects;

use Exception;

/**
 * Transaction Type Value class
 */
class TransactionTypeValue {

    /**
     * Income type
     */
    private const INCOME = 'income';
    /**
     * Spend type
     */
    private const SPEND = 'spend';
    /**
     * Transfer type
     */
    private const TRANSFER = 'transfer';

    /**
     * Type of a Transaction
     *
     * @var string
     */
    private $value = '';

    /**
     * Create Transaction type
     *
     * @param string $type
     * @throws Exception
     */
    public function __construct(string $type)
    {
        if (!in_array($type, [self::INCOME, self::SPEND, self::TRANSFER])) {
            throw new Exception('Unknown Transaction type ' . $type);
        }
        $this->value = $type;
    }

    /**
     * Create income type
     *
     * @return TransactionTypeValue
     */
    public static function income(): TransactionTypeValue
    {
        return new self(self::INCOME);
    }

    /**
     * Create spend type
     *
     * @return TransactionTypeValue
     */
    public static function spend(): TransactionTypeValue
    {
        return new self(self::SPEND);
    }

    /**
     * Create transfer type
     *
     * @return TransactionTypeValue
     */
    public static function transfer(): TransactionTypeValue
    {
        return new self(self::TRANSFER);
    }


    /**
     * Get type value
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}