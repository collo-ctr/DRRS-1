<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css">
<title>Dispatcher Login | RESQ KENYA</title>
</head>
<body>
<div class="container" style="max-width:450px;margin:0 auto;padding:100px 20px;">

    <div style="text-align:center;margin-bottom:50px;">
        <div class="logo" style="justify-content:center;margin-bottom:20px;"><span>●</span> RESQ KENYA</div>
        <p class="label-red">DISPATCHER ACCESS</p>
        <h1 style="font-size:2rem;">SIGN IN</h1>
        <p style="color:#555;font-size:13px;margin-top:10px;">Authorized personnel only</p>
    </div>

    <form action="auth.php" method="POST">
        <div style="margin-bottom:20px;">
            <label style="font-size:11px;letter-spacing:2px;color:#555;display:block;margin-bottom:8px;">USERNAME</label>
            <input type="text" name="user" placeholder="Enter your username" required style="width:100%;box-sizing:border-box;">
        </div>
        <div style="margin-bottom:30px;">
            <label style="font-size:11px;letter-spacing:2px;color:#555;display:block;margin-bottom:8px;">PASSWORD</label>
            <input type="password" name="pass" placeholder="Enter your password" required style="width:100%;box-sizing:border-box;">
        </div>
        <button type="submit" class="btn-red-large">Access Dashboard →</button>
    </form>

    <div style="text-align:center;margin-top:40px;">
        <a href="index.php" style="color:#444;font-size:12px;text-decoration:none;">← Back to RESQ KENYA</a>
    </div>

    <div style="margin-top:60px;padding:20px;background:#0a0a0a;border-radius:6px;border:1px solid #1a1a1a;">
        <p style="color:#333;font-size:11px;text-align:center;letter-spacing:1px;">
            DEMO CREDENTIALS<br>
            <span style="color:#555;">Username: dispatcher · Password: password</span>
        </p>
    </div>

</div>
</body>
</html>