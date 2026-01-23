# ⚡ Billiard Management System - Quick Reference

Panduan cepat untuk referensi saat menggunakan sistem.

---

## 🚀 Setup Cepat

### First Time Setup (5 menit)
```bash
# 1. Create database
CREATE DATABASE billiard_system CHARACTER SET utf8mb4;

# 2. Configure .env
DB_DATABASE=billiard_system
DB_USERNAME=root
DB_PASSWORD=

# 3. Install
composer install
npm install

# 4. Setup app
php artisan key:generate
php artisan migrate
php artisan db:seed
npm run build

# 5. Run
php artisan serve

# Access: http://localhost:8000
# Login: test@example.com / password
```

---

## 🎯 Features at a Glance

### Tables (Meja)
```
Route: /tables
View: List semua meja dengan harga
API: GET /tables
```

### Bookings (Pesanan)
```
Create: /bookings/create
View: /bookings
Detail: /bookings/{id}
Cancel: POST /bookings/{id}/cancel
```

### Payments (Pembayaran)
```
Pay: /payments/{bookingId}
Process: POST /payments/{bookingId}/process
History: /payments
Receipt: /payments/{bookingId}/receipt
```

---

## 📊 Database Quick Reference

### Table: billiard_tables
```
- id (primary key)
- table_name (string)
- table_number (integer)
- description (text)
- status (enum: available, booked, maintenance)
- price_per_hour (integer)
- created_at, updated_at
```

### Table: bookings
```
- id (primary key)
- user_id (foreign key)
- table_id (foreign key)
- booking_date (date)
- start_time (time)
- end_time (time)
- duration_hours (integer)
- total_price (integer)
- status (enum: pending, confirmed, cancelled, completed)
- notes (text)
- created_at, updated_at
```

### Table: payments
```
- id (primary key)
- booking_id (foreign key)
- user_id (foreign key)
- amount (integer)
- status (enum: pending, completed, failed, refunded)
- payment_method (enum: transfer_bank, credit_card, e_wallet, cash)
- transaction_id (string)
- paid_at (datetime)
- created_at, updated_at
```

---

## 🔧 Common Commands

### PHP Artisan
```bash
php artisan serve              # Run development server
php artisan migrate            # Run migrations
php artisan db:seed            # Seed database
php artisan migrate:refresh    # Reset database
php artisan tinker             # Interactive shell
php artisan cache:clear        # Clear cache
php artisan config:cache       # Cache config
```

### NPM
```bash
npm install                    # Install dependencies
npm run dev                    # Development (watch)
npm run build                  # Production build
```

### Composer
```bash
composer install               # Install PHP packages
composer update               # Update packages
composer dump-autoload        # Refresh autoloader
```

---

## 🎨 Code Structure

### Controllers Location
```
app/Http/Controllers/
├── BilliardTableController.php
├── BookingController.php
└── PaymentController.php
```

### Models Location
```
app/Models/
├── BilliardTable.php
├── Booking.php
├── Payment.php
└── User.php
```

### Views Location
```
resources/views/
├── layouts/app.blade.php
├── tables/index.blade.php
├── bookings/
│   ├── create.blade.php
│   ├── index.blade.php
│   └── show.blade.php
└── payments/
    ├── show.blade.php
    ├── receipt.blade.php
    └── list.blade.php
```

---

## 🔐 Security Checklist

Before production:
- [ ] Set APP_DEBUG=false in .env
- [ ] Change APP_ENV=production
- [ ] Update database credentials
- [ ] Setup HTTPS/SSL
- [ ] Configure real payment gateway
- [ ] Setup email service
- [ ] Update APP_URL
- [ ] Run: php artisan config:cache

---

## 🐛 Debugging Tips

### View Application Logs
```bash
tail -f storage/logs/laravel.log
```

### Access Interactive Shell
```bash
php artisan tinker

# Inside tinker:
>>> User::all()
>>> Booking::latest()->first()
>>> auth()->check()
>>> DB::getQueryLog()
```

### Clear Everything
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

---

## 📱 Responsive Breakpoints

```css
Mobile: < 768px
Tablet: 768px - 1024px
Desktop: > 1024px
```

---

## 🎨 Color Reference

```
Primary: #667eea (Purple-Blue)
Secondary: #764ba2 (Dark Purple)
Success: #51cf66 (Green)
Danger: #ff6b6b (Red)
Warning: #ffa94d (Orange)
Info: #339af0 (Blue)
Light BG: #f5f5f5 (Gray)
```

---

## 🔗 Quick Links

| What | Where |
|------|-------|
| Setup Help | [QUICKSTART.md](QUICKSTART.md) |
| API Docs | [API_DOCUMENTATION.md](API_DOCUMENTATION.md) |
| Troubleshoot | [TROUBLESHOOTING.md](TROUBLESHOOTING.md) |
| Testing | [TESTING_CHECKLIST.md](TESTING_CHECKLIST.md) |
| Deployment | [DEPLOYMENT_CHECKLIST.md](DEPLOYMENT_CHECKLIST.md) |
| Project Info | [PROJECT_SUMMARY.md](PROJECT_SUMMARY.md) |

