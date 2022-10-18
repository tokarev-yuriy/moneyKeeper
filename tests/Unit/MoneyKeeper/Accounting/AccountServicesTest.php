<?php

namespace Tests\Unit\MoneyKeeper\Accounting;

use DateTime;
use Exception;
use Illuminate\Support\Collection;
use MoneyKeeper\Accounting\Entities\AccountEntity;
use MoneyKeeper\Accounting\Entities\UserEntity;
use Tests\TestCase;
use MoneyKeeper\Accounting\Services\AccountServices;
use MoneyKeeper\Accounting\Repositories\IAccountsRepository;
use MoneyKeeper\Accounting\ValueObjects\AccountDescriptionValue;

class AccountServicesTest extends TestCase
{
    /**
     * Test AccountServices getById exception
     *
     * @return void
     * @covers AccountServices::getById
     */
    public function testAccountServiceGetByIdException()
    {
        $this->expectException(Exception::class);
        $service = new AccountServices($this->getNewUser(), $this->getEmptyRepository());
        $item = $service->getById(1);
    }

    /**
     * Test AccountServices getById exception
     *
     * @return void
     * @covers AccountServices::getById
     */
    public function testAccountServiceGetById()
    {
        $service = new AccountServices($this->getExistUser(), $this->getRepository());
        $item = $service->getById(1);
        $this->assertEquals($item->getId(), 1);
        $this->assertEquals($item->getDescription()->getName(), 'test');
        $this->assertEquals($item->getDescription()->getSort(), 10);
        $this->assertEquals($item->getStartBalance(), 100);

        $this->assertEquals($item->toArray(), [
            'id' => 1,
            'name' => 'test',
            'sort' => 10,
            'startBalance' => (float)100,
            'color' => 'red',
            'icon' => 'test',
            'groupId' => 1,
            'active' => true
        ]);
    }

    /**
     * Test AccountServices getAll exception
     *
     * @return void
     * @covers AccountServices::getAll
     */
    public function testAccountServiceGetAllException()
    {
        $this->expectException(Exception::class);
        $service = new AccountServices($this->getNewUser(), $this->getEmptyRepository());
        $items = $service->getAll();
    }

    /**
     * Test AccountServices getAll exception
     *
     * @return void
     * @covers AccountServices::getAll
     */
    public function testAccountServiceGetAll()
    {
        $service = new AccountServices($this->getExistUser(), $this->getRepository());
        $items = $service->getAll();
        $this->assertEquals(count($items), 2);
        $this->assertEquals($items[0]->getId(), 1);
        $this->assertEquals($items[0]->getDescription()->getName(), 'test');
        $this->assertEquals($items[0]->getDescription()->getSort(), 10);
        $this->assertEquals($items[1]->getId(), 2);
        $this->assertEquals($items[1]->getDescription()->getName(), 'test2');
        $this->assertEquals($items[1]->getDescription()->getSort(), 20);
    }

    /**
     * Test AccountServices update exception
     *
     * @return void
     * @covers AccountServices::update
     */
    public function testAccountServiceUpdateException()
    {
        $this->expectException(Exception::class);
        $service = new AccountServices($this->getNewUser(), $this->getEmptyRepository());
        $item = $service->update(1, ['name' => 'test2']);
    }

    /**
     * Test AccountServices update exception
     *
     * @return void
     * @covers AccountServices::update
     */
    public function testAccountServiceUpdate()
    {
        $service = new AccountServices($this->getExistUser(), $this->getRepository());
        $item = $service->update(1, [
            'name' => 'test2',
            'sort'=>10,
            'icon' => 'testIcon',
            'groupId' => 10,
            'color'=>'blue',
            'startBalance' => 110
        ]);
        $this->assertEquals($item->getId(), 1);
        $this->assertEquals($item->getDescription()->getName(), 'test2');
        $this->assertEquals($item->getDescription()->getSort(), 10);
        $this->assertEquals($item->getDescription()->getIcon(), 'testIcon');
        $this->assertEquals($item->getDescription()->getColor(), 'blue');
        $this->assertEquals($item->getGroupId(), 10);
        $this->assertEquals($item->getStartBalance(), 110);
    }

