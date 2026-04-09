<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }
include 'db.php';

$reports = $conn->query("SELECT id, ref_num, type, severity, priority_score, location, latitude, longitude, status, created_at 
                          FROM emergency_reports 
                          WHERE latitude IS NOT NULL AND longitude IS NOT NULL
                          ORDER BY priority_score DESC");
$markers = [];
while($r = $reports->fetch_assoc()) $markers[] = $r;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<title>Incident Map | RESQ KENYA</title>
<style>
#map { height: 600px; border-radius: 8px; border: 1px solid #222; }
.legend { background:#111; padding:15px; border-radius:6px; border:1px solid #222; }
</style>
</head>
<body class="dashboard-body">
<nav class="dash-nav">
    <div class="logo"><span>●</span> RESQ <small>Incident Map</small></div>
    <div class="nav-right">
        <a href="dashboard.php" class="btn-outline" style="font-size:12px;margin-right:15px;">← Dashboard</a>
        <a href="logout.php" class="sign-out">Sign Out</a>
    </div>
</nav>
<div class="container" style="padding-top:40px;">
    <span class="label-red">LIVE MAP</span>
    <h2 style="font-size:2.5rem;margin-bottom:10px;">INCIDENT MAP</h2>
    <p style="color:#555;margin-bottom:30px;">Showing <?php echo count($markers); ?> geo-tagged incidents. Pin color = priority level.</p>

    <div id="map"></div>

    <div class="legend" style="margin-top:20px;display:flex;gap:30px;flex-wrap:wrap;">
        <span style="color:#ff3131;">● High Priority (score ≥ 80)</span>
        <span style="color:#f1c40f;">● Medium Priority (score 50–79)</span>
        <span style="color:#27ae60;">● Lower Priority (score &lt; 50)</span>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
const map = L.map('map').setView([-1.2921, 36.8219], 7); // Kenya center

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap'
}).addTo(map);

const incidents = <?php echo json_encode($markers); ?>;

incidents.forEach(inc => {
    const score = parseInt(inc.priority_score);
    const color = score >= 80 ? '#ff3131' : score >= 50 ? '#f1c40f' : '#27ae60';

    const icon = L.divIcon({
        className: '',
        html: `<div style="width:14px;height:14px;background:${color};border-radius:50%;border:2px solid white;box-shadow:0 0 6px ${color};"></div>`,
        iconSize: [14, 14],
        iconAnchor: [7, 7]
    });

    const marker = L.marker([parseFloat(inc.latitude), parseFloat(inc.longitude)], {icon})
        .addTo(map);

    marker.bindPopup(`
        <div style="font-family:monospace;min-width:200px;">
            <strong style="color:${color};">${inc.ref_num}</strong><br>
            <b>${inc.type}</b> — ${inc.severity}<br>
            📍 ${inc.location}<br>
            🎯 Priority Score: <b>${inc.priority_score}</b><br>
            ⚡ Status: ${inc.status}<br>
            <small style="color:#888;">${inc.created_at}</small>
        </div>
    `);
});
</script>
</body>
</html>