---

## 👤 Test User

```
Email: test@example.com
Password: password
```

---

## 🌍 URLs

```
Development: http://localhost:8000
Production: https://yourdomain.com
API Base: /api
```

---

## 📧 Email Config

```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@domain.com
```

---

## 🗄️ Database Credentials (Development)

```
Host: 127.0.0.1 or localhost
Port: 3306
Database: billiard_system
Username: root
Password: (usually empty for XAMPP)
```

---

## 📋 Status Values

### Booking Status
```
pending     = Menunggu pembayaran
confirmed   = Sudah dibayar
cancelled   = Dibatalkan
completed   = Selesai
```

### Payment Status
```
pending     = Menunggu pembayaran
completed   = Berhasil dibayar
failed      = Pembayaran gagal
refunded    = Refund diterima
```

### Table Status
```
available   = Tersedia
booked      = Sudah dipesan
maintenance = Dalam perawatan
```

---

## ⚙️ Configuration File Location

```
.env                       # Main config
config/app.php             # App settings
config/database.php        # DB settings
config/auth.php            # Auth settings
config/mail.php            # Mail settings
```

---

## 📂 Important Directories

```
storage/logs/              # Application logs
storage/app/               # File storage
bootstrap/cache/           # Cache files
public/                    # Web root
resources/views/           # Views
routes/                    # Routes
database/                  # Migrations & seeds
```

---

## 🔄 Workflow Commands

### New Booking Flow
```
1. Browse: GET /tables
2. Select: Click table
3. Form: GET /bookings/create
4. Submit: POST /bookings
5. Pay: GET /payments/{id}
6. Process: POST /payments/{id}/process
7. Receipt: GET /payments/{id}/receipt
```

---

## 🚀 Performance Tips

```
1. Use database indexing
2. Enable query caching
3. Minify CSS/JS
4. Optimize images
5. Use Redis caching
6. Setup CDN for assets
7. Enable gzip compression
8. Use query pagination
```

---

## 🔒 Security Headers

```
Strict-Transport-Security: max-age=31536000
X-Frame-Options: DENY
X-Content-Type-Options: nosniff
X-XSS-Protection: 1; mode=block
```

---

## 📱 API Response Format

### Success (200)
```json
{
    "data": {...},
    "message": "Success message"
}
```

### Error (4xx/5xx)
```json
{
    "error": "Error message",
    "validation_errors": {
        "field": ["error"]
    }
}
```

---

## 🧪 Testing Commands

```bash
# Unit tests
php artisan test

# Feature tests
php artisan test tests/Feature

# Specific test
php artisan test tests/Feature/BookingTest.php
```

---

## 📊 File Size Reference

```
.env: ~1 KB
controllers/: ~50 KB
models/: ~10 KB
views/: ~20 KB
migrations/: ~5 KB
CSS: ~10 KB (minified)
JS: ~5 KB (minified)
```

---

## ⏱️ Typical Operations

```
Login: < 1 second
Browse tables: < 1 second
Create booking: < 2 seconds
Process payment: < 2 seconds
Print receipt: instant
View history: < 1 second
```

---

## 🎯 Browser DevTools Tips

### Check Performance
- Open DevTools (F12)
- Go to Network tab
- Reload page
- Check load times

### Debug JavaScript
- Go to Console tab
- Check for errors
- Use console.log()

### Check Responsive
- Press Ctrl+Shift+M
- Select device type
- Test interactions

---

## 📞 Quick Contacts

### For Issues
1. Check logs: `storage/logs/`
2. Search docs
3. Check troubleshooting
4. Review code comments

### Common Issues
- **Blank page**: Check error logs
- **Database error**: Check .env
- **Can't login**: Check users table
- **Styles missing**: Run `npm run build`

---

## 🎓 Learning Resources

- [Laravel Docs](https://laravel.com/docs)
- [PHP Documentation](https://www.php.net/docs.php)
- [MySQL Documentation](https://dev.mysql.com/doc/)
- [MDN Web Docs](https://developer.mozilla.org/)

---

## ✅ Pre-Launch Checklist

- [ ] Database created
- [ ] .env configured
- [ ] Migrations run
- [ ] Seeds executed
- [ ] Assets built
- [ ] Can login
- [ ] Can create booking
- [ ] Can process payment
- [ ] Can view receipt
- [ ] Responsive on mobile

---

## 🎉 You're Ready!

This quick reference covers the essentials. For more details:
- Setup: Read [QUICKSTART.md](QUICKSTART.md)
- Issues: Check [TROUBLESHOOTING.md](TROUBLESHOOTING.md)
- API: See [API_DOCUMENTATION.md](API_DOCUMENTATION.md)

---

**Happy coding! 🚀**