    /**
     * Test AccountServices add exception
     *
     * @return void
     * @covers AccountServices::add
     */
    public function testAccountServiceAddException()
    {
        $this->expectException(Exception::class);
        $service = new AccountServices($this->getNewUser(), $this->getEmptyRepository());
        $item = $service->add(['name' => 'test2']);
    }

    /**
     * Test AccountServices add exception
     *
     * @return void
     * @covers AccountServices::add
     */
    public function testAccountServiceAddInvalidException()
    {
        $this->expectException(Exception::class);
        $service = new AccountServices($this->getExistUser(), $this->getRepository());
        $item = $service->add(['sort' => 10]);
    }

    /**
     * Test AccountServices add exception
     *
     * @return void
     * @covers AccountServices::add
     */
    public function testAccountServiceAdd()
    {
        $service = new AccountServices($this->getExistUser(), $this->getRepository());
        $item = $service->add([
            'name' => 'test2',
            'sort' => 11,
            'icon' => 'testIcon',
            'groupId' => 10,
            'color'=>'blue',
            'startBalance' => 110
        ]);
        $this->assertEquals($item->getId(), null);
        $this->assertEquals($item->getDescription()->getName(), 'test2');
        $this->assertEquals($item->getDescription()->getSort(), 11);
        $this->assertEquals($item->getDescription()->getIcon(), 'testIcon');
        $this->assertEquals($item->getDescription()->getColor(), 'blue');
        $this->assertEquals($item->getGroupId(), 10);
        $this->assertEquals($item->getStartBalance(), 110);
    }

    /**
     * Test AccountServices delete exception
     *
     * @return void
     * @covers AccountServices::delete
     */
    public function testAccountServiceDeleteException()
    {
        $this->expectException(Exception::class);
        $service = new AccountServices($this->getNewUser(), $this->getEmptyRepository());
        $item = $service->delete(1);
    }

    /**
     * Test AccountServices delete
     *
     * @return void
     * @covers AccountServices::delete
     */
    public function testAccountServiceDelete()
    {
        $service = new AccountServices($this->getExistUser(), $this->getRepository());
        $this->assertTrue($service->delete(1));
    }

    /**
     * returns new user
     *
     * @return UserEntity
     */
    private function getNewUser(): UserEntity
    {
        return new UserEntity(null, 'test@test.com', 'test');
    }

    /**
     * returns existed user
     *
     * @return UserEntity
     */
    private function getExistUser(): UserEntity
    {
        return new UserEntity(1, 'test@test.com', 'test');
    }

    /**
     * returns empty repository
     *
     * @return IAccountsRepository
     */
    private function getEmptyRepository(): IAccountsRepository
    {
        $repository = $this->getMockBuilder(IAccountsRepository::class)->disableOriginalConstructor()->getMock();
        return $repository;
    }

    /**
     * returns full repository
     *
     * @return IAccountsRepository
     */
    private function getRepository(): IAccountsRepository
    {
        $repository = $this->getMockBuilder(IAccountsRepository::class)
                        ->setConstructorArgs([$this->getExistUser()])
                        ->getMock();
        $repository->method("getAccountById")->willReturn($this->getAccount());
        $repository->method("getAccounts")->willReturn(new Collection([
            new AccountEntity(1, new AccountDescriptionValue('test', 'test', 'red', 10), 100, 1), 
            new AccountEntity(2, new AccountDescriptionValue('test2', 'test2', 'red', 20), 200, 2)
        ]));
        $repository->method("saveAccount")->will($this->returnArgument(0));
        $repository->method("deleteAccount")->willReturn(true);
        return $repository;
    }

    /**
     * returns test Account
     *
     * @return AccountEntity
     */
    private function getAccount(): AccountEntity
    {
        return new AccountEntity(1, new AccountDescriptionValue('test', 'test', 'red', 10), 100, 1);
    }
}
