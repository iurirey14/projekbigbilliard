# 🎱 Billiard Management System

Sistem manajemen billiard lengkap dengan fitur reservasi meja, pembayaran online, tracking pesanan, dan kwitansi digital.

## ✨ Fitur Utama

### 🎯 User Features
- **Registrasi & Login** - Akun user dengan authentication
- **Browse Meja** - Lihat daftar semua meja billiard dengan harga dan deskripsi
- **Reservasi Meja** - Pesan meja dengan pilih tanggal, waktu, dan durasi
- **Cek Ketersediaan** - Otomatis validasi ketersediaan meja real-time
- **Tracking Pesanan** - Monitor status pesanan (pending, confirmed, completed, cancelled)
- **Pembayaran Online** - Multiple metode pembayaran
- **Riwayat Transaksi** - Lihat semua riwayat pembayaran
- **Cetak Kwitansi** - Generate dan cetak kwitansi digital

### 🔧 Technical Features
- **Responsive Design** - Berjalan di desktop, tablet, dan mobile
- **Input Validation** - Validasi form untuk user experience yang baik
- **Error Handling** - Error handling yang comprehensive
- **Database Relationship** - Model relationship yang proper
- **Security** - CSRF Protection, SQL Injection Prevention, XSS Protection

---

## 🛠️ Tech Stack

| Layer | Technology |
|-------|-----------|
| **Backend** | Laravel 11 (PHP 8.2+) |
| **Frontend** | HTML5, CSS3, Vanilla JavaScript |
| **Database** | MySQL 5.7+ / MariaDB |
| **Build Tool** | Vite, npm |
| **Authentication** | Laravel Auth |
| **ORM** | Eloquent |

---

## 📋 Prerequisites

- PHP >= 8.2
- Composer
- MySQL >= 5.7 atau MariaDB
- Node.js >= 16
- npm atau yarn

---

## 🚀 Quick Installation

### Option 1: Automatic Setup (Windows)
```bash
setup.bat
```

### Option 2: Manual Setup

