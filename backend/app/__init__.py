"""Atheris Care public demonstration API."""
from __future__ import annotations

import os
from pathlib import Path
from flask import Flask, jsonify
from flask_cors import CORS
from dotenv import load_dotenv

from .db import init_db
from .routes import api


def create_app(test_config: dict | None = None) -> Flask:
    load_dotenv()
    app = Flask(__name__)
    app.config.update(
        SECRET_KEY=os.getenv("ATHERIS_SECRET_KEY", "local-demo-only-change-before-deploy"),
        DATABASE=os.getenv("ATHERIS_DATABASE", "instance/atheris.sqlite3"),
        MAX_CONTENT_LENGTH=int(os.getenv("ATHERIS_MAX_CONTENT_LENGTH", "1048576")),
        JSON_SORT_KEYS=False,
    )
    if test_config:
        app.config.update(test_config)

    db_path = Path(app.config["DATABASE"])
    if not db_path.is_absolute():
        db_path = Path(app.root_path).parent / db_path
    db_path.parent.mkdir(parents=True, exist_ok=True)
    app.config["DATABASE"] = str(db_path)

    origins = os.getenv("ATHERIS_CORS_ORIGINS", "http://localhost:8000,http://127.0.0.1:8000")
    if origins.strip() == "*":
        CORS(app, resources={r"/api/*": {"origins": "*"}})
    else:
        CORS(app, resources={r"/api/*": {"origins": [x.strip() for x in origins.split(",") if x.strip()]}})

    init_db(app)
    app.register_blueprint(api, url_prefix="/api")

    @app.get("/")
    def root():
        return jsonify({"service": "Atheris Care API", "status": "online", "docs": "/api"})

    @app.get("/api")
    def api_index():
        return jsonify({
            "name": "Atheris Care API",
            "version": "1.0.0",
            "access": "public demonstration; no account required",
            "important": "Use fictional demonstration data only. This is not a medical device or diagnostic service.",
            "endpoints": [
                "GET /api/health", "GET|POST /api/astronauts", "GET|PUT /api/astronauts/<astronaut_id>",
                "GET|POST /api/assessments", "GET /api/assessments/<assessment_id>",
                "GET /api/dashboard", "GET /api/analytics?metric=heart_rate", "GET /api/alerts", "GET /api/reports"
            ]
        })

    @app.errorhandler(413)
    def too_large(_error):
        return jsonify({"error": "Request body is too large."}), 413

    @app.errorhandler(404)
    def not_found(_error):
        return jsonify({"error": "The requested API resource was not found."}), 404

    return app
