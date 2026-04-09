<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- PRIORITY SCORING ALGORITHM (server-side) ---
    $type_scores = [
        'Medical'       => 40,
        'Gas / Chemical'=> 45,
        'Collapse'      => 50,
        'Fire'          => 35,
        'Road Accident' => 30,
        'Police'        => 30,
        'Flood'         => 25,
        'Missing Person'=> 20,
    ];

    $severity_scores = [
        'High'   => 40,
        'Medium' => 20,
        'Low'    => 0,
    ];

    $type     = $conn->real_escape_string($_POST['type']);
    $severity = $conn->real_escape_string($_POST['severity']);
    $location = $conn->real_escape_string($_POST['location']);
    $description = $conn->real_escape_string($_POST['description']);
    $latitude  = isset($_POST['latitude'])  ? floatval($_POST['latitude'])  : null;
    $longitude = isset($_POST['longitude']) ? floatval($_POST['longitude']) : null;

    // Calculate score server-side — ignore whatever the frontend sent
    $base  = isset($type_scores[$type]) ? $type_scores[$type] : 20;
    $sev   = isset($severity_scores[$severity]) ? $severity_scores[$severity] : 0;

    // Time-of-night bonus: emergencies reported between 10pm–5am get +10
    $hour  = (int) date('H');
    $night_bonus = ($hour >= 22 || $hour < 5) ? 10 : 0;

    $priority_score = min(100, $base + $sev + $night_bonus);

    // Generate reference number
    $ref_num = "RES-" . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

    // Prepared statement — fixes SQL injection
    $stmt = $conn->prepare("INSERT INTO emergency_reports (ref_num, type, severity, location, description, priority_score, latitude, longitude) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssidd", $ref_num, $type, $severity, $location, $description, $priority_score, $latitude, $longitude);
    if ($stmt->execute()) {
        header("Location: success.php?ref=" . $ref_num . "&score=" . $priority_score);
        exit();
    } else {
        echo "Error saving report. Please try again.";
    }
}
?>