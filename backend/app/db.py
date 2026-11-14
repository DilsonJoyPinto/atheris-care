from __future__ import annotations
import sqlite3
from flask import current_app, g

SCHEMA = """
PRAGMA foreign_keys = ON;
CREATE TABLE IF NOT EXISTS astronauts (
  astronaut_id TEXT PRIMARY KEY,
  full_name TEXT NOT NULL DEFAULT '',
  mission_id TEXT NOT NULL DEFAULT '',
  mission_day INTEGER,
  profile_json TEXT NOT NULL DEFAULT '{}',
  created_at TEXT NOT NULL,
  updated_at TEXT NOT NULL
);
CREATE TABLE IF NOT EXISTS assessments (
  id TEXT PRIMARY KEY,
  astronaut_id TEXT NOT NULL,
  mission_id TEXT NOT NULL DEFAULT '',
  mission_day INTEGER,
  type TEXT NOT NULL DEFAULT 'Full Vital Scan',
  created_at TEXT NOT NULL,
  recorded_at TEXT NOT NULL,
  source TEXT NOT NULL DEFAULT 'manual-entry',
  data_mode TEXT NOT NULL DEFAULT 'public-demo',
  mission_phase TEXT NOT NULL DEFAULT 'unspecified',
  quality_status TEXT NOT NULL DEFAULT 'not-assessed',
  notes TEXT NOT NULL DEFAULT '',
  measurements_json TEXT NOT NULL,
  metadata_json TEXT NOT NULL DEFAULT '{}',
  FOREIGN KEY (astronaut_id) REFERENCES astronauts(astronaut_id)
);
CREATE INDEX IF NOT EXISTS idx_assessments_astronaut_date ON assessments(astronaut_id, created_at DESC);
CREATE TABLE IF NOT EXISTS alerts (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  assessment_id TEXT NOT NULL,
  astronaut_id TEXT NOT NULL,
  alert_key TEXT NOT NULL,
  title TEXT NOT NULL,
  detail TEXT NOT NULL,
  level TEXT NOT NULL DEFAULT 'attention',
  created_at TEXT NOT NULL,
  FOREIGN KEY (assessment_id) REFERENCES assessments(id) ON DELETE CASCADE,
  FOREIGN KEY (astronaut_id) REFERENCES astronauts(astronaut_id)
);
CREATE INDEX IF NOT EXISTS idx_alerts_date ON alerts(created_at DESC);
"""


def get_db():
    if "db" not in g:
        g.db = sqlite3.connect(current_app.config["DATABASE"], timeout=15)
        g.db.row_factory = sqlite3.Row
        g.db.execute("PRAGMA foreign_keys = ON")
        g.db.execute("PRAGMA busy_timeout = 15000")
    return g.db


def close_db(_error=None):
    db = g.pop("db", None)
    if db is not None:
        db.close()


def init_db(app):
    with app.app_context():
        db = sqlite3.connect(app.config["DATABASE"])
        db.execute("PRAGMA journal_mode = WAL")
        db.executescript(SCHEMA)
        db.commit()
        db.close()
    app.teardown_appcontext(close_db)
