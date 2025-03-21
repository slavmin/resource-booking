<?php

namespace Tests\Feature;

use App\Models\Resource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResourceTest extends TestCase
{
    use RefreshDatabase;


    public function test_create_resource()
    {
        $response = $this->postJson('/api/resources', [
            'name' => 'Conference Room',
            'type' => 'room',
            'description' => 'A large conference room',
        ]);

        $response->assertStatus(201);
    }

    public function test_get_all_resources()
    {
        Resource::factory()->count(3)->create();

        $response = $this->getJson('/api/resources');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function test_get_single_resource()
    {
        $resource = Resource::factory()->create();

        $response = $this->getJson("/api/resources/{$resource->id}");

        $response->assertStatus(200)
            ->assertJson(['data' => ['id' => $resource->id]]);
    }

    public function test_update_resource()
    {
        $resource = Resource::factory()->create();

        $response = $this->putJson("/api/resources/{$resource->id}", [
            'name' => 'Updated Room',
            'type' => 'room',
            'description' => 'Updated description',
        ]);

        $response->assertStatus(200)->assertJson(['data' => ['name' => 'Updated Room']]);
    }

    public function test_delete_resource()
    {
        $resource = Resource::factory()->create();

        $response = $this->deleteJson("/api/resources/{$resource->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('resources', ['id' => $resource->id]);
    }
}
