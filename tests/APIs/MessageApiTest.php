<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\Traits\MakeMessageTrait;
use Tests\ApiTestTrait;
use App\Models\User;

class MessageApiTest extends TestCase
{
    use MakeMessageTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_message()
    {
        $user           = User::find(1);
        $message        = $this->fakeMessageData([
            'user_id' => $user->id
        ]);

        $this->response = $this->withHeaders([
            'Authorization' => 'Bearer '.$user->api_token,
        ])->json('POST', '/api/messages', $message);

        $this->assertApiResponse($message);
    }

    /**
     * @test
     */
    public function test_read_message()
    {
        $user           = User::find(1);
        $message        = $this->makeMessage();
        $this->response = $this->withHeaders([
            'Authorization' => 'Bearer '.$user->api_token,
        ])->json('GET', '/api/messages/'.$message->id);

        $this->assertApiResponse($message->toArray());
    }

    /**
     * @test
     */
    public function test_update_message()
    {
        $user           = User::find(1);
        $message        = $this->makeMessage();
        $editedMessage  = $this->fakeMessageData();

        $this->response = $this->withHeaders([
            'Authorization' => 'Bearer '.$user->api_token,
        ])->json('PUT', '/api/messages/'.$message->id, $editedMessage);

        $this->assertApiResponse($editedMessage);
    }

    /**
     * @test
     */
    public function test_delete_message()
    {
        $user           = User::find(1);
        $message        = $this->makeMessage();
        $this->response = $this->withHeaders([
            'Authorization' => 'Bearer '.$user->api_token,
        ])->json('DELETE', '/api/messages/'.$message->id);

        $this->assertApiSuccess();
        $this->response = $this->withHeaders([
            'Authorization' => 'Bearer '.$user->api_token,
        ])->json('GET', '/api/messages/'.$message->id);

        $this->response->assertStatus(404);
    }
}
