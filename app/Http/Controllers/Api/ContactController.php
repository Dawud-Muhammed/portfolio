<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreContactRequest;
use App\Mail\ContactMessageMail;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(['data' => [], 'message' => 'List of contacts']);
    }

    public function store(StoreContactRequest $request): JsonResponse
    {
        $validated = $request->safe()->only(['name', 'email', 'subject', 'message']);

        Contact::query()->create([
            'name' => (string) $validated['name'],
            'email' => (string) $validated['email'],
            'subject' => (string) ($validated['subject'] ?? ''),
            'message' => (string) $validated['message'],
        ]);

        Mail::to((string) config('contact.recipient_email'))->queue(new ContactMessageMail([
            'name' => (string) $validated['name'],
            'email' => (string) $validated['email'],
            'subject' => (string) ($validated['subject'] ?? ''),
            'message' => (string) $validated['message'],
        ]));

        return response()->json([
            'message' => 'Thanks, your message has been queued successfully.',
        ], 202);
    }

    public function show(string $contact): JsonResponse
    {
        return response()->json(['data' => ['id' => $contact], 'message' => 'Contact details']);
    }
}
