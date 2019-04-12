<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\Traits\MakeMessageTrait;
use Tests\ApiTestTrait;

class MessageApiTest extends TestCase
{
    use MakeMessageTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_message()
    {
        $message        = $this->fakeMessageData();
        $this->response = $this->json('POST', '/api/messages', $message);

        $this->assertApiResponse($message);
    }

    /**
     * @test
     */
    public function test_read_message()
    {
        $message        = $this->makeMessage();
        $this->response = $this->json('GET', '/api/messages/'.$message->id);

        $this->assertApiResponse($message->toArray());
    }

    /**
     * @test
     */
    public function test_update_message()
    {
        $message       = $this->makeMessage();
        $editedMessage = $this->fakeMessageData();

        $this->response = $this->json('PUT', '/api/messages/'.$message->id, $editedMessage);

        $this->assertApiResponse($editedMessage);
    }

    /**
     * @test
     */
    public function test_delete_message()
    {
        $message        = $this->makeMessage();
        $this->response = $this->json('DELETE', '/api/messages/'.$message->id);

        $this->assertApiSuccess();
        $this->response = $this->json('GET', '/api/messages/'.$message->id);

        $this->response->assertStatus(404);
    }
}
