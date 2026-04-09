<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css">
<title>SMS Guide | RESQ KENYA</title>
</head>
<body>
<div class="container" style="max-width:700px;margin:0 auto;padding:60px 20px;">

    <nav style="display:flex;justify-content:space-between;align-items:center;margin-bottom:60px;">
        <div class="logo"><span>●</span> RESQ KENYA</div>
        <a href="index.php" class="btn-outline" style="padding:5px 15px;font-size:12px;">← Home</a>
    </nav>

    <p class="label-red">NO INTERNET NEEDED</p>
    <h1 style="font-size:2.5rem;margin-bottom:10px;">REPORT BY SMS</h1>
    <p style="color:#555;margin-bottom:50px;">Any phone. Any network. Send a text to report an emergency even without internet access.</p>

    <!-- Main format box -->
    <div style="background:#111;border:1px solid #222;border-radius:8px;padding:30px;margin-bottom:25px;">
        <p style="color:#555;font-size:11px;letter-spacing:2px;margin-bottom:15px;">SMS FORMAT</p>
        <div style="background:#0a0a0a;border-radius:6px;padding:20px;font-family:monospace;font-size:1.1rem;margin-bottom:15px;">
            <span style="color:#555;">RESQ </span>
            <span style="color:var(--resq-red);">[TYPE]</span>
            <span style="color:#555;"> </span>
            <span style="color:#f1c40f;">[SEVERITY]</span>
            <span style="color:#555;"> </span>
            <span style="color:#27ae60;">[LOCATION]</span>
        </div>
        <p style="color:#555;font-size:12px;">Send to: <strong style="color:white;font-size:1.2rem;">22395</strong></p>
    </div>

    <!-- Examples -->
    <div style="background:#111;border:1px solid #222;border-radius:8px;padding:30px;margin-bottom:25px;">
        <p style="color:#555;font-size:11px;letter-spacing:2px;margin-bottom:20px;">EXAMPLES</p>
        <?php
        $examples = [
            ['RESQ MEDICAL HIGH Kibera Nairobi', 'Medical emergency, high severity in Kibera'],
            ['RESQ FIRE HIGH Westlands', 'Fire outbreak, high severity in Westlands'],
            ['RESQ POLICE MEDIUM CBD Nairobi', 'Police/security issue in CBD'],
            ['RESQ FLOOD LOW Mathare', 'Flooding, low severity in Mathare'],
            ['RESQ ACC HIGH Mombasa Road', 'Road accident, high severity'],
        ];
        foreach($examples as $ex): ?>
        <div style="background:#0a0a0a;border-radius:6px;padding:15px;margin-bottom:10px;">
            <p style="font-family:monospace;color:white;margin-bottom:5px;"><?php echo $ex[0]; ?></p>
            <p style="color:#555;font-size:12px;"><?php echo $ex[1]; ?></p>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Type codes -->
    <div style="background:#111;border:1px solid #222;border-radius:8px;padding:30px;margin-bottom:25px;">
        <p style="color:#555;font-size:11px;letter-spacing:2px;margin-bottom:20px;">EMERGENCY TYPE CODES</p>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
            <?php
            $types = [
                ['MEDICAL or MED','Medical Emergency'],
                ['FIRE','Fire Outbreak'],
                ['POLICE or POL','Police / Security'],
                ['FLOOD','Flood / Water Hazard'],
                ['ACC or ACCIDENT','Road Accident'],
                ['GAS','Gas / Chemical Leak'],
                ['MISSING or MIS','Missing Person'],
                ['COLLAPSE or COL','Structural Collapse'],
            ];
            foreach($types as $t): ?>
            <div style="background:#0a0a0a;border-radius:4px;padding:12px;">
                <p style="color:var(--resq-red);font-family:monospace;font-size:12px;margin-bottom:4px;"><?php echo $t[0]; ?></p>
                <p style="color:#888;font-size:12px;"><?php echo $t[1]; ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Severity -->
    <div style="background:#111;border:1px solid #222;border-radius:8px;padding:30px;margin-bottom:25px;">
        <p style="color:#555;font-size:11px;letter-spacing:2px;margin-bottom:20px;">SEVERITY LEVELS</p>
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;text-align:center;">
            <div style="background:#0a0a0a;border-radius:4px;padding:15px;">
                <p style="color:#27ae60;font-weight:bold;">LOW</p>
                <p style="color:#555;font-size:11px;">Not life threatening</p>
            </div>
            <div style="background:#0a0a0a;border-radius:4px;padding:15px;">
                <p style="color:#f1c40f;font-weight:bold;">MEDIUM</p>
                <p style="color:#555;font-size:11px;">Urgent attention needed</p>
            </div>
            <div style="background:#0a0a0a;border-radius:4px;padding:15px;">
                <p style="color:var(--resq-red);font-weight:bold;">HIGH</p>
                <p style="color:#555;font-size:11px;">Life threatening</p>
            </div>
        </div>
    </div>

    <!-- What happens next -->
    <div style="background:#111;border:1px solid #27ae60;border-radius:8px;padding:30px;">
        <p style="color:#27ae60;font-size:11px;letter-spacing:2px;margin-bottom:15px;">AFTER YOU SEND</p>
        <p style="color:#888;font-size:14px;line-height:2;">
            ① You will receive a confirmation SMS with your reference number<br>
            ② Your report is automatically scored and sent to dispatchers<br>
            ③ Emergency services are alerted based on priority<br>
            ④ Reply STOP to cancel a false report
        </p>
    </div>

</div>
</body>
</html>