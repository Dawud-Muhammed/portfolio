<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MarkContactReadRequest;
use App\Mail\ContactReplyMail;
use App\Models\Contact;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('admin.contacts.index', [
            'contacts' => Contact::query()->latest()->paginate(20),
        ]);
    }

    public function markRead(MarkContactReadRequest $request, Contact $contact): RedirectResponse
    {
        if (! $contact->read_at) {
            $contact->update(['read_at' => now()]);
        }

        return redirect()->route('admin.contacts.index')->with('status', 'Message marked as read.');
    }

    public function reply(Request $request, Contact $contact): RedirectResponse
    {
        $validated = $request->validate([
            'reply_body' => ['required', 'string', 'max:5000'],
        ]);

        Mail::to((string) $contact->email)->queue(new ContactReplyMail($contact, (string) $validated['reply_body']));

        return redirect()
            ->route('admin.contacts.index')
            ->with('status', 'Reply queued successfully.');
    }
}
