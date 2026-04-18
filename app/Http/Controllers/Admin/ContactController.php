<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MarkContactReadRequest;
use App\Models\Contact;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

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
}
