
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Reset Your Password</title>
</head>
<body>
  <h1>Reset Your Password</h1>
<p>Hi,</p>
<p>We received a request to reset your password. If you did not request this, please ignore this email.</p>
<p>To reset your password, click on the link below:</p>
<a href="{{route('user.resetpwd', $token)}}">Reset Password</a>
<p>Once you have reset your password, you will be able to log in to your account.</p>
<p>If you have any questions, please do not hesitate to contact us.</p>
<p>Thanks,</p>
<p>Otechnique Admin Team</p>
</body>
</html>