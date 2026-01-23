# 🚀 Production Deployment Checklist

## Pre-Deployment Verification

### Code Quality
- [ ] All code committed to git
- [ ] No debug statements left
- [ ] No hardcoded credentials
- [ ] Code review completed
- [ ] Tests passed
- [ ] Linting passed (if configured)

### Security Audit
- [ ] HTTPS enabled/configured
- [ ] CSRF tokens active
- [ ] SQL injection prevention verified
- [ ] XSS protection enabled
- [ ] Password hashing working
- [ ] Authentication secure
- [ ] Authorization rules tested
- [ ] No sensitive data in logs
- [ ] Rate limiting configured
- [ ] Input validation complete

### Performance Check
- [ ] Database indexes created
- [ ] Query optimization done
- [ ] Caching configured
- [ ] Assets minified
- [ ] Images optimized
- [ ] Database cleanup (no test data)
- [ ] Load testing completed

### Environmental Setup
- [ ] Production server provisioned
- [ ] PHP 8.2+ installed
- [ ] MySQL 5.7+ installed
- [ ] Composer available
- [ ] Node.js available
- [ ] SSL certificate installed
- [ ] Domain configured
- [ ] Email service configured

---

## .env Configuration for Production

```env
# Application
APP_NAME="Billiard Management System"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Locale
APP_LOCALE=id
APP_FALLBACK_LOCALE=en

# Database
DB_CONNECTION=mysql
DB_HOST=your-production-db-host
DB_PORT=3306
DB_DATABASE=billiard_system_prod
DB_USERNAME=db_user
DB_PASSWORD=strong_password_here

# Session
SESSION_DRIVER=database
SESSION_LIFETIME=120

# Mail
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="Billiard Management"

# Cache
CACHE_DRIVER=redis
CACHE_TTL=3600

# Queue (if using)
QUEUE_CONNECTION=database

# Redis (if using)
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# Logging
LOG_CHANNEL=stack
LOG_LEVEL=error

# App Key (already generated)
APP_KEY=base64:your_key_here
```

---

## Server Setup Steps

### 1. Create Production Database
```sql
CREATE DATABASE billiard_system_prod 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

CREATE USER 'billiard_user'@'localhost' 
IDENTIFIED BY 'strong_password';

GRANT ALL PRIVILEGES ON billiard_system_prod.* 
TO 'billiard_user'@'localhost';

FLUSH PRIVILEGES;
```

### 2. Deploy Code
```bash
# Clone repository
git clone [your-repo-url] /var/www/billiard-system
cd /var/www/billiard-system

# Set permissions
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/

# Install dependencies (production)
composer install --no-dev --optimize-autoloader
npm install --production
npm run build
```

### 3. Configure Application
```bash
# Copy and edit .env
cp .env.example .env
nano .env  # Edit with production values

# Generate key if not done
php artisan key:generate

# Generate app certs (for encryption)
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 4. Setup Database
```bash
# Run migrations
php artisan migrate --force

# Run seeders (if needed)
php artisan db:seed
```

### 5. Configure Web Server

#### Nginx Configuration Example
```nginx
server {
    listen 443 ssl http2;
    server_name yourdomain.com;

    ssl_certificate /path/to/ssl.crt;
    ssl_certificate_key /path/to/ssl.key;

    root /var/www/billiard-system/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }

    # Compression
    gzip on;
    gzip_types text/plain text/css text/javascript application/json;

    # Security headers
    add_header Strict-Transport-Security "max-age=31536000" always;
    add_header X-Frame-Options "DENY" always;
    add_header X-Content-Type-Options "nosniff" always;
}

# Redirect HTTP to HTTPS
server {
    listen 80;
    server_name yourdomain.com;
    return 301 https://$server_name$request_uri;
}
```

#### Apache Configuration Example
```apache
<VirtualHost *:443>
    ServerName yourdomain.com
    DocumentRoot /var/www/billiard-system/public

    <Directory /var/www/billiard-system/public>
        AllowOverride All
        Require all granted
        RewriteEngine On
        RewriteBase /
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteRule ^ index.php [QSA,L]
    </Directory>

    SSLEngine on
    SSLCertificateFile /path/to/ssl.crt
    SSLCertificateKeyFile /path/to/ssl.key

    <IfModule mod_headers.c>
        Header always set Strict-Transport-Security "max-age=31536000"
        Header always set X-Frame-Options "DENY"
        Header always set X-Content-Type-Options "nosniff"
    </IfModule>
</VirtualHost>

<VirtualHost *:80>
    ServerName yourdomain.com
    Redirect permanent / https://yourdomain.com/
</VirtualHost>
```

### 6. Setup Cron Jobs
```bash
# Edit crontab
crontab -e

# Add Laravel schedule runner
* * * * * cd /var/www/billiard-system && php artisan schedule:run >> /dev/null 2>&1
```

### 7. Setup Monitoring & Logging
```bash
# Create log directory
mkdir -p /var/log/billiard-system
chown www-data:www-data /var/log/billiard-system

