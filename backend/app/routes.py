from __future__ import annotations

import json
import re
import uuid
from datetime import datetime, timezone, timedelta
from flask import Blueprint, current_app, jsonify, request
from .db import get_db

api = Blueprint("api", __name__)
SYMPTOMS = {
    "chest_pain": "Chest pain reported",
    "shortness_breath": "Shortness of breath reported",
    "confusion": "Confusion reported",
    "vision_loss": "Vision concern reported",
    "severe_dizziness": "Severe dizziness reported",
    "breathing_difficulty": "Breathing difficulty reported",
}
UNITS = {
    "age": "years", "height_cm": "cm", "weight_kg": "kg", "heart_rate": "beats/min", "systolic_bp": "mmHg",
    "diastolic_bp": "mmHg", "spo2": "%", "temperature_c": "°C", "respiratory_rate": "breaths/min",
    "reaction_time_ms": "ms", "concentration_score": "score (0-10)", "neuro_coordination": "score (0-10)",
    "bone_density": "g/cm²", "t_score": "score", "z_score": "score", "calcium_mg": "mg/day",
    "vitamin_d": "ng/mL", "eye_pressure": "mmHg", "grip_strength": "kg", "fatigue_score": "score (1-10)",
    "exercise_minutes": "minutes/day", "exercise_sessions": "sessions/week", "stress_score": "score (1-10)",
    "anxiety_score": "score (1-10)", "loneliness_score": "score (1-10)", "motivation_score": "score (1-10)",
    "mental_fatigue": "score (1-10)", "peak_flow": "L/min", "fev1": "L", "fvc": "L", "glucose": "mg/dL",
    "calcium": "mg/dL", "vitamin_d_meta": "ng/mL", "hemoglobin": "g/dL", "water_ml": "mL/day",
    "calories_kcal": "kcal/day", "protein_g": "g/day", "appetite_score": "score (1-10)",
    "sleep_hours": "hours", "sleep_quality": "score (1-10)", "sleep_latency": "minutes",
    "sleep_awakenings": "count", "daytime_fatigue": "score (1-10)", "radiation_daily": "mSv/day",
    "radiation_cumulative": "mSv", "balance_coordination": "score (0-10)", "hand_eye_score": "score (0-10)",
    "orientation_score": "score (0-10)"
}
NUMERIC_KEYS = {
    "age", "height_cm", "weight_kg", "heart_rate", "systolic_bp", "diastolic_bp", "spo2", "temperature_c",
    "respiratory_rate", "reaction_time_ms", "concentration_score", "neuro_coordination", "bone_density", "t_score",
    "z_score", "calcium_mg", "vitamin_d", "eye_pressure", "grip_strength", "fatigue_score", "exercise_minutes",
    "exercise_sessions", "stress_score", "anxiety_score", "loneliness_score", "motivation_score", "mental_fatigue",
    "peak_flow", "fev1", "fvc", "glucose", "calcium", "vitamin_d_meta", "hemoglobin", "water_ml", "calories_kcal",
    "protein_g", "appetite_score", "sleep_hours", "sleep_quality", "sleep_latency", "sleep_awakenings", "daytime_fatigue",
    "radiation_daily", "radiation_cumulative", "balance_coordination", "hand_eye_score", "orientation_score"
}
MAX_TEXT = 2000


def now_iso():
    return datetime.now(timezone.utc).isoformat(timespec="seconds")


def json_body():
    if not request.is_json:
        return None, (jsonify({"error": "Send this request with Content-Type: application/json."}), 415)
    data = request.get_json(silent=True)
    if not isinstance(data, dict):
        return None, (jsonify({"error": "The request body must be a JSON object."}), 400)
    return data, None


def clean_text(value, field, limit=MAX_TEXT):
    if value is None:
        return ""
    if not isinstance(value, (str, int, float)):
        raise ValueError(f"{field} must be text.")
    result = str(value).strip()
    if len(result) > limit:
        raise ValueError(f"{field} must be {limit} characters or fewer.")
    return result


