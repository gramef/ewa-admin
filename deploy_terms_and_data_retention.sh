#!/bin/bash
# ============================================================
# EWA — Vendor Terms & Data Retention/Deletion Deployment
# Run this in the Bluehost cPanel Terminal:
# bash deploy_terms_and_data_retention.sh
# ============================================================

cd ~/public_html

echo "=== Pulling Latest Changes from GitHub ==="
git fetch origin main || git fetch github main
git reset --hard origin/main || git reset --hard github/main

echo "=== Syncing Custom Pages in Database ==="
php update_custom_pages.php

echo "=== Clearing Laravel Caches ==="
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

echo "============================================"
echo "  ✅ Terms, Vendor Terms, & Data Retention"
echo "     successfully deployed to Bluehost!"
echo "============================================"
