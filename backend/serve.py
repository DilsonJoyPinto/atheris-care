"""Production WSGI entry point for managed hosts such as Railway."""
import os
from waitress import serve
from app import create_app

app = create_app()

if __name__ == "__main__":
    # Railway and similar hosts inject PORT. Local fallback is 5000.
    port = int(os.environ.get("PORT", "5000"))
    serve(app, host="0.0.0.0", port=port, threads=4)
