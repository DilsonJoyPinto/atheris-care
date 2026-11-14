<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Astronaut Profile | Atheris</title>
<?php include 'includes/header.php' ?>
<div class="inner-bnr"><img src="logo/atheriswhite.png" alt="Atheris logo"><div class="container"><h2>Astronaut Profile</h2></div></div>
<main class="health-app"><div class="container">
<?php include 'includes/health-nav.php' ?>
<div class="page-heading"><div><div class="eyebrow">Atheris · Astronaut health monitoring</div><h2>Astronaut Profile</h2><p>Use a fictional astronaut identifier and mission details for this public demonstration. Assessment records are associated with the identifier you enter.</p></div><a class="hp-btn" href="healthinfo.php">＋ Start Vital Scan</a></div>
<div id="profile-message" class="hp-notice" data-form-message style="display:none"></div><div class="hp-card"><div class="hp-profile-head"><div class="hp-avatar">A</div><div><h3 data-profile-name style="margin:0 0 4px">Astronaut profile</h3><div class="hp-muted">This is a shared public demo database. Enter fictional sample details only. Do not enter real names, dates of birth, medical histories, medications or other sensitive information.</div></div></div><form data-profile-form><div class="hp-form-grid"><div class="hp-field"><label>Fictional Astronaut ID</label><input name="astronaut_id" placeholder="SIM-AST-001" required></div><div class="hp-field"><label>Demo display name</label><input name="full_name" placeholder="Demo Astronaut"></div><div class="hp-field"><label>Mission ID / name</label><input name="mission_id" placeholder="SIM-MISSION-01"></div><div class="hp-field"><label>Mission day</label><input name="mission_day" type="number" min="0" placeholder="e.g. 30"></div></div><button class="hp-btn" type="submit">Save demo profile</button></form></div></div></main>
<?php include 'includes/footer.php' ?>
</html>