<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Health History | Atheris</title>
<?php include 'includes/header.php' ?>
<div class="inner-bnr"><img src="logo/atheriswhite.png" alt="Atheris logo"><div class="container"><h2>Health History</h2></div></div>
<main class="health-app"><div class="container">
<?php include 'includes/health-nav.php' ?>
<div class="page-heading"><div><div class="eyebrow">Atheris · Astronaut health monitoring</div><h2>Health History</h2><p>Review dated assessments and open each saved record. Comparing an astronaut’s own results over time can help identify changes, provided the measurement methods and units are compatible.</p></div><a class="hp-btn" href="healthinfo.php">＋ Start Vital Scan</a></div>
<div class="hp-card"><div class="hp-toolbar"><div><h3 style="margin:0 0 4px">Assessment timeline</h3><div class="hp-muted">Each submission creates a separate record in this browser. Earlier entries remain available for review rather than being replaced by a new assessment.</div></div><a href="healthinfo.php" class="hp-btn">＋ New assessment</a></div><div class="hp-table-wrap"><table class="hp-table"><thead><tr><th>Date & time</th><th>Assessment</th><th>Astronaut ID</th><th>Recorded status</th><th>Details</th></tr></thead><tbody data-history><tr><td colspan="5">Loading history…</td></tr></tbody></table></div></div>
</div></main>
<?php include 'includes/footer.php' ?>
</html>