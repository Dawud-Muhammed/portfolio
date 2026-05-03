@component('mail::message')
# Hello {{ $contact->name }},

{{ $reply_body }}

---
Best regards,  
**Dawud Muhammed**  
@component('mail::subcopy')
You are receiving this because you contacted me at [dawud-muhammed.me](https://dawud-muhammed.me).
@endcomponent
@endcomponent