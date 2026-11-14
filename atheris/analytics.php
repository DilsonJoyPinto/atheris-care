<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Health Analytics | Atheris</title>
<?php include 'includes/header.php' ?>
<div class="inner-bnr"><img src="logo/atheriswhite.png" alt="Atheris logo"><div class="container"><h2>Health Analytics</h2></div></div>
<main class="health-app"><div class="container">
<?php include 'includes/health-nav.php' ?>
<div class="page-heading"><div><div class="eyebrow">Atheris · Astronaut health monitoring</div><h2>Health Analytics</h2><p>Review trends in recorded heart rate, blood pressure, oxygen saturation, sleep duration and weight. A trend is a description of entered values, not a prediction or diagnosis.</p></div><a class="hp-btn" href="healthinfo.php">＋ Start Vital Scan</a></div>
<div class="hp-notice">Charts use values saved in this browser. Missing measurements are left out, not treated as zero or as evidence of normal health. Compare readings only when their units and measurement context are suitable.</div><div class="hp-row"><section class="hp-card"><div class="hp-toolbar"><div><h3 style="margin:0 0 4px">Heart-rate trend</h3><div class="hp-muted">Recorded heart rate (BPM) by assessment</div></div><select data-analytics-metric aria-label="Choose health trend"><option value="heart_rate">Heart rate</option><option value="blood_pressure">Blood pressure</option><option value="spo2">Oxygen saturation</option><option value="sleep_hours">Sleep duration</option><option value="weight_kg">Weight</option></select></div><div class="hp-chart-wrap"><canvas data-analytics-chart class="hp-chart" aria-label="Heart rate trend chart"></canvas></div></section><section class="hp-card"><h3>Latest available readings</h3><div class="hp-statline" data-analytics-latest><span>No saved readings yet.</span></div><p class="hp-muted">Choose a measurement to review its history. A trend line requires at least two recorded values; one reading alone cannot show a change over time.</p></section></div><div class="hp-card"><h3>Available trend series</h3><div class="hp-statline"><span>Heart rate · BPM</span><span>Blood pressure · mmHg</span><span>SpO₂ · %</span><span>Sleep · hours</span></div><p class="hp-muted">This prototype plots the selected measurement from saved browser records. It does not currently analyse bone-density scans, OCT images or laboratory biomarkers, and it does not calculate clinical risk.</p></div>
</div></main>
<?php include 'includes/footer.php' ?>
</html>