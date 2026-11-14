<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Alerts and Recommendations | Atheris</title>
<?php include 'includes/header.php' ?>
<div class="inner-bnr"><img src="logo/atheriswhite.png" alt="Atheris logo"><div class="container"><h2>Alerts & Recommendations</h2></div></div>
<main class="health-app"><div class="container">
<?php include 'includes/health-nav.php' ?>
<div class="page-heading"><div><div class="eyebrow">Atheris · Astronaut health monitoring</div><h2>Alerts & Recommendations</h2><p>Review symptoms reported during an assessment and the reason each item was flagged. Alerts are prompts for qualified medical review, not diagnoses or treatment instructions.</p></div><a class="hp-btn" href="healthinfo.php">＋ Start Vital Scan</a></div>
<div class="hp-notice warning">This prototype flags selected symptoms only when they are explicitly reported. It does not apply medical thresholds or predict a condition. Any future threshold-based alert must be defined and approved by the mission medical team.</div><div class="hp-card"><div class="hp-toolbar"><div><h3 style="margin:0 0 4px">Monitoring alerts</h3><div class="hp-muted">Symptoms reported in saved assessments for follow-up review</div></div><span class="severity attention">Review flagged items</span></div><div data-alert-list><div class="hp-empty">No alerts recorded.</div></div></div>
</div></main>
<?php include 'includes/footer.php' ?>
</html>