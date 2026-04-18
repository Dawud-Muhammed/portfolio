<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Message</title>
</head>
<body style="margin: 0; padding: 24px; background: #f8fafc; color: #0f172a; font-family: Arial, sans-serif;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width: 640px; margin: 0 auto; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden;">
        <tr>
            <td style="padding: 18px 20px; background: linear-gradient(135deg, #f97316, #fb923c); color: #ffffff; font-weight: 700; font-size: 18px;">
                New Portfolio Contact
            </td>
        </tr>
        <tr>
            <td style="padding: 20px;">
                <p style="margin: 0 0 10px 0;"><strong>Name:</strong> {{ $name }}</p>
                <p style="margin: 0 0 10px 0;"><strong>Email:</strong> {{ $email }}</p>
                <p style="margin: 0 0 16px 0;"><strong>Subject:</strong> {{ $subjectLine }}</p>
                <p style="margin: 0; line-height: 1.6; white-space: pre-line;">{{ $messageBody }}</p>
            </td>
        </tr>
    </table>
</body>
</html>