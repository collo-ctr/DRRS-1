<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>RESQ KENYA | Report. Respond. Save Lives.</title>
</head>
<body>

    <nav>
        <div class="logo"><span>●</span> RESQ KENYA</div>
        <div style="display: flex; gap: 30px; align-items: center;">
            <a href="login.php" style="color: var(--text-muted); text-decoration: none; font-size: 14px;">Dispatcher</a>
            <a href="sms_guide.php" style="color: var(--text-muted); text-decoration: none; font-size: 14px;">SMS Guide</a>
            <a href="track.php" style="color: var(--text-muted); text-decoration: none; font-size: 14px;">Track Report</a>
            <a href="report.php" class="btn-red">Report Emergency</a>
        </div>
    </nav>

    <div class="container">
        <header style="padding: 120px 0;">
<?php
$active = $conn->query("SELECT COUNT(*) as c FROM emergency_reports WHERE status != 'Resolved'")->fetch_assoc()['c'];
$resolved = $conn->query("SELECT COUNT(*) as c FROM emergency_reports WHERE status = 'Resolved'")->fetch_assoc()['c'];
?>
<div style="display:flex;gap:30px;margin-bottom:25px;flex-wrap:wrap;">
    <div style="color:#00ff00;font-size:12px;">● System Active — Kenya Emergency Network</div>