def clean_mission_day(value):
    if value in (None, ""):
        return None
    try:
        day = int(value)
    except (TypeError, ValueError):
        raise ValueError("mission_day must be a whole number.")
    if day < 0 or day > 100000:
        raise ValueError("mission_day must be between 0 and 100000.")
    return day


def ensure_astronaut(astronaut_id, mission_id="", mission_day=None):
    db = get_db()
    stamp = now_iso()
    db.execute("""INSERT INTO astronauts(astronaut_id, full_name, mission_id, mission_day, profile_json, created_at, updated_at)
                  VALUES(?, '', ?, ?, '{}', ?, ?) ON CONFLICT(astronaut_id) DO UPDATE SET
                  mission_id=CASE WHEN excluded.mission_id!='' THEN excluded.mission_id ELSE astronauts.mission_id END,
                  mission_day=COALESCE(excluded.mission_day, astronauts.mission_day), updated_at=excluded.updated_at""",
               (astronaut_id, mission_id, mission_day, stamp, stamp))


def assessment_dict(row):
    return {
        "id": row["id"], "astronautId": row["astronaut_id"], "missionId": row["mission_id"],
        "missionDay": row["mission_day"], "type": row["type"], "createdAt": row["created_at"],
        "recordedAt": row["recorded_at"], "source": row["source"], "dataMode": row["data_mode"],
        "missionPhase": row["mission_phase"], "qualityStatus": row["quality_status"], "notes": row["notes"],
        "measurements": json.loads(row["measurements_json"]),
        "metadata": json.loads(row["metadata_json"]),
    }


def seed_demo_data():
    if str(__import__("os").getenv("ATHERIS_SEED_DEMO_DATA", "true")).lower() not in ("1", "true", "yes"):
        return
    db = get_db()
    if db.execute("SELECT COUNT(*) FROM assessments").fetchone()[0]:
        return
    astronaut_id = "SIM-DEMO-01"
    stamp = now_iso()
    db.execute("INSERT OR IGNORE INTO astronauts VALUES(?, ?, ?, ?, ?, ?, ?)",
               (astronaut_id, "Fictional Demo Astronaut", "SIMULATED MISSION", 90,
                json.dumps({"demo": True, "notice": "Fictional sample profile; not a real person."}), stamp, stamp))
    samples = [
        (21, {"heart_rate":"72", "systolic_bp":"118", "diastolic_bp":"76", "spo2":"98", "sleep_hours":"7.2", "weight_kg":"74.1"}),
        (10, {"heart_rate":"75", "systolic_bp":"120", "diastolic_bp":"78", "spo2":"98", "sleep_hours":"6.8", "weight_kg":"74.0"}),
        (2, {"heart_rate":"73", "systolic_bp":"119", "diastolic_bp":"77", "spo2":"97", "sleep_hours":"7.0", "weight_kg":"73.9"}),
    ]
    for offset, measurements in samples:
        created = (datetime.now(timezone.utc) - timedelta(days=offset)).isoformat(timespec="seconds")
        record_id = f"SIM-DAY-{offset}"
        db.execute("""INSERT INTO assessments(id, astronaut_id, mission_id, mission_day, type, created_at, recorded_at,
                      source, data_mode, mission_phase, quality_status, notes, measurements_json, metadata_json)
                      VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)""",
                   (record_id, astronaut_id, "SIMULATED MISSION", 90-offset, "Simulated demonstration reading", created,
                    created, "seeded-simulation", "simulated", "in-flight", "illustrative-only",
                    "Fictional sample values generated for interface demonstration. Not real astronaut data, reference ranges or medical guidance.",
                    json.dumps(measurements), json.dumps({"simulation": True, "method": "illustrative synthetic values"})))
    db.commit()


