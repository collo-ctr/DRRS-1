<?php
$ref = isset($_GET['ref']) ? htmlspecialchars($_GET['ref']) : 'N/A';
$score = isset($_GET['score']) ? intval($_GET['score']) : 0;

$score_label = $score >= 80 ? 'CRITICAL' : ($score >= 50 ? 'URGENT' : 'STANDARD');
$score_color = $score >= 80 ? '#ff3131' : ($score >= 50 ? '#f1c40f' : '#27ae60');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css">
<title>Report Submitted | RESQ KENYA</title>
</head>
<body>
<div class="container" style="max-width:600px;margin:0 auto;padding:80px 20px;text-align:center;">

    <div style="font-size:60px;margin-bottom:20px;">✅</div>

    <p style="color:#27ae60;font-size:12px;letter-spacing:3px;margin-bottom:10px;">REPORT RECEIVED</p>
    <h1 style="font-size:2.5rem;margin-bottom:10px;">HELP IS ON<br>THE WAY</h1>
    <p style="color:#555;margin-bottom:40px;">Your emergency has been logged and dispatchers have been alerted.</p>

    <div style="background:#111;border:1px solid #222;border-radius:8px;padding:30px;margin-bottom:30px;">
        <p style="color:#555;font-size:11px;letter-spacing:2px;margin-bottom:5px;">YOUR REFERENCE NUMBER</p>
        <p style="font-size:2rem;font-weight:bold;color:white;letter-spacing:4px;margin-bottom:25px;"><?php echo $ref; ?></p>

        <p style="color:#555;font-size:11px;letter-spacing:2px;margin-bottom:5px;">PRIORITY SCORE</p>
        <p style="font-size:3rem;font-weight:bold;color:<?php echo $score_color; ?>;"><?php echo $score; ?></p>
        <p style="font-size:12px;color:<?php echo $score_color; ?>;letter-spacing:3px;"><?php echo $score_label; ?></p>
    </div>

    <div style="background:#0a0a0a;border:1px solid #1a1a1a;border-radius:8px;padding:20px;margin-bottom:30px;text-align:left;">
        <p style="font-size:11px;color:#555;letter-spacing:2px;margin-bottom:15px;">WHAT HAPPENS NEXT</p>
        <p style="font-size:13px;color:#888;margin-bottom:8px;">① Your report has been assigned reference <strong style="color:white;"><?php echo $ref; ?></strong></p>
        <p style="font-size:13px;color:#888;margin-bottom:8px;">② A dispatcher is reviewing your report right now</p>
        <p style="font-size:13px;color:#888;margin-bottom:8px;">③ Emergency services will be dispatched based on priority</p>
        <p style="font-size:13px;color:#888;">④ Use your reference number to track your report status</p>
    </div>

    <div style="display:flex;gap:15px;justify-content:center;flex-wrap:wrap;">
        <a href="track.php?ref=<?php echo $ref; ?>" class="btn-red">Track My Report →</a>
        <a href="index.php" class="btn-outline">Back to Home</a>
    </div>

</div>
</body>
</html>