# Monitor logs
tail -f /var/www/billiard-system/storage/logs/laravel.log
```

---

## Post-Deployment Checklist

### Verification
- [ ] Website loads without errors
- [ ] HTTPS working correctly
- [ ] Database connections working
- [ ] Login functionality working
- [ ] Booking creation working
- [ ] Payment processing working
- [ ] Emails sending (if configured)
- [ ] Error logging working
- [ ] File uploads working (if applicable)
- [ ] Caching working

### Performance Check
- [ ] Page load times acceptable
- [ ] Database queries optimized
- [ ] No N+1 query problems
- [ ] Images optimized
- [ ] Static assets cached
- [ ] CSS/JS minified
- [ ] No console errors

### Security Check
- [ ] SSL certificate valid
- [ ] HSTS headers present
- [ ] X-Frame-Options set
- [ ] X-Content-Type-Options set
- [ ] CSRF protection active
- [ ] Input validation working
- [ ] Session timeout working
- [ ] Password reset working
- [ ] No sensitive data exposed

### User Testing
- [ ] Can register new user
- [ ] Can login successfully
- [ ] Can create booking
- [ ] Can process payment
- [ ] Can view booking history
- [ ] Can cancel booking
- [ ] Can print receipt
- [ ] Can update profile (if implemented)
- [ ] Mobile responsive working
- [ ] Navigation working on all pages

---

## Backup & Recovery

### Database Backup
```bash
# Daily backup
mysqldump -u root -p billiard_system_prod > backup_$(date +%Y%m%d).sql

# Or use automated service
0 2 * * * mysqldump -u root -p billiard_system_prod | gzip > /backups/billiard_$(date +\%Y\%m\%d).sql.gz
```

### File Backup
```bash
# Backup application
tar -czf billiard-app-$(date +%Y%m%d).tar.gz /var/www/billiard-system/

# Keep multiple backups
# aws s3 cp billiard-app-*.tar.gz s3://backup-bucket/
```

### Recovery Procedure
```bash
# 1. Restore database
mysql billiard_system_prod < backup_20260122.sql

# 2. Restore files
tar -xzf billiard-app-20260122.tar.gz -C /var/www/

# 3. Clear caches
php artisan cache:clear
php artisan config:clear
```

---

## Monitoring & Maintenance

### Regular Tasks
- [ ] Monitor error logs daily
- [ ] Check disk space weekly
- [ ] Monitor CPU/Memory usage
- [ ] Review slow queries
- [ ] Test backups monthly
- [ ] Update dependencies quarterly
- [ ] Security audits quarterly

### Automated Monitoring
```bash
# Setup alert monitoring
# Use tools like:
# - New Relic
# - Datadog
# - CloudWatch
# - Prometheus
```

---

## Scaling Considerations

### If Traffic Increases
1. Upgrade database resources
2. Setup database replication
3. Add caching layer (Redis)
4. Use CDN for static assets
5. Load balancing for multiple servers
6. Queue system for heavy operations

### Load Testing
```bash
# Use Apache Bench
ab -n 1000 -c 10 https://yourdomain.com/

# Or use Load Impact
# https://loadimpact.com/
```

---

## Disaster Recovery Plan

### System Down
1. Check server status
2. Check database connectivity
3. Check disk space
4. Check error logs
5. Restart PHP-FPM/Apache
6. Restore from backup if needed

### Data Corruption
1. Stop application
2. Restore latest backup
3. Verify data integrity
4. Restart application
5. Monitor closely

### Security Breach
1. Take site offline
2. Review security logs
3. Change all credentials
4. Patch vulnerabilities
5. Restore from clean backup
6. Implement security measures

---

## Contact & Support

### Contacts to Have
- [ ] Hosting provider support
- [ ] Database administrator
- [ ] DevOps engineer
- [ ] Security team
- [ ] Development team

### Documentation
- [ ] Keep deployment notes
- [ ] Document custom configurations
- [ ] Update runbooks
- [ ] Keep asset inventory
- [ ] Maintain security policy

---

## Final Checklist

### Pre-Go Live
- [ ] All tests passed
- [ ] Performance metrics acceptable
- [ ] Security audit completed
- [ ] Database backed up
- [ ] Monitoring configured
- [ ] Logging configured
- [ ] Backups automated
- [ ] Disaster recovery plan ready
- [ ] Team trained
- [ ] Client approval received

### Go Live
- [ ] DNS updated
- [ ] SSL active
- [ ] Database migrated
- [ ] Application deployed
- [ ] Monitoring active
- [ ] Team on standby
- [ ] User communication sent

### Post Go Live (24-48 hours)
- [ ] Monitor all systems closely
- [ ] Watch error logs
- [ ] Check user feedback
- [ ] Verify all features
- [ ] Performance monitoring
- [ ] Security monitoring
- [ ] Be ready to rollback if needed

---

## Rollback Procedure

If deployment issues occur:
```bash
# 1. Get previous version
git checkout [previous-commit-hash]

# 2. Restore database backup
mysql billiard_system_prod < backup_previous.sql

# 3. Clear caches
php artisan cache:clear

# 4. Restart services
systemctl restart php-fpm
systemctl restart nginx

# 5. Verify working
# Test all critical features
```

---

**Deployment Date**: _______________  
**Deployed By**: _______________  
**Approved By**: _______________  
**Status**: [ ] Ready [ ] In Progress [ ] Completed

---

*Keep this checklist for future reference and updates.*
