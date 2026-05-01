@component('mail::message')
# New Connection Request

You have received a new message from your portfolio website.

**From:** {{ $contact->name }} ({{ $contact->email }})  
**Subject:** {{ $contact->subject }}

**Message:**  
{{ $contact->message }}

@component('mail::button', ['url' => config('app.url') . '/admin/contacts'])
View in Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent