<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Report Emergency | RESQ KENYA</title>
</head>
<body>
    <div class="container report-page">
        <nav style="display: flex; justify-content: space-between; padding: 20px 0;">
            <div class="logo"><span>●</span> RESQ KENYA</div>
            <a href="index.php" class="btn-outline" style="padding: 5px 15px; font-size: 12px;">← Back</a>
        </nav>

        <header style="margin-bottom: 40px;">
            <p class="label-red">EMERGENCY REPORT</p>
            <h1 style="font-size: 3.5rem; line-height: 1;">REPORT AN<br>EMERGENCY</h1>
            <p style="color: var(--text-muted); margin-top: 15px;">Select the emergency type, severity, and your location. Help is on the way.</p>
        </header>

        <form action="process_report.php" method="POST" id="emergencyForm">
            <div class="category-grid">
                <?php
                $types = [
                    ['Medical', 'Injury • Illness', '✚', '#ff3131', 40],
                    ['Fire', 'Blaze • Explosion', '🔥', '#f1c40f', 35],
                    ['Police', 'Crime • Security', '🚔', '#3498db', 30],
                    ['Flood', 'Water • Drainage', '🌊', '#1abc9c', 25],
                    ['Road Accident', 'Crash • ', '🚗', '#9b59b6', 30],
                    ['Gas / Chemical', 'Leak • Spill', '⚠️', '#e67e22', 45],
                    ['Missing Person', 'Lost • ', '🔍', '#16a085', 20],
                    ['Collapse', 'Building • Land', '🏚️', '#d35400', 50]
                ];

                foreach ($types as $t) {
                    echo "
                    <label class='cat-card'>
                        <input type='radio' name='type' value='{$t[0]}' data-weight='{$t[4]}' required>
                        <div class='card-content'>
                            <span class='icon' style='color:{$t[3]}'>{$t[2]}</span>
                            <strong>{$t[0]}</strong>
                            <small>{$t[1]}</small>
                        </div>
                    </label>";
                }
                ?>
            </div>

            <div class="form-section">
                <h3>SEVERITY LEVEL</h3>
                <div class="severity-toggle">
                    <label><input type="radio" name="severity" value="Low" data-weight="0"> <div class="sev-btn"><strong>Low</strong><small>Not life-threatening</small></div></label>
                    <label><input type="radio" name="severity" value="Medium" data-weight="20" checked> <div class="sev-btn"><strong>Medium</strong><small>Urgent attention</small></div></label>
                    <label><input type="radio" name="severity" value="High" data-weight="40"> <div class="sev-btn"><strong>High</strong><small>Life-threatening</small></div></label>
                </div>
            </div>

            <div class="form-section">
                <label>DESCRIPTION</label>
                <p class="input-hint">Briefly describe the emergency</p>
                <textarea name="description" placeholder="e.g. Person collapsed near the market entrance..." required></textarea>

                <label style="margin-top: 25px; display: block;">LOCATION</label>
                <p class="input-hint">Your location</p>
                <div style="display: flex; gap: 10px;">
                    <input type="text" name="location" id="locationInput" placeholder="Nearest landmark, estate or town" style="flex-grow: 1;" required>
                    <input type="hidden" name="latitude" id="latInput">
                    <input type="hidden" name="longitude" id="lngInput">
                    <button type="button" class="btn-outline" onclick="getLocation()" style="display: flex; align-items: center; gap: 8px;">
                        <span style="font-size: 18px;">⌖</span> Use GPS
                    </button>
                </div>
                <p class="input-hint" style="font-size: 10px; margin-top: 5px;">Tap GPS to auto-capture, or type your location manually.</p>
            </div>

            <div class="score-container">
                <div>
                    <span style="font-size: 10px; color: var(--text-muted); letter-spacing: 1px;">PRIORITY SCORE</span><br>
                    <span style="font-size: 10px; color: #444;">Auto-calculated from type + severity</span>
                </div>
                <div style="display: flex; align-items: center; gap: 20px; flex-grow: 1; justify-content: flex-end;">
                    <div class="score-bar-bg"><div id="scoreBar" class="score-bar-fill"></div></div>
                    <span id="scoreText" style="font-size: 2rem; font-weight: bold; color: var(--resq-red);">50</span>
                </div>
                <input type="hidden" name="priority_score" id="scoreInput" value="50">
            </div>

            <button type="submit" class="btn-red-large">Submit Emergency Report</button>
        </form>
    </div>

    <script src="script.js"></script>
</body>
</html>