<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Resource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;


    public function test_create_booking()
    {
        $user = User::factory()->create();
        $resource = Resource::factory()->create();

        $response = $this->postJson('/api/bookings', [
            'resource_id' => $resource->id,
            'user_id' => $user->id,
            'start_time' => now()->addYear()->addDay()->toDateTimeString(),
            'end_time' => now()->addYear()->addDays(2)->toDateTimeString(),
        ]);

        $response->assertStatus(201);
    }

    public function test_get_all_bookings()
    {
        Booking::factory()->count(3)->create();

        $response = $this->getJson('/api/bookings');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function test_get_single_booking()
    {
        $booking = Booking::factory()->create();

        $response = $this->getJson("/api/bookings/{$booking->id}");

        $response->assertStatus(200)
            ->assertJson(['data' => ['id' => $booking->id]]);
    }

    public function test_update_booking()
    {
        $booking = Booking::factory()->create();
        $newResource = Resource::factory()->create();

        $response = $this->putJson("/api/bookings/{$booking->id}", [
            'resource_id' => $newResource->id,
            'user_id' => $booking->user_id,
            'start_time' => now()->addDays(3)->toDateTimeString(),
            'end_time' => now()->addDays(4)->toDateTimeString(),
        ]);

        $response->assertStatus(200)->assertJson(['data' => ['resource_id' => $newResource->id]]);
    }

    public function test_delete_booking()
    {
        $booking = Booking::factory()->create();

        $response = $this->deleteJson("/api/bookings/{$booking->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('bookings', ['id' => $booking->id]);
    }
}
