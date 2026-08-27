#!/bin/bash
# Import database from TMD server during deployment
# Only runs if users table is empty or has < 100 rows

DB_HOST="${DB_HOST:-127.0.0.1}"
DB_PORT="${DB_PORT:-3306}"
DB_DATABASE="${DB_DATABASE:-forge}"
DB_USERNAME="${DB_USERNAME:-forge}"
DB_PASSWORD="${DB_PASSWORD:-}"

# Check if users table has data
USER_COUNT=$(mysql -h "$DB_HOST" -P "$DB_PORT" -u "$DB_USERNAME" -p"$DB_PASSWORD" "$DB_DATABASE" -e "SELECT COUNT(*) FROM users" -s -N 2>/dev/null)

if [ "$USER_COUNT" -lt 100 ] 2>/dev/null; then
    echo "Importing database from TMD ($USER_COUNT users found)..."
    
    # Download dump
    curl -sL https://fansfollow.me/ffm-dump.sql -o /tmp/ffm-dump.sql
    
    # Import (skip existing tables, handle errors gracefully)
    mysql -h "$DB_HOST" -P "$DB_PORT" -u "$DB_USERNAME" -p"$DB_PASSWORD" "$DB_DATABASE" < /tmp/ffm-dump.sql 2>&1 | tail -5
    
    rm -f /tmp/ffm-dump.sql
    
    # Verify
    NEW_COUNT=$(mysql -h "$DB_HOST" -P "$DB_PORT" -u "$DB_USERNAME" -p"$DB_PASSWORD" "$DB_DATABASE" -e "SELECT COUNT(*) FROM users" -s -N 2>/dev/null)
    echo "Import complete. Users: $NEW_COUNT"
else
    echo "Database already has $USER_COUNT users, skipping import"
fi
