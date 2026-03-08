#!/usr/bin/env bash
set -e

# =============================================================================
# Relaticle — Production Deploy Script
# =============================================================================
# Usage: bash deploy.sh
# Requires: Docker with Compose v2, a configured .env file.
#
# On first deploy:
#   cp .env.production.example .env
#   # Fill in all <CHANGE_ME> values, then run:
#   bash deploy.sh
# =============================================================================

COMPOSE_FILE="compose.prod.yml"
ENV_FILE=".env"
HEALTH_URL=""
MAX_WAIT=120

# -----------------------------------------------------------------------------
# 1. Check .env exists
# -----------------------------------------------------------------------------
if [ ! -f "$ENV_FILE" ]; then
    echo ""
    echo "ERROR: $ENV_FILE not found."
    echo ""
    echo "To get started:"
    echo "  cp .env.production.example .env"
    echo "  # Edit .env and fill in all <CHANGE_ME> values, then re-run:"
    echo "  bash deploy.sh"
    echo ""
    exit 1
fi

# Source the env file to read APP_URL for the health check
set -a
# shellcheck disable=SC1090
source "$ENV_FILE"
set +a

APP_URL="${APP_URL:-http://localhost}"
HEALTH_URL="${APP_URL%/}/up"

echo ""
echo "============================================================"
echo "  Relaticle Production Deployment"
echo "============================================================"
echo "  Compose file : $COMPOSE_FILE"
echo "  Env file     : $ENV_FILE"
echo "  App URL      : $APP_URL"
echo "============================================================"
echo ""

# -----------------------------------------------------------------------------
# 2. Bring down the existing stack (remove orphaned containers)
# -----------------------------------------------------------------------------
echo "[1/4] Stopping existing containers..."
docker compose -f "$COMPOSE_FILE" --env-file "$ENV_FILE" down --remove-orphans

# -----------------------------------------------------------------------------
# 3. Start the new stack
# -----------------------------------------------------------------------------
echo "[2/4] Starting containers..."
docker compose -f "$COMPOSE_FILE" --env-file "$ENV_FILE" up -d --build

# -----------------------------------------------------------------------------
# 4. Wait for app health check (polls /up endpoint, max 120 s)
# -----------------------------------------------------------------------------
echo "[3/4] Waiting for application to become healthy (max ${MAX_WAIT}s)..."
elapsed=0
until curl -sf "$HEALTH_URL" > /dev/null 2>&1; do
    if [ "$elapsed" -ge "$MAX_WAIT" ]; then
        echo ""
        echo "ERROR: Application did not become healthy within ${MAX_WAIT}s."
        echo "Check the logs with:  docker compose -f $COMPOSE_FILE logs app"
        exit 1
    fi
    printf "."
    sleep 3
    elapsed=$((elapsed + 3))
done
echo ""
echo "Application is healthy."

# -----------------------------------------------------------------------------
# 5. Print summary
# -----------------------------------------------------------------------------
ADMIN_EMAIL="${ADMIN_EMAIL:-admin@relaticle.local}"

echo ""
echo "============================================================"
echo "  Deployment complete!"
echo "============================================================"
echo "  URL          : $APP_URL"
echo "  CRM panel    : ${APP_URL%/}/app"
echo ""
echo "  First-login credentials (set in .env):"
echo "    Email    : $ADMIN_EMAIL"
echo "    Password : (value of ADMIN_PASSWORD in .env)"
echo ""
echo "  NOTE: Credentials only apply on first boot (no users in DB)."
echo "        Change your password after first login."
echo "============================================================"
echo ""
