<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Astrovitals | Atheris</title>
<?php include 'includes/header.php' ?>
<div class="inner-bnr"><img src="logo/atheriswhite.png" alt="Atheris logo"><div class="container"><h2>Astrovitals</h2></div></div>
<main class="health-app"><div class="container">
<?php include 'includes/health-nav.php' ?>
<div class="page-heading"><div><div class="eyebrow">Atheris · Astronaut health monitoring</div><h2>Astrovitals</h2><p>Enter the astronaut and mission identifiers so that later observations can be associated with the correct mission record.</p></div><a class="hp-btn" href="healthinfo.php">＋ Start Vital Scan</a></div>
<div class="hp-card"><div class="eyebrow">Mission identification</div><h3>Welcome, astronaut</h3><p class="hp-muted">Use fictional demonstration details only. Add the mission identifier, then open the dashboard or continue to a Vital Scan. No account or registration is required.</p><form data-profile-form><div class="hp-form-grid"><div class="hp-field"><label>Astronaut ID</label><input name="astronaut_id" placeholder="AST-001" required></div><div class="hp-field"><label>Full name</label><input name="full_name" placeholder="Enter your name"></div><div class="hp-field"><label>Mission name</label><input name="mission_id" placeholder="Enter mission name" required></div><div class="hp-field"><label>Mission day</label><input name="mission_day" type="number" min="0" placeholder="Mission day" required></div></div><button class="hp-btn" type="submit">Save and continue →</button> <a href="dashboard.php" class="hp-btn secondary">Open dashboard</a></form><div data-form-message class="hp-notice" style="display:none;margin-top:14px"></div></div>
</div></main>
<?php include 'includes/footer.php' ?>
</html>