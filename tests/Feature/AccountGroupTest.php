<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AccountGroupTest extends TestCase
{

    use RefreshDatabase;
    protected $seed = true;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAccountGroupList()
    {
        $response = $this->get('/app/account/groups');

        $response->assertStatus(401);

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
}
