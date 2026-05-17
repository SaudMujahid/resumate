#!/usr/bin/env bash
set -e

DB_NAME="resumate"

echo "▶ Starting MariaDB service..."
sudo systemctl start mariadb

echo "▶ Waiting for MariaDB to be ready..."
until mysqladmin ping --silent; do
  sleep 1
done

echo "▶ Ensuring database '$DB_NAME' exists..."
sudo mysql <<EOF
CREATE DATABASE IF NOT EXISTS \`$DB_NAME\`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
EOF

echo "✅ MariaDB running and database '$DB_NAME' ready."

