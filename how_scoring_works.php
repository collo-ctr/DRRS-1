<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css">
<title>How Scoring Works | RESQ KENYA</title>
</head>
<body>
<div class="container" style="max-width:700px;margin:0 auto;padding:60px 20px;">

    <nav style="display:flex;justify-content:space-between;align-items:center;margin-bottom:60px;">
        <div class="logo"><span>●</span> RESQ KENYA</div>
        <a href="index.php" class="btn-outline" style="padding:5px 15px;font-size:12px;">← Home</a>
    </nav>

    <p class="label-red">TRANSPARENCY</p>
    <h1 style="font-size:2.5rem;margin-bottom:10px;">HOW PRIORITY<br>SCORING WORKS</h1>
    <p style="color:#555;margin-bottom:50px;">Every report is automatically scored 0–100. Higher score = faster response. Here's exactly how.</p>

    <div style="background:#111;border:1px solid #222;border-radius:8px;padding:30px;margin-bottom:25px;">
        <h3 style="color:var(--resq-red);font-size:12px;letter-spacing:2px;margin-bottom:20px;">STEP 1 — INCIDENT TYPE BASE SCORE</h3>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
            <?php
            $types = [
                ['Structural Collapse','50'],['Gas / Chemical','45'],
                ['Medical','40'],['Fire','35'],
                ['Road Accident','30'],['Police / Security','30'],
                ['Flood','25'],['Missing Person','20']
            ];
            foreach($types as $t): ?>
            <div style="display:flex;justify-content:space-between;padding:10px 15px;background:#0a0a0a;border-radius:4px;">
                <span style="color:#ccc;font-size:13px;"><?php echo $t[0]; ?></span>
                <span style="color:var(--resq-red);font-weight:bold;">+<?php echo $t[1]; ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div style="background:#111;border:1px solid #222;border-radius:8px;padding:30px;margin-bottom:25px;">
        <h3 style="color:var(--resq-red);font-size:12px;letter-spacing:2px;margin-bottom:20px;">STEP 2 — SEVERITY MULTIPLIER</h3>
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;">
            <div style="padding:15px;background:#0a0a0a;border-radius:4px;text-align:center;">
                <p style="color:#27ae60;font-weight:bold;font-size:1.2rem;">+0</p>
                <p style="color:#555;font-size:12px;">Low</p>
            </div>
            <div style="padding:15px;background:#0a0a0a;border-radius:4px;text-align:center;">
                <p style="color:#f1c40f;font-weight:bold;font-size:1.2rem;">+20</p>
                <p style="color:#555;font-size:12px;">Medium</p>
            </div>
            <div style="padding:15px;background:#0a0a0a;border-radius:4px;text-align:center;">
                <p style="color:var(--resq-red);font-weight:bold;font-size:1.2rem;">+40</p>
                <p style="color:#555;font-size:12px;">High</p>
            </div>
        </div>
    </div>

    <div style="background:#111;border:1px solid #222;border-radius:8px;padding:30px;margin-bottom:25px;">
        <h3 style="color:var(--resq-red);font-size:12px;letter-spacing:2px;margin-bottom:20px;">STEP 3 — TIME OF NIGHT BONUS</h3>
        <p style="color:#888;font-size:14px;">Reports submitted between <strong style="color:white;">10:00 PM and 5:00 AM</strong> receive a <strong style="color:var(--resq-red);">+10 bonus</strong> — emergency services are harder to reach at night, so these reports are escalated automatically.</p>
    </div>

    <div style="background:#111;border:1px solid var(--resq-red);border-radius:8px;padding:30px;margin-bottom:40px;">
        <h3 style="color:var(--resq-red);font-size:12px;letter-spacing:2px;margin-bottom:15px;">EXAMPLE CALCULATION</h3>
        <p style="color:#888;font-size:14px;line-height:2;">
            Medical emergency (High severity, submitted at 11pm)<br>
            = Base score <strong style="color:white;">40</strong> + Severity <strong style="color:white;">40</strong> + Night bonus <strong style="color:white;">10</strong><br>
            = <strong style="color:var(--resq-red);font-size:1.5rem;">90 / 100 — CRITICAL</strong>
        </p>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:15px;text-align:center;">
        <div style="background:#111;border:1px solid #27ae60;border-radius:8px;padding:20px;">
            <p style="color:#27ae60;font-size:1.5rem;font-weight:bold;">0–49</p>
            <p style="color:#27ae60;font-size:11px;letter-spacing:2px;">STANDARD</p>
        </div>
        <div style="background:#111;border:1px solid #f1c40f;border-radius:8px;padding:20px;">
            <p style="color:#f1c40f;font-size:1.5rem;font-weight:bold;">50–79</p>
            <p style="color:#f1c40f;font-size:11px;letter-spacing:2px;">URGENT</p>
        </div>
        <div style="background:#111;border:1px solid var(--resq-red);border-radius:8px;padding:20px;">
            <p style="color:var(--resq-red);font-size:1.5rem;font-weight:bold;">80–100</p>
            <p style="color:var(--resq-red);font-size:11px;letter-spacing:2px;">CRITICAL</p>
        </div>
    </div>

</div>
</body>
</html>