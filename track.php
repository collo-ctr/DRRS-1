<?php
include 'db.php';

$ref = isset($_GET['ref']) ? $conn->real_escape_string($_GET['ref']) : '';
$report = null;

if ($ref) {
    $stmt = $conn->prepare("SELECT * FROM emergency_reports WHERE ref_num = ?");
    $stmt->bind_param("s", $ref);
    $stmt->execute();
    $result = $stmt->get_result();
    $report = $result->fetch_assoc();
}

$status_steps = ['Pending', 'Acknowledged', 'In Progress', 'Resolved'];
$current_step = $report ? array_search($report['status'], $status_steps) : -1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css">
<title>Track Report | RESQ KENYA</title>
</head>
<body>
<div class="container" style="max-width:650px;margin:0 auto;padding:60px 20px;">

    <nav style="display:flex;justify-content:space-between;align-items:center;margin-bottom:60px;">
        <div class="logo"><span>●</span> RESQ KENYA</div>
        <a href="index.php" class="btn-outline" style="padding:5px 15px;font-size:12px;">← Home</a>
    </nav>

    <p class="label-red">REPORT TRACKER</p>
    <h1 style="font-size:2.5rem;margin-bottom:30px;">TRACK YOUR<br>REPORT</h1>

    <form method="GET" action="track.php" style="display:flex;gap:10px;margin-bottom:50px;">
        <input type="text" name="ref" value="<?php echo htmlspecialchars($ref); ?>" 
               placeholder="Enter reference number e.g. RES-001234" 
               style="flex-grow:1;" required>
        <button type="submit" class="btn-red">Track →</button>
    </form>

    <?php if ($ref && !$report): ?>
        <div style="background:#111;border:1px solid #ff3131;border-radius:8px;padding:30px;text-align:center;">
            <p style="color:#ff3131;font-size:2rem;margin-bottom:10px;">⚠</p>
            <p style="color:white;">No report found for <strong><?php echo htmlspecialchars($ref); ?></strong></p>
            <p style="color:#555;font-size:13px;margin-top:10px;">Check the reference number and try again.</p>
        </div>

    <?php elseif ($report): ?>
        <?php
        $score_color = $report['priority_score'] >= 80 ? '#ff3131' : ($report['priority_score'] >= 50 ? '#f1c40f' : '#27ae60');
        $score_label = $report['priority_score'] >= 80 ? 'CRITICAL' : ($report['priority_score'] >= 50 ? 'URGENT' : 'STANDARD');
        ?>

        <div style="background:#111;border:1px solid #222;border-radius:8px;padding:30px;margin-bottom:30px;">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:15px;">
                <div>
                    <p style="color:#555;font-size:11px;letter-spacing:2px;">REFERENCE</p>
                    <p style="font-size:1.5rem;font-weight:bold;"><?php echo $report['ref_num']; ?></p>
                </div>
                <div style="text-align:right;">
                    <p style="color:#555;font-size:11px;letter-spacing:2px;">PRIORITY</p>
                    <p style="font-size:1.5rem;font-weight:bold;color:<?php echo $score_color; ?>;"><?php echo $report['priority_score']; ?> — <?php echo $score_label; ?></p>
                </div>
            </div>

            <hr style="border-color:#222;margin:20px 0;">

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:15px;margin-bottom:20px;">
                <div>
                    <p style="color:#555;font-size:11px;letter-spacing:1px;">TYPE</p>
                    <p style="font-weight:bold;"><?php echo $report['type']; ?></p>
                </div>
                <div>
                    <p style="color:#555;font-size:11px;letter-spacing:1px;">SEVERITY</p>
                    <p style="font-weight:bold;"><?php echo $report['severity']; ?></p>
                </div>
                <div>
                    <p style="color:#555;font-size:11px;letter-spacing:1px;">LOCATION</p>
                    <p style="font-weight:bold;"><?php echo $report['location']; ?></p>
                </div>
                <div>
                    <p style="color:#555;font-size:11px;letter-spacing:1px;">REPORTED</p>
                    <p style="font-weight:bold;"><?php echo date('d M Y, H:i', strtotime($report['created_at'])); ?></p>
                </div>
            </div>

            <div style="background:#0a0a0a;border-radius:6px;padding:15px;margin-bottom:25px;">
                <p style="color:#555;font-size:11px;letter-spacing:1px;margin-bottom:8px;">DESCRIPTION</p>
                <p style="color:#ccc;font-size:14px;"><?php echo $report['description']; ?></p>
            </div>

            <!-- STATUS TRACKER -->
            <p style="color:#555;font-size:11px;letter-spacing:2px;margin-bottom:20px;">RESPONSE STATUS</p>
            <div style="display:flex;justify-content:space-between;align-items:center;position:relative;">
                <div style="position:absolute;top:18px;left:0;right:0;height:2px;background:#222;z-index:0;"></div>
                <?php foreach ($status_steps as $i => $step):
                    $done = $i <= $current_step;
                    $active = $i === $current_step;
                    $dot_color = $done ? ($active ? $score_color : '#27ae60') : '#333';
                    $text_color = $done ? 'white' : '#444';
                ?>
                <div style="text-align:center;z-index:1;flex:1;">
                    <div style="width:36px;height:36px;border-radius:50%;background:<?php echo $dot_color; ?>;margin:0 auto 8px;display:flex;align-items:center;justify-content:center;font-size:14px;border:2px solid <?php echo $done ? $dot_color : '#333'; ?>;">
                        <?php echo $done && !$active ? '✓' : ($i + 1); ?>
                    </div>
                    <p style="font-size:10px;color:<?php echo $text_color; ?>;letter-spacing:1px;"><?php echo strtoupper($step); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <p style="color:#555;font-size:12px;text-align:center;">
            Save your reference number <strong style="color:white;"><?php echo $report['ref_num']; ?></strong> to check back anytime.
        </p>
    <?php endif; ?>

</div>
</body>
</html>