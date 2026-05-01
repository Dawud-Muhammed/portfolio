@component('mail::message')
# 📨 New Project Inquiry

A new message has been captured from your portfolio contact system.

---

### Contact Details
**Name:** {{ $contact->name }}  
**Email:** {{ $contact->email }}  
**Subject:** {{ $contact->subject }}

### Message Content
@component('mail::panel')
{{ $contact->message }}
@endcomponent

@component('mail::button', ['url' => config('app.url') . '/admin/contacts', 'color' => 'success'])
Review in Admin Panel
@endcomponent

---
Sent via **{{ config('app.name') }}**  
*System automated notification.*
@endcomponent