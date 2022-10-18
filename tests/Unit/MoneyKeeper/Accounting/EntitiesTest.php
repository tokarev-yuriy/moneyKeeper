<?php

namespace Tests\Unit\MoneyKeeper\Accounting;

use Exception;
use Tests\TestCase;
use MoneyKeeper\Accounting\Entities\CategoryEntity;
use MoneyKeeper\Accounting\Entities\UserEntity;
use MoneyKeeper\Accounting\Entities\AccountEntity;
use MoneyKeeper\Accounting\ValueObjects\CategoryDescriptionValue;
use MoneyKeeper\Accounting\ValueObjects\TransactionTypeValue;
use MoneyKeeper\Accounting\ValueObjects\AccountDescriptionValue;
use MoneyKeeper\Accounting\Entities\AccountGroupEntity;

class EntitiesTest extends TestCase
{
    /**
     * Test CategoryDescriptionValue
     *
     * @return void
     * @covers CategoryDescriptionValue
     */
    public function testCategoryDescriptionException()
    {
        $this->expectException(Exception::class);
        $description = new CategoryDescriptionValue('', '', 10);
    }

    /**
     * Test TransactionTypeValue
     *
     * @return void
     * @covers TransactionTypeValue
     */
    public function testTransactionTypeException()
    {
        $this->expectException(Exception::class);
        $description = new TransactionTypeValue('test');
    }

    /**
     * Test CategoryEntity
     *
     * @return void
     * @covers CategoryEntity
     */
    public function testCategory()
    {
        $category = new CategoryEntity(
            null,
            new CategoryDescriptionValue('test', '', 10),
            TransactionTypeValue::income()
        );
        $this->assertTrue(true);
    }


    /**
     * Test AccountDescriptionValue
     *
     * @return void
     * @covers AccountDescriptionValue
     */
    public function testAccountDescriptionException()
    {
        $this->expectException(Exception::class);
        $description = new AccountDescriptionValue('', '', '', 10);
    }

    /**
     * Test AccountEntity
     *
     * @return void
     * @covers AccountEntity
     */
    public function testAccount()
    {
        $category = new AccountEntity(
            null,
            new AccountDescriptionValue('test', '', '', 10),
            100
        );
        $this->assertTrue(true);
    }

    /**
     * Test UserEntity
     *
     * @return void
     * @covers UserEntity
     */
    public function testUserExceptionEmail()
    {
        $this->expectException(Exception::class);
        $user = new UserEntity(null, '', 'test');
    }

    /**
     * Test UserEntity
     *
     * @return void
     * @covers UserEntity
     */
    public function testUserExceptionEmailWrong()
    {
        $this->expectException(Exception::class);
        $user = new UserEntity(null, 'test', 'test');
    }

    /**
     * Test UserEntity
     *
     * @return void
     * @covers UserEntity
     */
    public function testUserExceptionName()
    {
        $this->expectException(Exception::class);
        $user = new UserEntity(null, 'test@test.test', '');
    }

    /**
     * Test UserEntity
     *
     * @return void
     * @covers UserEntity
     */
    public function testUser()
    {
        $user = new UserEntity(null, 'test@test.test', 'test');
        $this->assertTrue(true);
    }


    /**
     * Test AccountGroupEntity
     *
     * @return void
     * @covers AccountGroupEntity
     */
    public function testAccountGroupExceptionName()
    {
        $this->expectException(Exception::class);
        $accountGroup = new AccountGroupEntity(null, '', '10');
    }

    /**
     * Test AccountGroupEntity
     *
     * @return void
     * @covers AccountGroupEntity
     */
    public function testAccountGroup()
    {
        $accountGroup = new AccountGroupEntity(null, 'test group', 10);
        $this->assertTrue(true);
    }
}
