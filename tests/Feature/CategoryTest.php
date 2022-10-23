<?php

namespace Tests\Feature;

use App\Http\Controllers\CategoryController;
use App\MoneyKeeper\Models\Category;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class CategoryTest extends TestCase
{

    use RefreshDatabase;
    protected $seed = true;

    /**
     * test for CategoryController::list
     *
     * @return void
     * @covers CategoryController::list
     */
    public function testCategoryList()
    {
        $response = $this->get('/app/categories');

        $response->assertStatus(401);
        $this->assertFalse($response['success']);

        $user = User::find(1);
        $response = $this->actingAs($user)->get('/app/categories');

        $response->assertStatus(200);
        $this->assertTrue($response['success']);
        $this->assertEquals(count($response['items']), 3);

        $user = User::find(2);
        $response = $this->actingAs($user)->get('/app/categories');

        $response->assertStatus(200);
        $this->assertTrue($response['success']);
        $this->assertEquals(count($response['items']), 1);
    }


    /**
     * test for CategoryController::add
     *
     * @return void
     * @covers CategoryController::add
     */
    public function testCategoryAdd()
    {
        $response = $this->post('/app/categories');

        $response->assertStatus(401);
        $this->assertFalse($response['success']);

        $user = User::find(1);
        $response = $this->actingAs($user)->post('/app/categories',
            [
                'name' => '',
            ]
        );

        $response->assertStatus(400);
        $this->assertFalse($response['success']);
        $this->assertEquals(array_keys($response['errors']), ['name']);

        $user = User::find(1);
        $response = $this->actingAs($user)->post('/app/categories',
            [
                'name' => 'test',
                'types' => [],
            ]
        );

        $response->assertStatus(400);
        $this->assertFalse($response['success']);
        $this->assertEquals(array_keys($response['errors']), ['types']);

        $user = User::find(1);
        $response = $this->actingAs($user)->post('/app/categories',
            [
                'name' => 'test',
                'types' => ['test'],
            ]
        );

        $response->assertStatus(404);
        $this->assertFalse($response['success']);
        $user = User::find(2);
        $response = $this->actingAs($user)->post('/app/categories',
            [
                'name' => 'test add',
                'types' => ['income'],
            ]
        );

        $response->assertStatus(200);
        $this->assertTrue($response['success']);
        $this->assertEquals($response['item']['name'], 'test add');
        $this->assertTrue($response['item']['id'] > 0);
        $this->assertDatabaseHas('categories', [
            'name' => 'test add',
            'user_id' => 2,
            'types' => json_encode(['income'])
        ]);

        $user = User::find(1);
        $response = $this->actingAs($user)->post('/app/categories',
            [
                'name' => 'test add 2',
                'sort' => 10,
                'types' => ['income', 'spend']
            ]
        );

        $response->assertStatus(200);
        $this->assertTrue($response['success']);
        $this->assertEquals($response['item']['name'], 'test add 2');
        $this->assertEquals($response['item']['sort'], 10);
        $this->assertDatabaseHas('categories', [
            'name' => 'test add 2',
            'user_id' => 1,
            'types' => json_encode(['income', 'spend'])
        ]);
        $this->assertTrue($response['item']['id'] > 0);
    }

    /**
     * test for CategoryController::update
     *
     * @return void
     * @covers CategoryController::update
     */
    public function testCategoryUpdate()
    {
        $response = $this->put('/app/categories/1');

        $response->assertStatus(401);
        $this->assertFalse($response['success']);

        $user = User::find(2);
        $response = $this->actingAs($user)->put('/app/categories/1',
            [
            'name' => 'test add',
            ]
        );
        $response->assertStatus(403);
        $this->assertFalse($response['success']);

        $user = User::find(1);
        $response = $this->actingAs($user)->put('/app/categories/1',
            [
                'name' => "",
                'sort' => 20
            ]
        );
        $response->assertStatus(400);
        $this->assertFalse($response['success']);
        $this->assertEquals(array_keys($response['errors']), ['name']);

        $user = User::find(1);
        $response = $this->actingAs($user)->put('/app/categories/1',
            [
                'name' => 'test add',
                'types' => ['income', 'spend']
            ]
        );

        $response->assertStatus(200);
        $this->assertTrue($response['success']);
        $this->assertEquals($response['item']['name'], 'test add');
        $this->assertTrue($response['item']['id'] > 0);
        $this->assertDatabaseHas('categories', [
            'name' => 'test add',
            'user_id' => 1,
            'types' => json_encode(['income', 'spend'])
        ]);

        $user = User::find(1);
        $response = $this->actingAs($user)->put('/app/categories/2',
            [
                'name' => 'test add 2',
                'sort' => 10,
                'types' => ['income', 'transfer']
            ]
        );

        $response->assertStatus(200);
        $this->assertTrue($response['success']);
        $this->assertEquals($response['item']['name'], 'test add 2');
        $this->assertEquals($response['item']['sort'], 10);
        $this->assertDatabaseHas('categories', [
            'name' => 'test add 2',
            'user_id' => 1,
            'types' => json_encode(['income', 'transfer']),
        ]);
        $this->assertTrue($response['item']['id'] > 0);
    }


    /**
     * test for CategoryController::delete
     *
     * @return void
     * @covers CategoryController::delete
     */
    public function testCategoryDelete()
    {
        $response = $this->delete('/app/categories/1');

        $response->assertStatus(401);
        $this->assertFalse($response['success']);

        $user = User::find(2);
        $response = $this->actingAs($user)->delete('/app/categories/1');
        $response->assertStatus(403);
        $this->assertFalse($response['success']);

        $user = User::find(1);
        $response = $this->actingAs($user)->delete('/app/categories/1');
        $response->assertStatus(200);
        $this->assertTrue($response['success']);

        $user = User::find(1);
        $response = $this->actingAs($user)->delete('/app/categories/11111');
        $response->assertStatus(404);
        $this->assertFalse($response['success']);
    }

    /**
     * test for CategoryController::get
     *
     * @return void
     * @covers CategoryController::get
     */
    public function testCategoryGet()
    {
        $response = $this->get('/app/categories/1');

        $response->assertStatus(401);
        $this->assertFalse($response['success']);

        $user = User::find(2);
        $response = $this->actingAs($user)->get('/app/categories/1');
        $response->assertStatus(403);
        $this->assertFalse($response['success']);

        $user = User::find(1);
        $response = $this->actingAs($user)->get('/app/categories/1');
        $response->assertStatus(200);
        $this->assertTrue($response['success']);

        $user = User::find(1);
        $response = $this->actingAs($user)->get('/app/categories/11111');
        $response->assertStatus(404);
        $this->assertFalse($response['success']);
    }
}