@api.before_app_request
def ensure_seed():
    if request.path.startswith("/api/") and not current_app.config.get("TESTING"):
        # Idempotent; only inserts when the database has no assessment rows.
        seed_demo_data()


@api.get("/health")
def health():
    db = get_db()
    db.execute("SELECT 1").fetchone()
    return jsonify({"status": "ok", "database": "connected", "timestamp": now_iso(), "demo_mode": True})


@api.get("/astronauts")
def list_astronauts():
    rows = get_db().execute("SELECT * FROM astronauts ORDER BY astronaut_id").fetchall()
    return jsonify([{"astronaut_id": r["astronaut_id"], "full_name": r["full_name"], "mission_id": r["mission_id"],
                     "mission_day": r["mission_day"], "profile": json.loads(r["profile_json"])} for r in rows])


@api.post("/astronauts")
def save_astronaut():
    data, error = json_body()
    if error: return error
    try:
        astronaut_id = clean_text(data.get("astronaut_id"), "astronaut_id", 64)
        if not astronaut_id or not re.fullmatch(r"[A-Za-z0-9._-]+", astronaut_id):
            raise ValueError("astronaut_id is required and may contain letters, numbers, dots, underscores and hyphens.")
        full_name = clean_text(data.get("full_name"), "full_name", 120)
        mission_id = clean_text(data.get("mission_id"), "mission_id", 120)
        mission_day = clean_mission_day(data.get("mission_day"))
        profile = data.get("profile", {})
        if not isinstance(profile, dict): raise ValueError("profile must be an object.")
        stamp = now_iso(); db = get_db()
        db.execute("""INSERT INTO astronauts VALUES(?, ?, ?, ?, ?, ?, ?) ON CONFLICT(astronaut_id) DO UPDATE SET
                      full_name=excluded.full_name, mission_id=excluded.mission_id, mission_day=excluded.mission_day,
                      profile_json=excluded.profile_json, updated_at=excluded.updated_at""",
                   (astronaut_id, full_name, mission_id, mission_day, json.dumps(profile), stamp, stamp))
        db.commit()
        return jsonify({"message": "Demo profile saved.", "astronaut_id": astronaut_id}), 201
    except ValueError as exc:
        return jsonify({"error": str(exc)}), 400


@api.get("/astronauts/<astronaut_id>")
def get_astronaut(astronaut_id):
    row = get_db().execute("SELECT * FROM astronauts WHERE astronaut_id=?", (astronaut_id,)).fetchone()
    if not row: return jsonify({"error": "Astronaut record not found."}), 404
    return jsonify({"astronaut_id": row["astronaut_id"], "full_name": row["full_name"], "mission_id": row["mission_id"],
                    "mission_day": row["mission_day"], "profile": json.loads(row["profile_json"])})


@api.put("/astronauts/<astronaut_id>")
def update_astronaut(astronaut_id):
    data, error = json_body()
    if error: return error
    data["astronaut_id"] = astronaut_id
    try:
        full_name = clean_text(data.get("full_name"), "full_name", 120)
        mission_id = clean_text(data.get("mission_id"), "mission_id", 120)
        mission_day = clean_mission_day(data.get("mission_day"))
        profile = data.get("profile", {})
        if not isinstance(profile, dict): raise ValueError("profile must be an object.")
        stamp = now_iso(); db = get_db()
        db.execute("""INSERT INTO astronauts VALUES(?, ?, ?, ?, ?, ?, ?) ON CONFLICT(astronaut_id) DO UPDATE SET
                      full_name=excluded.full_name, mission_id=excluded.mission_id, mission_day=excluded.mission_day,
                      profile_json=excluded.profile_json, updated_at=excluded.updated_at""",
                   (astronaut_id, full_name, mission_id, mission_day, json.dumps(profile), stamp, stamp))
        db.commit()
        return jsonify({"message": "Demo profile updated.", "astronaut_id": astronaut_id})
    except ValueError as exc:
        return jsonify({"error": str(exc)}), 400


