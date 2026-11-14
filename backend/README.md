# Atheris Care — Flask API

A public, no-login demonstration backend for the Atheris Care astronaut health-monitoring prototype.

## Important public-demo rules

- The website and API intentionally do not require a password, account or registration.
- Records are stored in one shared SQLite database. Visitors may be able to view records entered by other visitors.
- Use fictional sample data only. Never enter real astronaut, patient or personal medical information.
- The seeded astronaut and readings are explicitly simulated examples, not real astronaut data, normal ranges or clinical thresholds.
- This prototype organises observations; it does not diagnose, predict disease, prescribe treatment or replace mission medical staff.

## Local setup (Windows)

1. Install Python 3.10+ and PHP 8+; make sure `py` and `php` work in Command Prompt.
2. Open Command Prompt in this `backend` folder.
3. Run `run_windows.bat`. It creates a virtual environment, installs dependencies and starts Flask on `http://127.0.0.1:5000`.
4. Keep that window open.
5. Open a second Command Prompt in the sibling `atheris` folder (the PHP website folder).
6. Run `php -S 127.0.0.1:8000`.
7. Open `http://127.0.0.1:8000/index.php`.

The API health check is `http://127.0.0.1:5000/api/health`. The API overview is `http://127.0.0.1:5000/api`.

## Manual setup

```bash
python -m venv .venv
# Windows: .venv\\Scripts\\activate
# macOS/Linux: source .venv/bin/activate
pip install -r requirements.txt
# Windows: copy .env.example .env
# macOS/Linux: cp .env.example .env
python run.py
```

## Frontend API URL

`../atheris/js/atheris-api-config.js` contains the API base URL. Local default:

```js
window.ATHERIS_API_BASE = 'http://127.0.0.1:5000/api';
```

When deploying, replace it with your deployed HTTPS API URL. Also set `ATHERIS_CORS_ORIGINS` in the backend `.env` to the exact public frontend origin(s), separated by commas. Do not use `*` for a production deployment.

## Database

SQLite is created automatically at `backend/instance/atheris.sqlite3`. It uses foreign keys, WAL journaling, a busy timeout and indexed astronaut/date lookups. Back up the database file before moving or updating a deployment.

Tables:

- `astronauts`: fictional demo identity and mission context.
- `assessments`: append-only dated assessment records; each submission gets a new ID.
- `alerts`: symptom-report review flags linked to the source assessment.

Measurements are stored as submitted values with metadata kept separately. The schema retains mission phase, source, quality status, method/device/site context and notes. Unmeasured fields are omitted, not converted to zero or labelled normal.

## API endpoints

| Method | Endpoint | Purpose |
|---|---|---|
| GET | `/api/health` | API and database status |
| GET | `/api/astronauts` | List demo astronaut profiles |
| POST | `/api/astronauts` | Create/update a demo profile |
| GET | `/api/astronauts/{id}` | Read one profile |
| PUT | `/api/astronauts/{id}` | Update one profile |
| GET | `/api/assessments` | List assessments; optional `?astronaut_id=...&limit=200` |
| POST | `/api/assessments` | Save a new assessment |
| GET | `/api/assessments/{id}` | Read one assessment |
| GET | `/api/dashboard` | Latest assessment and counts |
| GET | `/api/analytics?metric=heart_rate` | Longitudinal values for a metric |
| GET | `/api/alerts` | Symptom-report review flags |
| GET | `/api/reports` | Structured report data |

All write endpoints accept JSON. There is no authentication by design for the public judging demo; therefore this backend must contain demonstration data only.

## Research and interpretation safeguards

- SANS is represented as a research-monitoring topic, not a software diagnosis. OCT, fundus photography, visual fields, ultrasound and MRI are external examinations; the website does not perform them.
- Compare compatible measurement parameters, units, eye side/site, methods, devices and quality only. A numeric difference alone is not a diagnosis.
- Bone density fields are report-entry fields. This website does not measure BMD. DXA, QCT and HR-pQCT are different methods and should not be treated as interchangeable.
- Wearables and activity values are contextual observations, not direct bone-density measurements.
- Missing, unmeasured or poor-quality data are not normal findings.
- Alerts are generated only for selected self-reported symptoms. They request review and do not assert a clinical threshold.
- Do not infer an individual fracture probability, SANS diagnosis or treatment plan from this prototype.

## Tests

From this folder, with dependencies installed:

```bash
python -m unittest discover -s tests -v
```

## Deployment notes

The included `serve.py` uses Waitress. Use a managed host with HTTPS, a persistent disk/managed database, backups, monitoring and request-rate limits. Set a unique secret, restrict CORS to the exact website origin, and ensure the hosting platform's persistent storage is mounted. The local SQLite configuration is intended for a compact demonstration, not a multi-instance production medical system. The public demo is not suitable for real patient or astronaut health information.
