<?php

namespace Tests\Unit\MoneyKeeper\Accounting;

use App\Exceptions\ValidationException;
use DateTime;
use Exception;
use Illuminate\Support\Collection;
use MoneyKeeper\Accounting\Entities\CategoryEntity;
use MoneyKeeper\Accounting\Entities\UserEntity;
use Tests\TestCase;
use MoneyKeeper\Accounting\Services\CategoryServices;
use MoneyKeeper\Accounting\Repositories\ICategoriesRepository;
use MoneyKeeper\Accounting\ValueObjects\CategoryDescriptionValue;
use MoneyKeeper\Accounting\ValueObjects\TransactionTypeValue;
use MoneyKeeper\Exceptions\NotFoundException;
use MoneyKeeper\Exceptions\ValidationException as ExceptionsValidationException;

class CategoryServicesTest extends TestCase
{
    /**
     * Test CategoryServices getById exception
     *
     * @return void
     * @covers CategoryServices::getById
     */
    public function testCategoryServiceGetByIdException()
    {
        $this->expectException(Exception::class);
        $service = new CategoryServices($this->getNewUser(), $this->getEmptyRepository());
        $item = $service->getById(1);
    }

    /**
     * Test CategoryServices getById exception
     *
     * @return void
     * @covers CategoryServices::getById
     */
    public function testCategoryServiceGetById()
    {
        $service = new CategoryServices($this->getExistUser(), $this->getRepository());
        $item = $service->getById(1);
        $this->assertEquals($item->getId(), 1);
        $this->assertEquals($item->getDescription()->getName(), 'test');
        $this->assertEquals($item->getDescription()->getSort(), 10);
        $this->assertEquals($item->getTypes(), [TransactionTypeValue::income()]);

        $this->assertEquals($item->toArray(), [
            'id' => 1,
            'name' => 'test',
            'sort' => 10,
            'icon' => 'test',
            'types' => ['income'],
            'active' => true
        ]);
    }

    /**
     * Test CategoryServices getAll exception
     *
     * @return void
     * @covers CategoryServices::getAll
     */
    public function testCategoryServiceGetAllException()
    {
        $this->expectException(Exception::class);
        $service = new CategoryServices($this->getNewUser(), $this->getEmptyRepository());
        $items = $service->getAll();
    }

