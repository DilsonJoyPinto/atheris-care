# Atheris Care — Full project package

This folder contains the existing PHP website and the new Flask + SQLite backend.

## Start the project on Windows

**Terminal 1 — backend**

1. Open this `backend` folder in File Explorer.
2. Click the address bar, type `cmd`, and press Enter.
3. Run `run_windows.bat` and keep the window open.

**Terminal 2 — website**

1. Open the `atheris` folder.
2. Click the address bar, type `cmd`, and press Enter.
3. Run:

```bat
php -S 127.0.0.1:8000
```

4. Open `http://127.0.0.1:8000/index.php` in your browser.

Check the API at `http://127.0.0.1:5000/api/health`.

## Public NASA judging link

The project pages and API require no login, password or registration. To publish the project, host the PHP frontend and Flask API on publicly reachable HTTPS services, configure `atheris/js/atheris-api-config.js` with the public API URL, and set `ATHERIS_CORS_ORIGINS` to the public frontend origin. A local `localhost` address is not a public submission link.

## Critical data warning

This is a shared public demonstration system. Use fictional sample data only. Do not enter real astronaut, patient or personal health information. The seeded readings are synthetic examples and are visibly labelled simulated. The project is a prototype, not a validated diagnostic or treatment system.

See `backend/README.md` for API details, schema, deployment notes and tests.