</div>            <h1 class="hero-h1">REPORT.<br><span style="color: var(--resq-red);">RESPOND.</span><br>SAVE LIVES.</h1>
            <p style="color: var(--text-muted); font-size: 1.2rem; max-width: 550px;">
                A mobile-first emergency reporting platform for Kenya. Report via web or SMS. Every second counts.
            </p>
            <div style="margin-top: 40px; display: flex; gap: 15px;">
                <a href="report.php" class="btn-red">Report Emergency</a>
                <a href="login.php" class="btn-outline" style="background: #111;">Dispatcher View</a>
            </div>
        </header>

        <section>
            <span class="label-red">Emergency Types</span>
            <h2 style="font-size: 3.5rem; line-height: 1.1; margin-bottom: 60px;">WHAT CAN<br>YOU REPORT?</h2>
            
            <div class="feature-grid">
                <div class="feature-card">
                    <div style="color: var(--resq-red); font-size: 2rem; margin-bottom: 20px;">✚</div>
                    <h3>Medical Emergency</h3>
                    <p style="color: var(--text-muted); font-size: 14px; margin-top: 10px;">Heart attacks, accidents, injuries, unconscious persons, or any life-threatening medical situation.</p>
                    <a href="report.php?type=medical" class="arrow">→</a>
                </div>

                <div class="feature-card">
                    <div style="color: #f1c40f; font-size: 2rem; margin-bottom: 20px;">🔥</div>
                    <h3>Fire Outbreak</h3>
                    <p style="color: var(--text-muted); font-size: 14px; margin-top: 10px;">Building fires, bush fires, gas explosions, or any fire that threatens life or property.</p>
                    <a href="report.php?type=fire" class="arrow arrow-active">→</a>
                </div>

                <div class="feature-card">
                    <div style="color: #3498db; font-size: 2rem; margin-bottom: 20px;">🚔</div>
                    <h3>Police / Security</h3>
                    <p style="color: var(--text-muted); font-size: 14px; margin-top: 10px;">Robbery, assault, theft, civil unrest, or any security threat requiring law enforcement.</p>
                    <a href="report.php?type=police" class="arrow">→</a>
                </div>

                <div class="feature-card">
                    <div style="color: #1abc9c; font-size: 2rem; margin-bottom: 20px;">🌊</div>
                    <h3>Flood / Water Hazard</h3>
                    <p style="color: var(--text-muted); font-size: 14px; margin-top: 10px;">Flash floods, rising waters, collapsed drainage, or areas submerged by heavy rainfall.</p>
                    <a href="report.php?type=flood" class="arrow">→</a>
                </div>

                <div class="feature-card">
                    <div style="color: #9b59b6; font-size: 2rem; margin-bottom: 20px;">🚗</div>
                    <h3>Road Accident</h3>
                    <p style="color: var(--text-muted); font-size: 14px; margin-top: 10px;">Vehicle collisions, overturned trucks, pedestrian knockdowns, or highway pile-ups.</p>
                    <a href="report.php?type=accident" class="arrow">→</a>
                </div>

                <div class="feature-card">
                    <div style="color: #e67e22; font-size: 2rem; margin-bottom: 20px;">⚠️</div>
                    <h3>Gas / Chemical Leak</h3>
                    <p style="color: var(--text-muted); font-size: 14px; margin-top: 10px;">Leaking gas cylinders, pipeline ruptures, chemical spills, or toxic fume exposure.</p>
                    <a href="report.php?type=gas" class="arrow">→</a>
                </div>

                <div class="feature-card">
                    <div style="color: #16a085; font-size: 2rem; margin-bottom: 20px;">🔍</div>
                    <h3>Missing Person</h3>
                    <p style="color: var(--text-muted); font-size: 14px; margin-top: 10px;">Lost children, vulnerable adults, or individuals missing in dangerous circumstances.</p>
                    <a href="report.php?type=missing" class="arrow arrow-active">→</a>
                </div>

                <div class="feature-card">
                    <div style="color: #d35400; font-size: 2rem; margin-bottom: 20px;">🏚️</div>
                    <h3>Structural Collapse</h3>
                    <p style="color: var(--text-muted); font-size: 14px; margin-top: 10px;">Building collapses, landslides, bridge failures, or any structure that has fallen on people.</p>
                    <a href="report.php?type=collapse" class="arrow">→</a>
                </div>
            </div>
        </section>

        <section>
            <span class="label-red">How It Works</span>
            <h2 style="font-size: 3.5rem; line-height: 1.1;">FOUR STEPS<br>TO HELP</h2>
            
            <div class="steps-grid">
                <div><div class="step-num">01</div><strong>Select Type</strong><p style="color: var(--text-muted); font-size: 13px;">Choose from 8 emergency types. Pick severity.</p></div>
                <div><div class="step-num">02</div><strong>Share Location</strong><p style="color: var(--text-muted); font-size: 13px;">GPS captures your location or type it manually.</p></div>
                <div><div class="step-num">03</div><strong>Auto-Prioritized</strong><p style="color: var(--text-muted); font-size: 13px;">System scores your report. Critical cases go to top.</p><a href="how_scoring_works.php" style="color:var(--resq-red);font-size:11px;text-decoration:none;">How scoring works →</a></div>                <div><div class="step-num">04</div><strong>Help Dispatched</strong><p style="color: var(--text-muted); font-size: 13px;">Dispatcher is alerted instantly. Teams deployed.</p></div>
            </div>
        </section>

        <section>
            <div class="sms-promo-box">
                <div>
                    <h2 style="font-size: 2.5rem; margin-bottom: 20px;">Feature phone users can report by SMS</h2>
                    <p style="color: var(--text-muted); margin-bottom: 30px;">Send a formatted SMS to <strong>22395</strong> using the format shown. No internet required.</p>
                    <a href="sms_guide.php" class="btn-outline">View Full SMS Guide →</a>
                </div>
                <div class="sms-format-box">
                    <p style="color: #666; margin-bottom: 15px;"># SMS Format:</p>
                    <p style="color: var(--resq-red);">RESQ <span style="color: #00ff00;">[TYPE] [SEVERITY] [LOCATION]</span></p>
                    <p style="color: #666; margin-top: 25px; margin-bottom: 10px;"># Example:</p>
                    <p>RESQ <span style="color: #00ff00;">MEDICAL HIGH Kibera</span></p>
                </div>
            </div>
        </section>

       <footer style="padding: 100px 0; text-align: center; border-top: 1px solid var(--border);">
    <h2 style="letter-spacing: 5px; margin-bottom: 15px;">RESQ KENYA</h2>
    <p style="color: #444; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 30px;">
        Academic prototype — Disaster Report and Response System<br>
        Not affiliated with official emergency services · For demonstration purposes
    </p>
    <div style="display:flex;justify-content:center;gap:30px;flex-wrap:wrap;">
        <a href="report.php" style="color:#555;font-size:12px;text-decoration:none;">Report Emergency</a>
        <a href="track.php" style="color:#555;font-size:12px;text-decoration:none;">Track Report</a>
        <a href="sms_guide.php" style="color:#555;font-size:12px;text-decoration:none;">SMS Guide</a>
        <a href="how_scoring_works.php" style="color:#555;font-size:12px;text-decoration:none;">How Scoring Works</a>
        <a href="login.php" style="color:#555;font-size:12px;text-decoration:none;">Dispatcher Login</a>
    </div>
</footer>
    </div>

</body>
</html>
