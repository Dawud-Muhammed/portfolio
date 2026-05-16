<?php

namespace Tests\Feature;

use App\Mail\ContactReceivedMail;
use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_store_validates_and_creates_contact_and_queues_mail()
    {
        Mail::fake();

        $payload = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'subject' => 'Hello',
            'message' => 'This is a test message with enough length.',
        ];

        $response = $this->postJson(route('api.v1.contact.store'), $payload);

        $response->assertStatus(202);

        $this->assertDatabaseHas('contacts', [
            'email' => 'test@example.com',
            'name' => 'Test User',
        ]);

        Mail::assertQueued(ContactReceivedMail::class);
    }

    public function test_contact_store_returns_validation_errors_for_invalid_payload()
    {
        $response = $this->postJson(route('api.v1.contact.store'), [
            'name' => '',
            'email' => 'not-an-email',
            'message' => 'short',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'email', 'message']);
    }
}