@api.post("/assessments")
def create_assessment():
    data, error = json_body()
    if error: return error
    try:
        astronaut_id = clean_text(data.get("astronautId", data.get("astronaut_id")), "astronautId", 64)
        if not astronaut_id or not re.fullmatch(r"[A-Za-z0-9._-]+", astronaut_id):
            raise ValueError("A valid astronautId is required.")
        mission_id = clean_text(data.get("missionId", data.get("mission_id")), "missionId", 120)
        mission_day = clean_mission_day(data.get("missionDay", data.get("mission_day")))
        assessment_type = clean_text(data.get("type", data.get("assessment_type", "Full Vital Scan")), "type", 80) or "Full Vital Scan"
        notes = clean_text(data.get("notes"), "notes", 4000)
        measurements = data.get("measurements")
        if not isinstance(measurements, dict): raise ValueError("measurements must be a JSON object.")
        if len(measurements) > 150: raise ValueError("Too many measurement fields were submitted.")
        clean_measurements = {}
        for key, value in measurements.items():
            if not isinstance(key, str) or not re.fullmatch(r"[a-zA-Z0-9_]{1,64}", key):
                raise ValueError("A measurement field name is invalid.")
            if value is None or value == "": continue
            if isinstance(value, (dict, list, bool)): raise ValueError(f"{key} must be a simple value.")
            text_value = clean_text(value, key, 500)
            if key in NUMERIC_KEYS:
                try: number = float(text_value)
                except ValueError: raise ValueError(f"{key} must be numeric.")
                if not (-1e9 < number < 1e9): raise ValueError(f"{key} is outside the supported numeric range.")
                clean_measurements[key] = text_value
            else:
                clean_measurements[key] = text_value
        metadata = data.get("metadata", {})
        if not isinstance(metadata, dict): raise ValueError("metadata must be an object.")
        metadata = dict(metadata)
        metadata.setdefault("measurementUnits", {key: UNITS[key] for key in clean_measurements if key in UNITS})
        metadata_json = json.dumps(metadata, ensure_ascii=False)
        if len(metadata_json) > 20000: raise ValueError("metadata is too large.")
        mission_phase = clean_text(data.get("missionPhase", "unspecified"), "missionPhase", 40) or "unspecified"
        quality_status = clean_text(data.get("qualityStatus", "not-assessed"), "qualityStatus", 40) or "not-assessed"
        record_id = "AV-" + uuid.uuid4().hex[:12].upper()
        stamp = now_iso(); db = get_db()
        ensure_astronaut(astronaut_id, mission_id, mission_day)
        db.execute("""INSERT INTO assessments(id, astronaut_id, mission_id, mission_day, type, created_at, recorded_at,
                      source, data_mode, mission_phase, quality_status, notes, measurements_json, metadata_json)
                      VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)""",
                   (record_id, astronaut_id, mission_id, mission_day, assessment_type, stamp, stamp,
                    clean_text(data.get("source", "manual-entry"), "source", 40), "public-demo", mission_phase,
                    quality_status, notes, json.dumps(clean_measurements, ensure_ascii=False), metadata_json))
        for key, title in SYMPTOMS.items():
            if clean_measurements.get(key, "").lower() == "yes":
                db.execute("INSERT INTO alerts(assessment_id, astronaut_id, alert_key, title, detail, level, created_at) VALUES(?,?,?,?,?,?,?)",
                           (record_id, astronaut_id, key, title,
                            "A symptom was self-reported in this demonstration record. Review with qualified medical personnel; this alert is not a diagnosis.",
                            "attention", stamp))
        db.commit()
        row = db.execute("SELECT * FROM assessments WHERE id=?", (record_id,)).fetchone()
        return jsonify({"message": "Assessment saved as a new historical record.", "assessment": assessment_dict(row)}), 201
    except ValueError as exc:
        return jsonify({"error": str(exc)}), 400


