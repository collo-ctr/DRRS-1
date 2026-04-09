<?php
session_start();
if (!isset($_SESSION['user_id'])) { http_response_code(401); exit(); }
include 'db.php';

$total_active  = $conn->query("SELECT COUNT(*) as c FROM emergency_reports WHERE status != 'Resolved'")->fetch_assoc()['c'];
$high_priority = $conn->query("SELECT COUNT(*) as c FROM emergency_reports WHERE priority_score >= 80 AND status != 'Resolved'")->fetch_assoc()['c'];
$in_progress   = $conn->query("SELECT COUNT(*) as c FROM emergency_reports WHERE status = 'In Progress'")->fetch_assoc()['c'];
$resolved_today= $conn->query("SELECT COUNT(*) as c FROM emergency_reports WHERE status = 'Resolved' AND DATE(created_at) = CURDATE()")->fetch_assoc()['c'];

$incidents = $conn->query("SELECT * FROM emergency_reports ORDER BY CASE WHEN status = 'Resolved' THEN 1 ELSE 0 END ASC, priority_score DESC");

ob_start();
while($row = $incidents->fetch_assoc()):
    $border = $row['status'] == 'Resolved' ? '#27ae60' : ($row['priority_score'] >= 80 ? 'var(--resq-red)' : '#333');
    $fade   = $row['status'] == 'Resolved' ? 'resolved-fade' : '';
?>
<div class="incident-card <?php echo $fade; ?>" style="border-left:4px solid <?php echo $border; ?>">
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
                <option value="Pending"      <?php if($row['status']=='Pending')      echo 'selected'; ?>>Pending</option>
                <option value="Acknowledged" <?php if($row['status']=='Acknowledged') echo 'selected'; ?>>Acknowledged</option>
                <option value="In Progress"  <?php if($row['status']=='In Progress')  echo 'selected'; ?>>In Progress</option>
                <option value="Resolved"     <?php if($row['status']=='Resolved')     echo 'selected'; ?>>Resolved</option>
            </select>
            <button type="submit" name="submit_status" class="btn-mark-resolved">Mark Resolved</button>
        </form>
    </div>
</div>
<?php endwhile;
$html = ob_get_clean();

header('Content-Type: application/json');
echo json_encode([
    'html'          => $html,
    'total_active'  => $total_active,
    'high_priority' => $high_priority,
    'in_progress'   => $in_progress,
    'resolved_today'=> $resolved_today
]);
?>