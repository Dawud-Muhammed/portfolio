@component('mail::message')
# 📥 New Inquiry: {{ $contact->subject }}

**{{ $contact->name }}** just sent a message through your portfolio.

@component('mail::panel')
{{ $contact->message }}
@endcomponent

**Sender Email:** [{{ $contact->email }}](mailto:{{ $contact->email }})

@component('mail::button', ['url' => config('app.url') . '/admin/contacts'])
Open Admin Dashboard
@endcomponent
@endcomponent