@api.get("/assessments")
def list_assessments():
    query = "SELECT * FROM assessments WHERE 1=1"; params = []
    astronaut_id = request.args.get("astronaut_id")
    if astronaut_id:
        query += " AND astronaut_id=?"; params.append(astronaut_id)
    limit = request.args.get("limit", "200")
    try: limit = max(1, min(500, int(limit)))
    except ValueError: return jsonify({"error": "limit must be an integer from 1 to 500."}), 400
    query += " ORDER BY created_at DESC LIMIT ?"; params.append(limit)
    rows = get_db().execute(query, params).fetchall()
    return jsonify([assessment_dict(r) for r in rows])


@api.get("/assessments/<assessment_id>")
def get_assessment(assessment_id):
    row = get_db().execute("SELECT * FROM assessments WHERE id=?", (assessment_id,)).fetchone()
    if not row: return jsonify({"error": "Assessment not found."}), 404
    return jsonify(assessment_dict(row))


@api.get("/dashboard")
def dashboard():
    db = get_db(); astronaut_id = request.args.get("astronaut_id")
    where = " WHERE astronaut_id=?" if astronaut_id else ""
    params = [astronaut_id] if astronaut_id else []
    row = db.execute("SELECT * FROM assessments" + where + " ORDER BY created_at DESC LIMIT 1", params).fetchone()
    total = db.execute("SELECT COUNT(*) FROM assessments" + where, params).fetchone()[0]
    alert_count = db.execute("SELECT COUNT(*) FROM alerts" + (" WHERE astronaut_id=?" if astronaut_id else ""), params).fetchone()[0]
    return jsonify({"latest": assessment_dict(row) if row else None, "assessment_count": total,
                    "alert_count": alert_count, "demo_mode": True,
                    "notice": "Public demonstration records may be visible to other visitors. Use fictional data only."})


@api.get("/alerts")
def list_alerts():
    astronaut_id = request.args.get("astronaut_id")
    sql = "SELECT * FROM alerts"; params = []
    if astronaut_id: sql += " WHERE astronaut_id=?"; params.append(astronaut_id)
    sql += " ORDER BY created_at DESC LIMIT 500"
    rows = get_db().execute(sql, params).fetchall()
    return jsonify([{"id": r["id"], "assessmentId": r["assessment_id"], "astronautId": r["astronaut_id"],
                     "key": r["alert_key"], "title": r["title"], "detail": r["detail"],
                     "level": r["level"], "date": r["created_at"]} for r in rows])


@api.get("/analytics")
def analytics():
    metric = request.args.get("metric", "heart_rate")
    if not re.fullmatch(r"[a-zA-Z0-9_]{1,64}", metric): return jsonify({"error": "Invalid metric name."}), 400
    astronaut_id = request.args.get("astronaut_id")
    sql = "SELECT * FROM assessments"; params = []
    if astronaut_id: sql += " WHERE astronaut_id=?"; params.append(astronaut_id)
    sql += " ORDER BY created_at ASC"
    records = [assessment_dict(r) for r in get_db().execute(sql, params).fetchall()]
    points = []
    for record in records:
        value = record["measurements"].get(metric)
        if value in (None, ""): continue
        try: numeric = float(value)
        except (TypeError, ValueError): continue
        points.append({"assessmentId": record["id"], "date": record["createdAt"], "value": numeric,
                       "unit": "", "dataMode": record["dataMode"], "method": record["metadata"].get("method")})
    return jsonify({"metric": metric, "points": points, "count": len(points),
                    "comparison_note": "Only compare measurements collected with compatible methods, units, sites and quality. Missing data is not a normal result."})


@api.get("/reports")
def reports():
    # Report payloads are structured JSON for the frontend to render or export.
    rows = get_db().execute("SELECT * FROM assessments ORDER BY created_at DESC LIMIT 500").fetchall()
    return jsonify({"generatedAt": now_iso(), "demoMode": True, "records": [assessment_dict(r) for r in rows]})
