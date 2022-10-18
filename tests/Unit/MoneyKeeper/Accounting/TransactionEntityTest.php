<?php

namespace Tests\Unit\MoneyKeeper\Accounting;

use DateTime;
use Exception;
use Tests\TestCase;
use MoneyKeeper\Accounting\Entities\TransactionEntity;
use MoneyKeeper\Accounting\Entities\AccountEntity;
use MoneyKeeper\Accounting\ValueObjects\AccountDescriptionValue;
use MoneyKeeper\Accounting\ValueObjects\TransactionTypeValue;

class TransactionEntityTest extends TestCase
{
    /**
     * Test TransactionEntity exception
     *
     * @return void
     * @covers TransactionEntity
     */
    public function testTransactionSrcException()
    {
        $this->expectException(Exception::class);
        $transaction = new TransactionEntity(null, TransactionTypeValue::income(), 1, '', new DateTime(), $this->getNewAccount());
    }

    /**
     * Test TransactionEntity exception
     *
     * @return void
     * @covers TransactionEntity
     */
    public function testTransactionDestException()
    {
        $this->expectException(Exception::class);
        $transaction = new TransactionEntity(null, TransactionTypeValue::transfer(), 1, '', new DateTime(), $this->getExistAccount());
    }

     /**
     * Test TransactionEntity exception
     *
     * @return void
     * @covers TransactionEntity
     */
    public function testTransactionNewDestException()
    {
        $this->expectException(Exception::class);
        $transaction = new TransactionEntity(null, TransactionTypeValue::transfer(), 1, '', new DateTime(), $this->getExistAccount(), $this->getNewAccount());
    }

    /**
     * Test TransactionEntity
     *
     * @return void
     * @covers TransactionEntity
     */
    public function testTransaction()
    {
        $transaction = new TransactionEntity(null, TransactionTypeValue::income(), 10, '', new DateTime(), $this->getExistAccount());
        $this->assertEquals($transaction->getValue(), 10);
        $this->assertEquals($transaction->getType()->getValue(), TransactionTypeValue::income()->getValue());

        $transaction = new TransactionEntity(null, TransactionTypeValue::spend(), 11, '', new DateTime(), $this->getExistAccount());
        $this->assertEquals($transaction->getValue(), 11);
        $this->assertEquals($transaction->getType()->getValue(), TransactionTypeValue::spend()->getValue());

        $transaction = new TransactionEntity(null, TransactionTypeValue::transfer(), 12, '', new DateTime(), $this->getExistAccount(), $this->getExistAccount());
        $this->assertEquals($transaction->getValue(), 12);
        $this->assertEquals($transaction->getType()->getValue(), TransactionTypeValue::transfer()->getValue());
    }

    /**
     * returns new account
     *
     * @return AccountEntity
     */
    private function getNewAccount(): AccountEntity
    {
        return new AccountEntity(null, new AccountDescriptionValue('test', 'test', '', 10), 0);
    }

    /**
     * returns existed account
     *
     * @return AccountEntity
     */
    private function getExistAccount(): AccountEntity
    {
        return new AccountEntity(1, new AccountDescriptionValue('test', 'test', '', 10), 0);
    }
}
