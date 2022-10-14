<?php

namespace Tests\Feature;

use App\Http\Controllers\AccountGroupController;
use App\MoneyKeeper\Models\AccountGroup;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class AccountGroupTest extends TestCase
{

    use RefreshDatabase;
    protected $seed = true;

    /**
     * test for AccountGroupController::list
     *
     * @return void
     * @covers AccountGroupController::list
     */
    public function testAccountGroupList()
    {
        $response = $this->get('/app/account/groups');

        $response->assertStatus(401);
        $this->assertFalse($response['success']);

        $user = User::find(1);
        $response = $this->actingAs($user)->get('/app/account/groups');

        $response->assertStatus(200);
        $this->assertTrue($response['success']);
        $this->assertEquals(count($response['items']), 3);

        $user = User::find(2);
        $response = $this->actingAs($user)->get('/app/account/groups');

        $response->assertStatus(200);
        $this->assertTrue($response['success']);
        $this->assertEquals(count($response['items']), 1);
    }


    /**
     * test for AccountGroupController::add
     *
     * @return void
     * @covers AccountGroupController::add
     */
    public function testAccountGroupAdd()
    {
        $response = $this->post('/app/account/groups');

        $response->assertStatus(401);
        $this->assertFalse($response['success']);

        $user = User::find(1);
        $response = $this->actingAs($user)->post('/app/account/groups',
            [
                'name' => '',
            ]
        );

        $response->assertStatus(400);
        $this->assertFalse($response['success']);
        $this->assertEquals(array_keys($response['errors']), ['name']);

        $user = User::find(2);
        $response = $this->actingAs($user)->post('/app/account/groups',
            [
                'name' => 'test add',
            ]
        );

        $response->assertStatus(200);
        $this->assertTrue($response['success']);
        $this->assertEquals($response['item']['name'], 'test add');
        $this->assertTrue($response['item']['id'] > 0);
        $this->assertDatabaseHas('wallets_groups', [
            'name' => 'test add',
            'user_id' => 2
        ]);

        $user = User::find(1);
        $response = $this->actingAs($user)->post('/app/account/groups',
            [
                'name' => 'test add 2',
                'sort' => 10,
            ]
        );

        $response->assertStatus(200);
        $this->assertTrue($response['success']);
        $this->assertEquals($response['item']['name'], 'test add 2');
        $this->assertEquals($response['item']['sort'], 10);
        $this->assertDatabaseHas('wallets_groups', [
            'name' => 'test add 2',
            'user_id' => 1
        ]);
        $this->assertTrue($response['item']['id'] > 0);
    }

    /**
     * test for AccountGroupController::update
     *
     * @return void
     * @covers AccountGroupController::update
     */
    public function testAccountGroupUpdate()
    {
        $response = $this->put('/app/account/groups/1');

        $response->assertStatus(401);
        $this->assertFalse($response['success']);

        $user = User::find(2);
        $response = $this->actingAs($user)->put('/app/account/groups/1',
            [
            'name' => 'test add',
            ]
        );
        $response->assertStatus(403);
        $this->assertFalse($response['success']);

        $user = User::find(1);
        $response = $this->actingAs($user)->put('/app/account/groups/1',
            [
                'name' => "",
                'sort' => 20
            ]
        );
        $response->assertStatus(400);
        $this->assertFalse($response['success']);
        $this->assertEquals(array_keys($response['errors']), ['name']);

        $user = User::find(1);
        $response = $this->actingAs($user)->put('/app/account/groups/1',
            [
                'name' => 'test add',
            ]
        );

        $response->assertStatus(200);
        $this->assertTrue($response['success']);
        $this->assertEquals($response['item']['name'], 'test add');
        $this->assertTrue($response['item']['id'] > 0);
        $this->assertDatabaseHas('wallets_groups', [
            'name' => 'test add',
            'user_id' => 1
        ]);

        $user = User::find(1);
        $response = $this->actingAs($user)->put('/app/account/groups/2',
            [
                'name' => 'test add 2',
                'sort' => 10,
            ]
        );

        $response->assertStatus(200);
        $this->assertTrue($response['success']);
        $this->assertEquals($response['item']['name'], 'test add 2');
        $this->assertEquals($response['item']['sort'], 10);
        $this->assertDatabaseHas('wallets_groups', [
            'name' => 'test add 2',
            'user_id' => 1
        ]);
        $this->assertTrue($response['item']['id'] > 0);
    }


    /**
     * test for AccountGroupController::delete
     *
     * @return void
     * @covers AccountGroupController::delete
     */
    public function testAccountGroupDelete()
    {
        $response = $this->delete('/app/account/groups/1');

        $response->assertStatus(401);
        $this->assertFalse($response['success']);

        $user = User::find(2);
        $response = $this->actingAs($user)->delete('/app/account/groups/1');
        $response->assertStatus(403);
        $this->assertFalse($response['success']);

        $user = User::find(1);
        $response = $this->actingAs($user)->delete('/app/account/groups/1');
        $response->assertStatus(200);
        $this->assertTrue($response['success']);

        $user = User::find(1);
        $response = $this->actingAs($user)->delete('/app/account/groups/11111');
        $response->assertStatus(404);
        $this->assertFalse($response['success']);
    }

    /**
     * test for AccountGroupController::get
     *
     * @return void
     * @covers AccountGroupController::get
     */
    public function testAccountGroupGet()
    {
        $response = $this->get('/app/account/groups/1');

        $response->assertStatus(401);
        $this->assertFalse($response['success']);

        $user = User::find(2);
        $response = $this->actingAs($user)->get('/app/account/groups/1');
        $response->assertStatus(403);
        $this->assertFalse($response['success']);

        $user = User::find(1);
        $response = $this->actingAs($user)->get('/app/account/groups/1');
        $response->assertStatus(200);
        $this->assertTrue($response['success']);

        $user = User::find(1);
        $response = $this->actingAs($user)->get('/app/account/groups/11111');
        $response->assertStatus(404);
        $this->assertFalse($response['success']);
    }
}
