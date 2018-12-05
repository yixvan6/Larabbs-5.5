<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Topic;
use Tests\Traits\ActingJWTUser;

class TopicApiTest extends TestCase
{
    use ActingJWTUser;
    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testStoreTopic()
    {
        $data = ['title' => 'test title', 'body' => 'body', 'category_id' => 1];

        $response = $this->JWTActingAs($this->user)->json('POST', '/api/topics', $data);

        $assertData = [
            'title' => 'test title',
            'body' => clean('body', 'user_topic_body'),
            'category_id' => 1,
            'user_id' => $this->user->id,
        ];

        $response->assertStatus(201)->assertJsonFragment($assertData);
    }

    public function testUpdateTopic()
    {
        $topic = $this->makeTopic();

        $editData = ['title' => 'edit title', 'body' => 'edit body', 'category_id' => 2];

        $response = $this->JWTActingAs($this->user)
            ->json('PATCH', '/api/topics/'.$topic->id, $editData);

        $assertData = [
            'title' => 'edit title',
            'body' => clean('edit body', 'user_topic_body'),
            'category_id' => 2,
            'user_id' => $this->user->id,
        ];

        $response->assertStatus(200)
            ->assertJsonFragment($assertData);
    }

    protected function makeTopic()
    {
        return factory(Topic::class)->create([
            'category_id' => 1,
            'user_id' => $this->user->id,
        ]);
    }

    public function testShowTopic()
    {
        $topic = $this->makeTopic();
        $response = $this->json('GET', '/api/topics/'.$topic->id);

        $assertData= [
            'category_id' => $topic->category_id,
            'user_id' => $topic->user_id,
            'title' => $topic->title,
            'body' => $topic->body,
        ];

        $response->assertStatus(200)
            ->assertJsonFragment($assertData);
    }

    public function testIndexTopic()
    {
        $response = $this->json('GET', '/api/topics');

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'meta']);
    }

    public function testDeleteTopic()
    {
        $topic = $this->makeTopic();

        $response = $this->JWTActingAs($this->user)
            ->json('DELETE', '/api/topics/'.$topic->id);

        $response->assertStatus(204);

        $response = $this->json('GET', '/api/topics/'.$topic->id);
        $response->assertStatus(404);
    }
}
