<?php

namespace Tests\Unit\MoneyKeeper\Accounting;

use DateTime;
use Exception;
use Illuminate\Support\Collection;
use MoneyKeeper\Accounting\Entities\AccountGroupEntity;
use MoneyKeeper\Accounting\Entities\UserEntity;
use Tests\TestCase;
use MoneyKeeper\Accounting\Services\AccountsGroupService;
use MoneyKeeper\Accounting\Repositories\IAccountsRepository;
use MoneyKeeper\Accounting\Services\AccountGroupService;

class AccountsGroupServiceTest extends TestCase
{
    /**
     * Test AccountsGroupService getById exception
     *
     * @return void
     * @covers AccountsGroupService::getById
     */
    public function testAccountGroupServiceGetByIdException()
    {
        $this->expectException(Exception::class);
        $service = new AccountGroupService($this->getNewUser(), $this->getEmptyRepository());
        $group = $service->getById(1);
    }

    /**
     * Test AccountsGroupService getById exception
     *
     * @return void
     * @covers AccountsGroupService::getById
     */
    public function testAccountGroupServiceGetById()
    {
        $service = new AccountGroupService($this->getExistUser(), $this->getRepository());
        $group = $service->getById(1);
        $this->assertEquals($group->getId(), 1);
        $this->assertEquals($group->getName(), 'test');
        $this->assertEquals($group->getSort(), 10);
    }

    /**
     * Test AccountsGroupService getAll exception
     *
     * @return void
     * @covers AccountsGroupService::getAll
     */
    public function testAccountGroupServiceGetAllException()
    {
        $this->expectException(Exception::class);
        $service = new AccountGroupService($this->getNewUser(), $this->getEmptyRepository());
        $group = $service->getAll();
    }

    /**
     * Test AccountsGroupService getAll exception
     *
     * @return void
     * @covers AccountsGroupService::getAll
     */
    public function testAccountGroupServiceGetAll()
    {
        $service = new AccountGroupService($this->getExistUser(), $this->getRepository());
        $groups = $service->getAll();
        $this->assertEquals(count($groups), 2);
        $this->assertEquals($groups[0]->getId(), 1);
        $this->assertEquals($groups[0]->getName(), 'test');
        $this->assertEquals($groups[0]->getSort(), 10);
        $this->assertEquals($groups[1]->getId(), 2);
        $this->assertEquals($groups[1]->getName(), 'test2');
        $this->assertEquals($groups[1]->getSort(), 20);
    }

    /**
     * Test AccountsGroupService update exception
     *
     * @return void
     * @covers AccountsGroupService::update
     */
    public function testAccountGroupServiceUpdateException()
    {
        $this->expectException(Exception::class);
        $service = new AccountGroupService($this->getNewUser(), $this->getEmptyRepository());
        $group = $service->update(1, ['name' => 'test2']);
    }

    /**
     * Test AccountsGroupService update exception
     *
     * @return void
     * @covers AccountsGroupService::update
     */
    public function testAccountGroupServiceUpdate()
    {
        $service = new AccountGroupService($this->getExistUser(), $this->getRepository());
        $group = $service->update(1, ['name' => 'test2']);
        $this->assertEquals($group->getId(), 1);
        $this->assertEquals($group->getName(), 'test2');
        $this->assertEquals($group->getSort(), 10);
    }

    /**
     * Test AccountsGroupService add exception
     *
     * @return void
     * @covers AccountsGroupService::add
     */
    public function testAccountGroupServiceAddException()
    {
        $this->expectException(Exception::class);
        $service = new AccountGroupService($this->getNewUser(), $this->getEmptyRepository());
        $group = $service->add(['name' => 'test2']);
    }

    /**
     * Test AccountsGroupService add exception
     *
     * @return void
     * @covers AccountsGroupService::add
     */
    public function testAccountGroupServiceAddInvalidException()
    {
        $this->expectException(Exception::class);
        $service = new AccountGroupService($this->getExistUser(), $this->getRepository());
        $group = $service->add(['sort' => 10]);
    }

    /**
     * Test AccountsGroupService add exception
     *
     * @return void
     * @covers AccountsGroupService::add
     */
    public function testAccountGroupServiceAdd()
    {
        $service = new AccountGroupService($this->getExistUser(), $this->getRepository());
        $group = $service->add(['name' => 'test2', 'sort' => 11]);
        $this->assertEquals($group->getId(), null);
        $this->assertEquals($group->getName(), 'test2');
        $this->assertEquals($group->getSort(), 11);
    }

    /**
     * Test AccountsGroupService delete exception
     *
     * @return void
     * @covers AccountsGroupService::delete
     */
    public function testAccountGroupServiceDeleteException()
    {
        $this->expectException(Exception::class);
        $service = new AccountGroupService($this->getNewUser(), $this->getEmptyRepository());
        $group = $service->delete(1);
    }

    /**
     * Test AccountsGroupService delete
     *
     * @return void
     * @covers AccountsGroupService::delete
     */
    public function testAccountGroupServiceDelete()
    {
        $service = new AccountGroupService($this->getExistUser(), $this->getRepository());
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
        $repository->method("getAccountGroupById")->willReturn($this->getGroup());
        $repository->method("getAccountGroups")->willReturn(new Collection([new AccountGroupEntity(1, 'test', 10), new AccountGroupEntity(2, 'test2', 20)]));
        $repository->method("saveAccountGroup")->will($this->returnArgument(0));
        $repository->method("deleteAccountGroup")->willReturn(true);
        return $repository;
    }

    /**
     * returns test Account Group
     *
     * @return AccountGroupEntity
     */
    private function getGroup(): AccountGroupEntity
    {
        return new AccountGroupEntity(1, 'test', 10);
    }
}
