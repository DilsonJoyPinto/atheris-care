<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Medical Reports | Atheris</title>
<?php include 'includes/header.php' ?>
<div class="inner-bnr"><img src="logo/atheriswhite.png" alt="Atheris logo"><div class="container"><h2>Medical Reports</h2></div></div>
<main class="health-app"><div class="container">
<?php include 'includes/health-nav.php' ?>
<div class="page-heading"><div><div class="eyebrow">Atheris · Astronaut health monitoring</div><h2>Medical Reports</h2><p>Review and print summaries of the information entered in each Vital Scan. Reports are records of submitted observations, not independent medical assessments.</p></div><a class="hp-btn" href="healthinfo.php">＋ Start Vital Scan</a></div>
<div class="hp-toolbar"><div class="hp-muted">Reports are generated from assessment records saved in this browser. They include only information that was entered and saved.</div><button class="hp-btn secondary" onclick="window.print()">Print all reports</button></div><div data-reports><div class="hp-empty">No assessment reports are available. Submit a Vital Scan to create the first report.</div></div>
</div></main>
<?php include 'includes/footer.php' ?>
</html>