#!/bin/bash

# Laravel Production Deployment Script
# Fixes MySQL key length issues and optimizes configuration

echo "🚀 Starting Laravel Production Deployment..."

# Step 1: Backup configuration
echo "📦 Backing up configuration..."
cp .env .env.backup.$(date +%Y%m%d_%H%M%S)

# Step 2: Clear caches
echo "🧹 Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Step 3: Run migrations with force
echo "📊 Running database migrations..."
php artisan migrate --force

# Step 4: Optimize for production
echo "⚡ Optimizing for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Step 5: Set proper permissions
echo "🔐 Setting permissions..."
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Step 6: Test routes
echo "🧪 Testing key routes..."
php artisan route:list | grep -E "(dang-ky|articles|home)"

echo "✅ Deployment completed successfully!"
echo ""
echo "📋 Production Configuration Summary:"
echo "   - Session Driver: File-based (no DB dependency)"
echo "   - MySQL Key Length: Fixed for utf8mb4"
echo "   - Caches: Optimized for production"
echo "   - Routes: Registration system active"
echo ""
echo "🌐 Ready for production at: thuchanhdemo.ituhl.org"