<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
</head>
<body>
    <p>Dear {{ $name }},</p>
    <p>Thank you for registering. Please verify your email by clicking the link below:</p>
    <a href="{{ $verificationUrl }}">Verify Email</a>
</body>
</html>
