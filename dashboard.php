<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include 'db.php';

// 1. Fetch Stats - Keep these as they are to show counts correctly
$total_q = $conn->query("SELECT COUNT(*) as c FROM emergency_reports WHERE status != 'Resolved'");
$total_active = $total_q->fetch_assoc()['c'];

$high_q = $conn->query("SELECT COUNT(*) as c FROM emergency_reports WHERE priority_score >= 80 AND status != 'Resolved'");
$high_priority = $high_q->fetch_assoc()['c'];

$progress_q = $conn->query("SELECT COUNT(*) as c FROM emergency_reports WHERE status = 'In Progress'");
$in_progress = $progress_q->fetch_assoc()['c'];

$resolved_q = $conn->query("SELECT COUNT(*) as c FROM emergency_reports WHERE status = 'Resolved' AND DATE(created_at) = CURDATE()");
$resolved_today = $resolved_q->fetch_assoc()['c'];

// 2. MODIFIED: Fetch incidents but don't hide 'Resolved' status.
// We sort so 'Resolved' items go to the bottom automatically.
$incidents = $conn->query("SELECT * FROM emergency_reports 
    ORDER BY 
    CASE WHEN status = 'Resolved' THEN 1 ELSE 0 END ASC, 
    priority_score DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Dispatcher Dashboard | RESQ KENYA</title>
</head>
< class="dashboard-body">

    <nav class="dash-nav">
        <div class="logo"><span>●</span> RESQ <small>Dispatcher Dashboard</small></div>
        <div class="nav-right">
            <span class="status-live">● LIVE</span>
            <span class="user-tag"><?php echo $_SESSION['username']; ?></span>
            <a href="analytics.php" class="btn-outline" style="font-size:12px;margin-right:15px;">📊 Analytics</a>
            <a href="map.php" class="btn-outline" style="font-size:12px;margin-right:15px;">🗺️ Map</a>           <a href="logout.php" class="sign-out">Sign Out</a>
        </div>
    </nav>

    <div class="container">
        <div class="stats-grid">
            <div class="stat-card">
                <small>TOTAL ACTIVE</small>
                <div class="stat-value"><?php echo $total_active; ?></div>
            </div>
            <div class="stat-card urgent">
                <small>HIGH PRIORITY</small>
                <div class="stat-value"><?php echo $high_priority; ?></div>
            </div>
            <div class="stat-card progress-card">
                <small>IN PROGRESS</small>
                <div class="stat-value"><?php echo $in_progress; ?></div>
            </div>
            <div class="stat-card success">
                <small>RESOLVED TODAY</small>
                <div class="stat-value"><?php echo $resolved_today; ?></div> 
            </div>
        </div>

        <div class="filter-bar">
             <button class="filter-btn active" onclick="filterIncidents('all')">All</button>
             <button class="filter-btn" onclick="filterIncidents('medical')">Medical</button>
             <button class="filter-btn" onclick="filterIncidents('fire')">Fire</button>
             <button class="filter-btn" onclick="filterIncidents('police')">Police</button>
             <button class="filter-btn" onclick="filterIncidents('flood')">Flood</button>
             <button class="filter-btn" onclick="filterIncidents('collapse')">Collapse</button>
             <button class="simulate-btn" onclick="simulateIncoming()">+ Simulate Incoming</button>
        </div>

        <div class="incident-list">
            <?php while($row = $incidents->fetch_assoc()): ?>
            <div class="incident-card <?php echo ($row['status'] == 'Resolved') ? 'resolved-fade' : ''; ?>" 
                 style="border-left: 4px solid <?php echo ($row['status'] == 'Resolved') ? '#27ae60' : (($row['priority_score'] >= 80) ? 'var(--resq-red)' : '#333'); ?>">
                
                <div class="score-section">
                    <span class="score-val"><?php echo $row['priority_score']; ?></span>
                    <small>SCORE</small>
                </div>
                
                <div class="content-section">
                    <div class="meta-row">
                        <span class="ref"><?php echo $row['ref_num']; ?></span>
                        <span class="tag-type <?php echo strtolower($row['type']); ?>"><?php echo strtoupper($row['type']); ?></span>
                    </div>
                    <p class="desc"><?php echo $row['description']; ?></p>
                    <div class="sub-meta">
                        <?php echo $row['location']; ?> • 
                        <span class="status-indicator <?php echo strtolower(str_replace(' ', '-', $row['status'])); ?>">
                            ● <?php echo $row['status']; ?>
                        </span>
                    </div>
                </div>

                <div class="action-section">
                    <form action="update_status.php" method="POST">
                        <input type="hidden" name="report_id" value="<?php echo $row['id']; ?>">
                        <select name="new_status" class="status-dropdown" onchange="this.form.submit()">
                            <option value="Pending" <?php if($row['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                            <option value="Acknowledged" <?php if($row['status'] == 'Acknowledged') echo 'selected'; ?>>Acknowledged</option>
                            <option value="In Progress" <?php if($row['status'] == 'In Progress') echo 'selected'; ?>>In Progress</option>
                            <option value="Resolved" <?php if($row['status'] == 'Resolved') echo 'selected'; ?>>Resolved</option>
                        </select>
                        <button type="submit" name="submit_status" class="btn-mark-resolved">Mark Resolved</button>
                    </form>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
<script>
// --- FILTER LOGIC ---
function filterIncidents(type) {
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    event.target.classList.add('active');

    document.querySelectorAll('.incident-card').forEach(card => {
        const cardType = card.querySelector('.tag-type');
        if (!cardType) return;
        if (type === 'all' || cardType.classList.contains(type)) {
            card.style.display = 'flex';
        } else {
            card.style.display = 'none';
        }
    });
}

// --- SIMULATE INCOMING ---
function simulateIncoming() {
    const types = ['Medical','Fire','Police','Flood','Collapse','Road Accident'];
    const severities = ['High','High','Medium','Low'];
    const locations = ['Kibera, Nairobi','Westlands, Nairobi','Mombasa Road','Kisumu CBD','Nakuru Town'];
    const descriptions = [
        'Person collapsed and unresponsive near the market.',
        'Fire spreading from ground floor of residential building.',
        'Armed robbery reported at petrol station.',
        'Rising floodwaters blocking main road.',
        'Partial roof collapse, people trapped inside.'
    ];

    const t = types[Math.floor(Math.random() * types.length)];
    const s = severities[Math.floor(Math.random() * severities.length)];
    const l = locations[Math.floor(Math.random() * locations.length)];
    const d = descriptions[Math.floor(Math.random() * descriptions.length)];

    fetch('process_report.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `type=${encodeURIComponent(t)}&severity=${encodeURIComponent(s)}&location=${encodeURIComponent(l)}&description=${encodeURIComponent(d)}`
    }).then(r => {
        if (r.ok) {
            showAlert('🚨 Incoming report simulated — ' + t + ' / ' + s);
            setTimeout(() => location.reload(), 1500);
        }
    });
}

// --- ALERT TOAST ---
function showAlert(msg) {
    const toast = document.createElement('div');
    toast.style.cssText = 'position:fixed;top:20px;right:20px;background:#ff3131;color:white;padding:15px 25px;border-radius:6px;font-weight:bold;z-index:9999;font-size:14px;';
    toast.textContent = msg;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}
// --- AJAX POLLING every 15 seconds ---
function pollNewReports() {
    fetch('get_reports.php')
        .then(r => r.json())
        .then(data => {
            const list = document.querySelector('.incident-list');
            if (data.html) list.innerHTML = data.html;
            document.querySelector('.stat-card:nth-child(1) .stat-value').textContent = data.total_active;
            document.querySelector('.stat-card:nth-child(2) .stat-value').textContent = data.high_priority;
            document.querySelector('.stat-card:nth-child(3) .stat-value').textContent = data.in_progress;
            document.querySelector('.stat-card:nth-child(4) .stat-value').textContent = data.resolved_today;
        });
}
setInterval(pollNewReports, 15000);
</script>
</body>
</html>