1. **Clone repository**
   ```bash
   cd c:\xampp\htdocs\projekbesariuridanmeisa
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node dependencies**
   ```bash
   npm install
   ```

4. **Setup environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure Database** (edit .env)
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=billiard_system
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Create Database** (MySQL)
   ```sql
   CREATE DATABASE billiard_system 
   CHARACTER SET utf8mb4 
   COLLATE utf8mb4_unicode_ci;
   ```

7. **Run Migrations & Seeding**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

8. **Build Assets**
   ```bash
   npm run build
   ```

9. **Start Server**
   ```bash
   php artisan serve
   ```

10. **Access Application**
    - URL: http://localhost:8000
    - Test User Email: test@example.com
    - Test User Password: password

---

## 📁 Project Structure

```
billiard-management/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── BilliardTableController.php
│   │       ├── BookingController.php
│   │       └── PaymentController.php
│   └── Models/
│       ├── BilliardTable.php
│       ├── Booking.php
│       ├── Payment.php
│       └── User.php
├── database/
│   ├── migrations/
│   │   ├── *_create_billiard_tables_table.php
│   │   ├── *_create_bookings_table.php
│   │   └── *_create_payments_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       └── BilliardTableSeeder.php
├── resources/
│   ├── css/
│   │   └── billiard.css
│   ├── js/
│   │   └── billiard.js
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── bookings/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   └── show.blade.php
│       ├── payments/
│       │   ├── show.blade.php
│       │   ├── receipt.blade.php
│       │   └── list.blade.php
│       └── tables/
│           └── index.blade.php
├── routes/
│   └── web.php
├── .env
├── .env.example
├── setup.bat
├── SETUP.md
├── QUICKSTART.md
├── API_DOCUMENTATION.md
└── README.md
```

---

## 🗄️ Database Schema

### Users Table
```sql
id, name, email, email_verified_at, password, remember_token, created_at, updated_at
```

### Billiard Tables
```sql
id, table_name, table_number, description, status, price_per_hour, created_at, updated_at
```

### Bookings
```sql
id, user_id, table_id, booking_date, start_time, end_time, 
duration_hours, total_price, status, notes, created_at, updated_at
```

### Payments
```sql
id, booking_id, user_id, amount, status, payment_method, 
transaction_id, payment_details (JSON), paid_at, created_at, updated_at
```

---

## 🔐 Authentication & Authorization

- ✅ User Registration
- ✅ Email verification-ready
- ✅ Login/Logout
- ✅ Password reset capability
- ✅ Role-based access control (future)
- ✅ Booking ownership validation

---

## 📊 Key Workflows

### Booking Flow
1. User browse available tables
2. Select table and book with date/time
3. System validates availability
4. Create booking & payment record
5. User proceeds to payment
6. Select payment method
7. Process payment
8. Booking confirmed
9. User receives digital receipt

### Payment Flow
1. User selects payment method
2. Payment processed (simulated in current version)
3. Payment marked as completed
4. Booking status updated to confirmed
5. Digital receipt generated

---

## 🎨 UI/UX Features

- **Modern Design** - Clean and intuitive interface
- **Gradient Theme** - Professional gradient color scheme
- **Responsive Layout** - Mobile-first responsive design
- **Form Validation** - Real-time form validation
- **Status Badges** - Visual status indicators
- **Summary Cards** - Clear booking/payment summaries
- **Smooth Transitions** - Smooth CSS animations
- **Loading States** - Visual feedback during operations

---

## 🔌 Payment Methods

Currently supported:
- 💳 Kartu Kredit (placeholder)
- 🏦 Transfer Bank (placeholder)
- 📱 E-Wallet (placeholder)
- 💰 Tunai (Cash on site)

**Note**: Integrate with real payment gateway like Midtrans, PayPal, or Stripe for production.

---

## 📱 Responsive Breakpoints

- 📱 Mobile: < 768px
- 📱 Tablet: 768px - 1024px
- 💻 Desktop: > 1024px

---

## 🔍 Search & Filter

- Filter tables by availability
- Filter bookings by date range
- Filter payments by status
- Search functionality ready to implement

---

## 📊 Reports & Export

- Print invoices
- Export booking data (future)
- Revenue reports (future)
- Monthly analytics (future)

---

## 🛡️ Security Features

- CSRF Token Protection
- SQL Injection Prevention (ORM)
- XSS Protection (Laravel escaping)
- Input Validation & Sanitization
- Password Hashing (Bcrypt)
- Session Security
- HTTPS Ready

---

## ⚡ Performance Optimizations

- Eager loading (with relations)
- Query optimization
- Caching ready
- Asset minification (CSS/JS)
- Database indexing

---

## 🐛 Error Handling

- Custom error pages
- Validation error messages
- Database error handling
- Authorization exceptions
- Graceful error responses

---

## 📝 Logging

- Application logs in `storage/logs/`
- Database query logging
- Error tracking ready
- User action logging ready

---

## 🔄 Database Seeders

Run initial seeding:
```bash
php artisan db:seed
```

Seeds include:
- Test user account
- 5 sample billiard tables with different prices

---

## 🚀 Deployment

### For Production:
1. Set `APP_DEBUG=false` in .env
2. Set `APP_ENV=production`
3. Configure real database
4. Setup real payment gateway
5. Configure email service
6. Enable HTTPS
7. Run `composer install --no-dev --optimize-autoloader`
8. Run migrations: `php artisan migrate --force`
9. Clear caches: `php artisan cache:clear`
10. Run: `php artisan config:cache`

---

## 📚 Documentation Files

- **README.md** - This file
- **SETUP.md** - Detailed setup instructions
- **QUICKSTART.md** - Quick start guide
- **API_DOCUMENTATION.md** - Complete API reference

---

## 🤝 Contributing

To extend this system:
1. Create new controller for new features
2. Create migrations for new tables
3. Create models for new entities
4. Create views for UI
5. Add routes in web.php
6. Test thoroughly

---

## 📞 Support & FAQ

### Q: How to add more tables?
A: Use admin panel (future) or directly insert in database.

### Q: How to change prices?
A: Edit billiard_tables table or create admin interface.

### Q: How to integrate real payment gateway?
A: Update PaymentController.php with Midtrans/PayPal SDK.

### Q: How to add email notifications?
A: Use Laravel Mail and create Mailable classes.

### Q: How to create admin dashboard?
A: Create AdminController and admin views, add role-based auth.

---

## 🎯 Future Enhancements

- [ ] Admin Dashboard
- [ ] Real Payment Gateway Integration (Midtrans/PayPal)
- [ ] Email Notifications
- [ ] SMS Reminders
- [ ] Mobile App (React Native)
- [ ] Advanced Analytics
- [ ] Member Loyalty System
- [ ] Reviews & Ratings
- [ ] Multi-location Support
- [ ] Package Deals
- [ ] Bulk Bookings
- [ ] Calendar Integration
- [ ] Push Notifications
- [ ] Dark Mode
- [ ] Multi-language Support

---

## 📄 License

This project is for educational and commercial use. Feel free to modify and extend it.

---

## 👨‍💻 Developer Notes

- Built with Laravel 11
- Compatible with PHP 8.2+
- Uses Eloquent ORM for database operations
- Blade templating for views
- Tailored for Indonesian market (but globally adaptable)
- Follows Laravel best practices

---

## 🎊 Getting Help

For issues or questions:
1. Check documentation files
2. Review code comments
3. Check API documentation
4. Look at example implementations

---

**Made with ❤️ for Billiard Business Owners**

Current Version: v1.0  
Last Updated: January 22, 2026
