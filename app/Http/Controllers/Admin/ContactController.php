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
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $filter = (string) $request->query('filter', 'all');

        if (! in_array($filter, ['all', 'read', 'unread'], true)) {
            $filter = 'all';
        }

        return view('admin.contacts.index', [
            'contacts' => Contact::query()
                ->when($search, function ($query) use ($search) {
                    $query->where(function ($subQuery) use ($search) {
                        $subQuery
                            ->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('subject', 'like', "%{$search}%");
                    });
                })
                ->when($filter === 'read', fn ($query) => $query->whereNotNull('read_at'))
                ->when($filter === 'unread', fn ($query) => $query->whereNull('read_at'))
                ->latest()
                ->paginate(20),
            'search' => $search,
            'filter' => $filter,
        ]);
    }

    public function markAllRead(Request $request): RedirectResponse
    {
        Contact::query()
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return redirect()
            ->route('admin.contacts.index', $request->only(['search', 'filter']))
            ->with('status', 'All messages marked as read.');
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
