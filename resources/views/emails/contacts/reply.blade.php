@component('mail::message')
# Hello {{ $contact->name }},

{{ $reply_body }}

---
Best regards,  
**Dawud Muhammed**  
@component('mail::subcopy')
You are receiving this because you contacted me at [dawud-muhammed.up.railway.app](https://dawud-muhammed.up.railway.app).
@endcomponent
@endcomponent