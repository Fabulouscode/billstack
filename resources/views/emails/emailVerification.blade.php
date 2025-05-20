<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Your OTP Code</title>
</head>
<body>
    <h2>Hello {{ $user->name ?? 'User' }},</h2>

    <p>Your One-Time Password (OTP) is:</p>

    <h1 style="letter-spacing: 5px;">{{ $otp }}</h1>

    <p>This OTP will expire in 60 minutes. Do not share this code with anyone.</p>

    <p>Thanks,<br>Your App Team</p>
</body>
</html>
