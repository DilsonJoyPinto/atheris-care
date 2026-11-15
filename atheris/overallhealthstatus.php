<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Overall Health Status | Atheris</title>
<?php include 'includes/header.php' ?>
<div class="inner-bnr"><img src="logo/atheriswhite.png" alt="Atheris logo"><div class="container"><h2>Overall Health Status</h2></div></div>
<main class="health-app"data-dashboard><div class="container">
<?php include 'includes/health-nav.php' ?>
<div class="page-heading"><div><div class="eyebrow">Atheris · Astronaut health monitoring</div><h2>Overall Health Status</h2><p>A summary of the latest assessment record, including the measurements that were entered.</p></div><a class="hp-btn" href="healthinfo.php">＋ Start Vital Scan</a></div>
<div class="hp-notice">This page displays the latest browser-saved assessment. Its status reflects recorded information and selected reported symptoms only; it is not a clinical evaluation of the astronaut’s overall health.</div><div class="hp-card"><div class="hp-toolbar"><div><div class="eyebrow">Latest assessment</div><h3 style="margin:0">Assessment summary</h3></div><span class="status-pill" id="dash-status">No assessment yet</span></div><p class="hp-muted" id="dash-status-note">No assessment has been saved in this browser yet. Submit a Vital Scan to create the first record.</p><div class="hp-grid" style="margin-top:18px"><div class="hp-card"><div class="metric-top">Heart rate</div><div class="metric-value" id="dash-heart">—</div><div class="metric-unit">BPM</div></div><div class="hp-card"><div class="metric-top">Blood pressure</div><div class="metric-value" id="dash-bp">—</div><div class="metric-unit">mmHg</div></div><div class="hp-card"><div class="metric-top">Oxygen saturation</div><div class="metric-value" id="dash-spo2">—</div><div class="metric-unit">SpO₂ %</div></div><div class="hp-card"><div class="metric-top">Sleep duration</div><div class="metric-value" id="dash-sleep">—</div><div class="metric-unit">Hours</div></div></div><div class="hp-muted">Latest record: <strong id="dash-date">—</strong></div><div class="hp-actions"><a class="hp-btn" href="healthinfo.php">Start another Vital Scan</a><a class="hp-btn secondary" href="history.php">View health history</a><a class="hp-btn secondary" href="reports.php">View reports</a></div></div><div class="hp-card" style="margin-top:16px"><h3>Health trend</h3><div class="hp-chart-wrap"><canvas id="dashboard-chart" class="hp-chart"></canvas></div></div><div data-recent-alerts class="hp-card" style="margin-top:16px"><h3>Recent alerts</h3></div>
</div></main>
<?php include 'includes/footer.php' ?>
</html>
