<?php

namespace Tests\Feature;

use App\Http\Controllers\AccountController;
use App\MoneyKeeper\Models\Account;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class AccountTest extends TestCase
{

    use RefreshDatabase;
    protected $seed = true;

    /**
     * test for AccountController::list
     *
     * @return void
     * @covers AccountController::list
     */
    public function testAccountList()
    {
        $response = $this->get('/app/accounts');

        $response->assertStatus(401);
        $this->assertFalse($response['success']);

        $user = User::find(1);
        $response = $this->actingAs($user)->get('/app/accounts');

        $response->assertStatus(200);
        $this->assertTrue($response['success']);
        $this->assertEquals(count($response['items']), 3);

        $user = User::find(2);
        $response = $this->actingAs($user)->get('/app/accounts');

        $response->assertStatus(200);
        $this->assertTrue($response['success']);
        $this->assertEquals(count($response['items']), 1);
    }


    /**
     * test for AccountController::add
     *
     * @return void
     * @covers AccountController::add
     */
    public function testAccountAdd()
    {
        $response = $this->post('/app/accounts');

        $response->assertStatus(401);
        $this->assertFalse($response['success']);

        $user = User::find(1);
        $response = $this->actingAs($user)->post('/app/accounts',
            [
                'name' => '',
            ]
        );

        $response->assertStatus(400);
        $this->assertFalse($response['success']);
        $this->assertEquals(array_keys($response['errors']), ['name']);

        $user = User::find(2);
        $response = $this->actingAs($user)->post('/app/accounts',
            [
                'name' => 'test add',
            ]
        );

        $response->assertStatus(200);
        $this->assertTrue($response['success']);
        $this->assertEquals($response['item']['name'], 'test add');
        $this->assertTrue($response['item']['id'] > 0);
        $this->assertDatabaseHas('wallets', [
            'name' => 'test add',
            'user_id' => 2
        ]);

        $user = User::find(1);
        $response = $this->actingAs($user)->post('/app/accounts',
            [
                'name' => 'test add 2',
                'sort' => 10,
            ]
        );

        $response->assertStatus(200);
        $this->assertTrue($response['success']);
        $this->assertEquals($response['item']['name'], 'test add 2');
        $this->assertEquals($response['item']['sort'], 10);
        $this->assertDatabaseHas('wallets', [
            'name' => 'test add 2',
            'user_id' => 1
        ]);
        $this->assertTrue($response['item']['id'] > 0);
    }

    /**
     * test for AccountController::update
     *
     * @return void
     * @covers AccountController::update
     */
    public function testAccountUpdate()
    {
        $response = $this->put('/app/accounts/1');

        $response->assertStatus(401);
        $this->assertFalse($response['success']);

        $user = User::find(2);
        $response = $this->actingAs($user)->put('/app/accounts/1',
            [
            'name' => 'test add',
            ]
        );
        $response->assertStatus(403);
        $this->assertFalse($response['success']);

        $user = User::find(1);
        $response = $this->actingAs($user)->put('/app/accounts/1',
            [
                'name' => "",
                'sort' => 20
            ]
        );
        $response->assertStatus(400);
        $this->assertFalse($response['success']);
        $this->assertEquals(array_keys($response['errors']), ['name']);

        $user = User::find(1);
        $response = $this->actingAs($user)->put('/app/accounts/1',
            [
                'name' => 'test add',
            ]
        );

        $response->assertStatus(200);
        $this->assertTrue($response['success']);
        $this->assertEquals($response['item']['name'], 'test add');
        $this->assertTrue($response['item']['id'] > 0);
        $this->assertDatabaseHas('wallets', [
            'name' => 'test add',
            'user_id' => 1
        ]);

        $user = User::find(1);
        $response = $this->actingAs($user)->put('/app/accounts/2',
            [
                'name' => 'test add 2',
                'sort' => 10,
            ]
        );

        $response->assertStatus(200);
        $this->assertTrue($response['success']);
        $this->assertEquals($response['item']['name'], 'test add 2');
        $this->assertEquals($response['item']['sort'], 10);
        $this->assertDatabaseHas('wallets', [
            'name' => 'test add 2',
            'user_id' => 1
        ]);
        $this->assertTrue($response['item']['id'] > 0);
    }


    /**
     * test for AccountController::delete
     *
     * @return void
     * @covers AccountController::delete
     */
    public function testAccountDelete()
    {
        $response = $this->delete('/app/accounts/1');

        $response->assertStatus(401);
        $this->assertFalse($response['success']);

        $user = User::find(2);
        $response = $this->actingAs($user)->delete('/app/accounts/1');
        $response->assertStatus(403);
        $this->assertFalse($response['success']);

        $user = User::find(1);
        $response = $this->actingAs($user)->delete('/app/accounts/1');
        $response->assertStatus(200);
        $this->assertTrue($response['success']);

        $user = User::find(1);
        $response = $this->actingAs($user)->delete('/app/accounts/11111');
        $response->assertStatus(404);
        $this->assertFalse($response['success']);
    }

    /**
     * test for AccountController::get
     *
     * @return void
     * @covers AccountController::get
     */
    public function testAccountGet()
    {
        $response = $this->get('/app/accounts/1');

        $response->assertStatus(401);
        $this->assertFalse($response['success']);

        $user = User::find(2);
        $response = $this->actingAs($user)->get('/app/accounts/1');
        $response->assertStatus(403);
        $this->assertFalse($response['success']);

        $user = User::find(1);
        $response = $this->actingAs($user)->get('/app/accounts/1');
        $response->assertStatus(200);
        $this->assertTrue($response['success']);

        $user = User::find(1);
        $response = $this->actingAs($user)->get('/app/accounts/11111');
        $response->assertStatus(404);
        $this->assertFalse($response['success']);
    }
}
