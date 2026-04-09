<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }
include 'db.php';

$by_type    = $conn->query("SELECT type, COUNT(*) as total FROM emergency_reports GROUP BY type ORDER BY total DESC");
$by_status  = $conn->query("SELECT status, COUNT(*) as total FROM emergency_reports GROUP BY status");
$by_hour    = $conn->query("SELECT HOUR(created_at) as hr, COUNT(*) as total FROM emergency_reports GROUP BY hr ORDER BY hr");
$avg_score  = $conn->query("SELECT AVG(priority_score) as avg FROM emergency_reports")->fetch_assoc()['avg'];
$total_all  = $conn->query("SELECT COUNT(*) as c FROM emergency_reports")->fetch_assoc()['c'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="style.css">
<title>Analytics | RESQ KENYA</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="dashboard-body">
<nav class="dash-nav">
    <div class="logo"><span>●</span> RESQ <small>Analytics</small></div>
    <div class="nav-right">
        <a href="dashboard.php" class="btn-outline" style="font-size:12px;">← Dashboard</a>
        <a href="logout.php" class="sign-out">Sign Out</a>
    </div>
</nav>
<div class="container" style="padding-top:40px;">
    <span class="label-red">DATA INSIGHTS</span>
    <h2 style="font-size:2.5rem;margin-bottom:40px;">INCIDENT ANALYTICS</h2>

    <div class="stats-grid" style="margin-bottom:50px;">
        <div class="stat-card"><small>TOTAL REPORTS</small><div class="stat-value"><?php echo $total_all; ?></div></div>
        <div class="stat-card urgent"><small>AVG PRIORITY SCORE</small><div class="stat-value"><?php echo round($avg_score, 1); ?></div></div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:40px;margin-bottom:50px;">
        <div style="background:#111;border:1px solid #222;padding:30px;border-radius:8px;">
            <h3 style="margin-bottom:20px;font-size:14px;letter-spacing:2px;">REPORTS BY TYPE</h3>
            <canvas id="typeChart"></canvas>
        </div>
        <div style="background:#111;border:1px solid #222;padding:30px;border-radius:8px;">
            <h3 style="margin-bottom:20px;font-size:14px;letter-spacing:2px;">REPORTS BY STATUS</h3>
            <canvas id="statusChart"></canvas>
        </div>
    </div>

    <div style="background:#111;border:1px solid #222;padding:30px;border-radius:8px;margin-bottom:50px;">
        <h3 style="margin-bottom:20px;font-size:14px;letter-spacing:2px;">REPORTS BY HOUR OF DAY (Peak Times)</h3>
        <canvas id="hourChart"></canvas>
    </div>
</div>

<script>
<?php
$type_labels = []; $type_data = [];
while($r = $by_type->fetch_assoc()) { $type_labels[] = $r['type']; $type_data[] = $r['total']; }

$status_labels = []; $status_data = [];
while($r = $by_status->fetch_assoc()) { $status_labels[] = $r['status']; $status_data[] = $r['total']; }

$hour_labels = array_fill(0, 24, 0);
$hour_data   = array_fill(0, 24, 0);
while($r = $by_hour->fetch_assoc()) { $hour_data[$r['hr']] = $r['total']; }
for($i=0;$i<24;$i++) $hour_labels[$i] = $i.':00';
?>

new Chart(document.getElementById('typeChart'), {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($type_labels); ?>,
        datasets: [{ label: 'Reports', data: <?php echo json_encode($type_data); ?>,
        backgroundColor: ['#ff3131','#f1c40f','#3498db','#1abc9c','#d35400','#e67e22','#16a085','#9b59b6'] }]
    },
    options: { plugins: { legend: { display: false } }, scales: { x: { ticks: { color:'#888' } }, y: { ticks: { color:'#888' }, beginAtZero:true } } }
});

new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: <?php echo json_encode($status_labels); ?>,
        datasets: [{ data: <?php echo json_encode($status_data); ?>,
        backgroundColor: ['#ff3131','#f1c40f','#3498db','#27ae60'] }]
    },
    options: { plugins: { legend: { labels: { color:'#888' } } } }
});

new Chart(document.getElementById('hourChart'), {
    type: 'line',
    data: {
        labels: <?php echo json_encode($hour_labels); ?>,
        datasets: [{ label: 'Reports', data: <?php echo json_encode($hour_data); ?>,
        borderColor: '#ff3131', backgroundColor: 'rgba(255,49,49,0.1)', fill: true, tension: 0.4 }]
    },
    options: { plugins: { legend: { display: false } }, scales: { x: { ticks: { color:'#888' } }, y: { ticks: { color:'#888' }, beginAtZero:true } } }
});
</script>
</body>
</html>