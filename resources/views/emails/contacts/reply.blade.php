@component('mail::message')
# Hello {{ $contact->name }},

Thank you for reaching out! I’ve received your message regarding **"{{ $contact->subject }}"** and wanted to let you know that I'm reviewing the details.

### My Response:
@component('mail::panel')
{{ $reply_body }}
@endcomponent

I usually respond within 24–48 hours. If this is urgent, feel free to follow up on this thread.

Best regards,  
**{{ config('app.name') }} Team**

---
@component('mail::subcopy')
You are receiving this because you contacted me at [{{ config('app.url') }}]({{ config('app.url') }}).
@endcomponent
@endcomponent