<?php
include 'db.php';

// Africa's Talking SMS webhook
// They POST these fields: from, to, text, date
$from = isset($_POST['from']) ? $conn->real_escape_string($_POST['from']) : '';
$text = isset($_POST['text']) ? strtoupper(trim($_POST['text'])) : '';

// Expected format: RESQ [TYPE] [SEVERITY] [LOCATION]
// Example: RESQ MEDICAL HIGH Kibera Nairobi

if (empty($text) || strpos($text, 'RESQ') !== 0) {
    echo "INVALID FORMAT";
    exit();
}

// Parse the SMS
$parts = explode(' ', $text, 4);

if (count($parts) < 4) {
    echo "FORMAT ERROR";
    exit();
}

$type_raw     = strtolower($parts[1]);
$severity_raw = ucfirst(strtolower($parts[2]));
$location     = isset($parts[3]) ? $parts[3] : 'Unknown';

// Map SMS shortcodes to full type names
$type_map = [
    'medical'  => 'Medical',
    'med'      => 'Medical',
    'fire'     => 'Fire',
    'police'   => 'Police',
    'pol'      => 'Police',
    'flood'    => 'Flood',
    'accident' => 'Road Accident',
    'acc'      => 'Road Accident',
    'gas'      => 'Gas / Chemical',
    'collapse' => 'Collapse',
    'col'      => 'Collapse',
    'missing'  => 'Missing Person',
    'mis'      => 'Missing Person',
];

$type = isset($type_map[$type_raw]) ? $type_map[$type_raw] : 'Medical';

// Validate severity
$valid_severities = ['Low', 'Medium', 'High'];
if (!in_array($severity_raw, $valid_severities)) $severity_raw = 'Medium';

// Server-side priority scoring (same algorithm as process_report.php)
$type_scores = [
    'Medical' => 40, 'Gas / Chemical' => 45, 'Collapse' => 50,
    'Fire' => 35, 'Road Accident' => 30, 'Police' => 30,
    'Flood' => 25, 'Missing Person' => 20,
];
$severity_scores = ['High' => 40, 'Medium' => 20, 'Low' => 0];

$base        = isset($type_scores[$type]) ? $type_scores[$type] : 20;
$sev         = isset($severity_scores[$severity_raw]) ? $severity_scores[$severity_raw] : 0;
$hour        = (int) date('H');
$night_bonus = ($hour >= 22 || $hour < 5) ? 10 : 0;
$score       = min(100, $base + $sev + $night_bonus);

// Generate reference number
$ref_num = "RES-" . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

// Save to database
$stmt = $conn->prepare("INSERT INTO emergency_reports (ref_num, type, severity, location, description, priority_score) VALUES (?, ?, ?, ?, ?, ?)");
$description = "Reported via SMS from " . $from;
$stmt->bind_param("sssssi", $ref_num, $type, $severity_raw, $location, $description, $score);
$stmt->execute();

// Respond to Africa's Talking with confirmation SMS back to reporter
echo "Your emergency has been received. Reference: $ref_num. Priority score: $score. Help is on the way.";
?>