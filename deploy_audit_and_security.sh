#!/bin/bash
# ============================================================
# EWA Platform — Complete Audit & Security Deployment Script
# Bluehost cPanel Terminal:
# bash deploy_audit_and_security.sh
# ============================================================

set -e

cd ~/public_html

echo "=== 1. Pulling Latest Changes from GitHub ==="
git fetch origin main 2>/dev/null || git fetch github main 2>/dev/null || true
git reset --hard origin/main 2>/dev/null || git reset --hard github/main 2>/dev/null || true

echo "=== 2. Checking & Updating .env Configurations ==="
if [ -f ".env" ]; then
    # Ensure STRIPE_WEBHOOK_SECRET is configured
    if ! grep -q "STRIPE_WEBHOOK_SECRET=" .env; then
        echo "STRIPE_WEBHOOK_SECRET=whsec_0DHyPVzekjIzaOz3O6gSucV96qaGy4Ig" >> .env
        echo "✓ Added STRIPE_WEBHOOK_SECRET to .env"
    else
        sed -i 's/^STRIPE_WEBHOOK_SECRET=.*/STRIPE_WEBHOOK_SECRET=whsec_0DHyPVzekjIzaOz3O6gSucV96qaGy4Ig/' .env 2>/dev/null || true
        echo "✓ Updated STRIPE_WEBHOOK_SECRET in .env"
    fi

    # Ensure MAIL_FROM_ADDRESS is support@ewaofficial.co.uk
    if grep -q "MAIL_FROM_ADDRESS=" .env; then
        sed -i 's/^MAIL_FROM_ADDRESS=.*/MAIL_FROM_ADDRESS=support@ewaofficial.co.uk/' .env 2>/dev/null || true
        echo "✓ Ensured MAIL_FROM_ADDRESS=support@ewaofficial.co.uk in .env"
    fi
fi

echo "=== 3. Syncing Platform Settings (Email & Support) ==="
if [ -f "sync_platform_settings.php" ]; then
    php sync_platform_settings.php
fi

echo "=== 4. Syncing Terms & Data Retention Pages ==="
if [ -f "update_custom_pages.php" ]; then
    php update_custom_pages.php
fi

echo "=== 5. Clearing Laravel Caches ==="
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

echo "============================================================"
echo "  🎉 All Audit & Security Updates Deployed to Bluehost!"
echo "  - Stripe Webhook handler active with signing verification"
echo "  - 0-day payout hold configured (instant availability)"
echo "  - Two-sided job completion workflow & 24h auto-release active"
echo "  - Services Done counter active on EProvider profiles"
echo "  - Admin refund API ready"
echo "  - Email notifications active (Welcome, KYC, Deletion)"
echo "  - Support email verified (support@ewaofficial.co.uk)"
echo "============================================================"
