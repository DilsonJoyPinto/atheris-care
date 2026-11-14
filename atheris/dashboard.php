<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Health Dashboard | Atheris</title>
<?php include 'includes/header.php' ?>
<div class="inner-bnr"><img src="logo/atheriswhite.png" alt="Atheris logo"><div class="container"><h2>Dashboard</h2></div></div>
<main class="health-app"><div class="container">
<?php include 'includes/health-nav.php' ?>
<div class="page-heading"><div><div class="eyebrow">Atheris · Astronaut health monitoring</div><h2>Dashboard</h2><p>A current view of recorded observations, recent assessment activity and symptoms marked for medical review. Trends describe the available records; they do not establish a diagnosis.</p></div><a class="hp-btn" href="healthinfo.php">＋ Start Vital Scan</a></div>
<div data-dashboard>
<div class="hp-notice">Prototype mode: entries are stored in this browser only. The dashboard summarises submitted information and does not assess clinical fitness or generate medical conclusions.</div>
<div class="hp-card" style="margin-bottom:16px"><div class="hp-toolbar"><div><div class="eyebrow">Current overview</div><h3 style="margin:0">Overall health status</h3></div><span id="dash-status" class="status-pill">No assessment yet</span></div><p id="dash-status-note" class="hp-muted">Submit an initial assessment to create a starting record for later comparisons.</p><div class="hp-muted">Latest assessment: <strong id="dash-date">No assessment recorded</strong></div></div>
<div class="hp-grid">
<div class="hp-card metric-card"><div class="metric-top"><span>Heart rate</span><span class="metric-icon">♥</span></div><div class="metric-value" id="dash-heart">—</div><div class="metric-unit">BPM · latest entry</div></div>
<div class="hp-card metric-card"><div class="metric-top"><span>Blood pressure</span><span class="metric-icon">＋</span></div><div class="metric-value" id="dash-bp">—</div><div class="metric-unit">mmHg · systolic / diastolic values</div></div>
<div class="hp-card metric-card"><div class="metric-top"><span>Oxygen saturation</span><span class="metric-icon">◉</span></div><div class="metric-value" id="dash-spo2">—</div><div class="metric-unit">SpO₂ · latest entry</div></div>
<div class="hp-card metric-card"><div class="metric-top"><span>Sleep duration</span><span class="metric-icon">☾</span></div><div class="metric-value" id="dash-sleep">—</div><div class="metric-unit">Hours · latest entry</div></div>
</div>
<div class="hp-row"><section class="hp-card"><div class="hp-toolbar"><div><h3 style="margin-bottom:3px">Health trend</h3><div class="hp-muted">Recorded heart-rate values across saved assessments</div></div><a href="analytics.php" class="hp-btn secondary small">View analytics</a></div><div class="hp-chart-wrap"><canvas id="dashboard-chart" class="hp-chart" aria-label="Heart rate trend graph"></canvas></div></section>
<section class="hp-card"><div class="hp-toolbar"><h3 style="margin:0">Recent alerts</h3><a href="alerts.php" class="hp-muted">View all</a></div><div class="hp-alert-list" data-recent-alerts><div class="hp-empty">No alerts to display.</div></div></section></div>
<div class="hp-card"><div class="hp-toolbar"><div><h3 style="margin:0 0 4px">Ready for your next check?</h3><div class="hp-muted">Add a dated assessment to extend the astronaut's health record.</div></div><a href="healthinfo.php" class="hp-btn">Start Vital Scan →</a></div></div>
</div>
</div></main>
<?php include 'includes/footer.php' ?>
</html>