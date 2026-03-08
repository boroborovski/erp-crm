#!/usr/bin/env bash
set -e

ENV_FILE=".env.docker"

# First-time setup: generate secrets
if [ ! -f "$ENV_FILE" ]; then
    echo "First run — generating secrets..."
    APP_KEY="base64:$(openssl rand -base64 32)"
    DB_PASSWORD=$(openssl rand -hex 16)

    cat > "$ENV_FILE" <<EOF
APP_KEY=$APP_KEY
DB_PASSWORD=$DB_PASSWORD
EOF

    echo "Secrets saved to $ENV_FILE"
fi

echo ""
echo "Building and starting Relaticle..."
echo ""

docker compose -f compose.yml --env-file "$ENV_FILE" up --build -d

echo ""
echo "Relaticle is starting up (migrations + setup run automatically)."
echo ""
echo "  App:       http://localhost"
echo "  CRM Panel: http://localhost/app"
echo "  Sysadmin:  http://localhost/sysadmin"
echo ""
echo "Default credentials (first boot only):"
echo "  CRM user:  admin@relaticle.local  /  password"
echo "  Sysadmin:  sysadmin@relaticle.local  /  password"
echo ""
echo "Watch logs:  docker compose -f compose.yml logs -f app"
echo "Stop:        docker compose -f compose.yml down"
echo ""
