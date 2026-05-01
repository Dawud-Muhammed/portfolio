<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreContactRequest;
use App\Mail\ContactReceivedMail;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $contacts = Contact::query()
            ->latest()
            ->paginate((int) $request->integer('per_page', 20));

        $payload = $contacts->through(static fn (Contact $contact): array => [
            'id' => $contact->id,
            'name' => $contact->name,
            'email' => $contact->email,
            'subject' => $contact->subject,
            'message' => $contact->message,
            'read_at' => optional($contact->read_at)?->toIso8601String(),
            'created_at' => optional($contact->created_at)?->toIso8601String(),
        ]);

        return response()->json($payload);
    }

    public function store(StoreContactRequest $request): JsonResponse
    {
        $validated = $request->safe()->only(['name', 'email', 'subject', 'message']);

        $contact = Contact::query()->create([
            'name' => (string) $validated['name'],
            'email' => (string) $validated['email'],
            'subject' => (string) ($validated['subject'] ?? ''),
            'message' => (string) $validated['message'],
        ]);

        // Temporary fix to bypass the 403 error
Mail::to('bdu1601268@bdu.edu.et')->queue(new ContactReceivedMail($contact));

    return response()->json([
         'message' => 'Message received! I will get back to you shortly, ' . $contact->name . '.',
    ], 202);
    }

    public function show(Contact $contact): JsonResponse
    {
        return response()->json([
            'data' => [
                'id' => $contact->id,
                'name' => $contact->name,
                'email' => $contact->email,
                'subject' => $contact->subject,
                'message' => $contact->message,
                'read_at' => optional($contact->read_at)?->toIso8601String(),
                'created_at' => optional($contact->created_at)?->toIso8601String(),
            ],
        ]);
    }
}
