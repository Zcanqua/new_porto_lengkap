<?php

namespace Tests\Feature;

use App\Models\Message;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortfolioMessageEndpointTest extends TestCase
{
    use RefreshDatabase;

    public function test_invalid_message_returns_json_422(): void
    {
        $response = $this->postJson('/api/portfolio/messages', [
            'sender_name' => 'Al',
            'sender_email' => 'bukan-alamat-email',
            'subject' => '',
            'body' => 'pendek',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['sender_name', 'sender_email', 'subject', 'body'])
            ->assertJsonPath('status', 'error');

        $this->assertDatabaseCount('messages', 0);
    }

    public function test_valid_message_is_stored_and_returns_201(): void
    {
        $payload = [
            'sender_name' => 'Budi Santoso',
            'sender_email' => 'budi@gmail.com',
            'subject' => 'Tawaran Wawancara Kerja Web Developer',
            'body' => 'Halo, saya tertarik berdiskusi mengenai peluang kerja web developer.',
        ];

        $response = $this->postJson('/api/portfolio/messages', $payload);

        $response
            ->assertCreated()
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('data.sender_name', 'Budi Santoso');

        $this->assertDatabaseHas('messages', [
            'sender_name' => 'Budi Santoso',
            'sender_email' => 'budi@gmail.com',
            'is_read' => false,
        ]);

        $this->assertSame(1, Message::count());
    }

    public function test_extra_fields_are_not_mass_assigned(): void
    {
        $response = $this->postJson('/api/portfolio/messages', [
            'sender_name' => 'Budi Santoso',
            'sender_email' => 'budi@gmail.com',
            'subject' => 'Tawaran Wawancara Kerja',
            'body' => 'Isi pesan ini lebih dari sepuluh karakter.',
            'is_read' => true,
        ]);

        $response->assertCreated();
        $this->assertFalse((bool) Message::firstOrFail()->is_read);
    }
}