    /**
     * Test CategoryServices getAll exception
     *
     * @return void
     * @covers CategoryServices::getAll
     */
    public function testCategoryServiceGetAll()
    {
        $service = new CategoryServices($this->getExistUser(), $this->getRepository());
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
     * Test CategoryServices update exception
     *
     * @return void
     * @covers CategoryServices::update
     */
    public function testCategoryServiceUpdateException()
    {
        $this->expectException(Exception::class);
        $service = new CategoryServices($this->getNewUser(), $this->getEmptyRepository());
        $item = $service->update(1, ['name' => 'test2']);
    }

    /**
     * Test CategoryServices update exception
     *
     * @return void
     * @covers CategoryServices::update
     */
    public function testCategoryServiceUpdate()
    {
        $service = new CategoryServices($this->getExistUser(), $this->getRepository());
        $item = $service->update(1, [
            'name' => 'test2',
            'sort'=>10,
            'icon' => 'testIcon',
            'types' => ['spend'],
        ]);
        $this->assertEquals($item->getId(), 1);
        $this->assertEquals($item->getDescription()->getName(), 'test2');
        $this->assertEquals($item->getDescription()->getSort(), 10);
        $this->assertEquals($item->getDescription()->getIcon(), 'testIcon');
        $this->assertEquals($item->getTypes(), [TransactionTypeValue::spend()]);
    }

    /**
     * Test CategoryServices add exception
     *
     * @return void
     * @covers CategoryServices::add
     */
    public function testCategoryServiceAddException()
    {
        $this->expectException(Exception::class);
        $service = new CategoryServices($this->getNewUser(), $this->getEmptyRepository());
        $item = $service->add(['name' => 'test2']);
    }

    /**
     * Test CategoryServices add exception
     *
     * @return void
     * @covers CategoryServices::add
     */
    public function testCategoryServiceAddInvalidException()
    {
        $this->expectException(Exception::class);
        $service = new CategoryServices($this->getExistUser(), $this->getRepository());
        $item = $service->add(['sort' => 10]);
    }

    /**
     * Test CategoryServices add exception
     *
     * @return void
     * @covers CategoryServices::add
     */
    public function testCategoryServiceAddTypesException()
    {
        $this->expectException(ExceptionsValidationException::class);
        $service = new CategoryServices($this->getExistUser(), $this->getRepository());
        $item = $service->add([
            'name' => 'test2',
            'sort' => 11,
            'types' => [],
        ]);
    }

    /**
     * Test CategoryServices add exception
     *
     * @return void
     * @covers CategoryServices::add
     */
    public function testCategoryServiceAddIconException()
    {
        $this->expectException(ExceptionsValidationException::class);
        $service = new CategoryServices($this->getExistUser(), $this->getRepository());
        $item = $service->add([
            'name' => 'test2',
            'sort' => 11,
            'icon' => 'icon',
        ]);
    }

    /**
     * Test CategoryServices add exception
     *
     * @return void
     * @covers CategoryServices::add
     */
    public function testCategoryServiceUnknownTypesException()
    {
        $this->expectException(NotFoundException::class);
        $service = new CategoryServices($this->getExistUser(), $this->getRepository());
        $item = $service->add([
            'name' => 'test2',
            'sort' => 11,
            'types' => ['not_existed']
        ]);
    }

    /**
     * Test CategoryServices add exception
     *
     * @return void
     * @covers CategoryServices::add
     */
    public function testCategoryServiceAdd()
    {
        $service = new CategoryServices($this->getExistUser(), $this->getRepository());
        $item = $service->add([
            'name' => 'test2',
            'sort' => 11,
            'icon' => 'testIcon',
            'types' => ['income'],
        ]);
        $this->assertEquals($item->getId(), null);
        $this->assertEquals($item->getDescription()->getName(), 'test2');
        $this->assertEquals($item->getDescription()->getSort(), 11);
        $this->assertEquals($item->getDescription()->getIcon(), 'testIcon');
        $this->assertEquals($item->getTypes(), [TransactionTypeValue::income()]);

        $item = $service->add([
            'name' => 'test2',
            'sort' => 11,
            'types' => ['spend', 'transfer']
        ]);
        $this->assertEquals($item->getId(), null);
        $this->assertEquals($item->getDescription()->getName(), 'test2');
        $this->assertEquals($item->getDescription()->getSort(), 11);
        $this->assertEquals($item->getDescription()->getIcon(), '');
        $this->assertEquals($item->getTypes(), [TransactionTypeValue::spend(), TransactionTypeValue::transfer()]);
    }

    /**
     * Test CategoryServices delete exception
     *
     * @return void
     * @covers CategoryServices::delete
     */
    public function testCategoryServiceDeleteException()
    {
        $this->expectException(Exception::class);
        $service = new CategoryServices($this->getNewUser(), $this->getEmptyRepository());
        $item = $service->delete(1);
    }

    /**
     * Test CategoryServices delete
     *
     * @return void
     * @covers CategoryServices::delete
     */
    public function testCategoryServiceDelete()
    {
        $service = new CategoryServices($this->getExistUser(), $this->getRepository());
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
     * @return ICategoriesRepository
     */
    private function getEmptyRepository(): ICategoriesRepository
    {
        $repository = $this->getMockBuilder(ICategoriesRepository::class)->disableOriginalConstructor()->getMock();
        return $repository;
    }

    /**
     * returns full repository
     *
     * @return ICategoriesRepository
     */
    private function getRepository(): ICategoriesRepository
    {
        $repository = $this->getMockBuilder(ICategoriesRepository::class)
                        ->setConstructorArgs([$this->getExistUser()])
                        ->getMock();
        $repository->method("getCategoryById")->willReturn($this->getCategory());
        $repository->method("getCategories")->willReturn(new Collection([
            new CategoryEntity(1, new CategoryDescriptionValue('test', 'test', 10), [TransactionTypeValue::income()]), 
            new CategoryEntity(2, new CategoryDescriptionValue('test2', 'test2', 20), [TransactionTypeValue::spend()])
        ]));
        $repository->method("saveCategory")->will($this->returnArgument(0));
        $repository->method("deleteCategory")->willReturn(true);
        $repository->method("getAvailIcons")->willReturn(new Collection(['testIcon']));

        return $repository;
    }

    /**
     * returns test category
     *
     * @return CategoryEntity
     */
    private function getCategory(): CategoryEntity
    {
        return new CategoryEntity(1, new CategoryDescriptionValue('test', 'test', 10), [TransactionTypeValue::income()]);
    }
}
