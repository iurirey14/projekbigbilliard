# 🚀 Billiard Management System - Quick Start Guide

## Panduan Cepat Setup

### Prasyarat
- PHP 8.2+
- MySQL 5.7+ atau MariaDB
- Composer
- Node.js 16+
- XAMPP atau Apache/MySQL Server lainnya

### 1️⃣ Setup Database

```bash
# Buat database
CREATE DATABASE billiard_system CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 2️⃣ Konfigurasi Environment

Edit file `.env`:
```env
APP_NAME="Billiard Management System"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=billiard_system
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=log
```

### 3️⃣ Install Dependencies

```bash
composer install
npm install
```

### 4️⃣ Generate Application Key

```bash
php artisan key:generate
```

### 5️⃣ Migrasi Database

```bash
php artisan migrate
php artisan db:seed
```

### 6️⃣ Build Frontend Assets

```bash
npm run build
```

Untuk development dengan hot reload:
```bash
npm run dev
```

### 7️⃣ Jalankan Server

```bash
php artisan serve
```

Server akan berjalan di: **http://localhost:8000**

---

## 📝 Test User

Setelah seed, Anda bisa login dengan:
- **Email**: test@example.com
- **Password**: password

---

## 🔑 Fitur Utama yang Tersedia

### 1. Manajemen Meja
- ✅ Lihat daftar meja billiard
- ✅ Filter meja berdasarkan ketersediaan
- ✅ Lihat detail dan harga meja

### 2. Sistem Reservasi
- ✅ Pesan meja dengan tanggal dan waktu
- ✅ Cek ketersediaan otomatis
- ✅ Durasi flexible (1-12 jam)
- ✅ Lihat ringkasan harga real-time

### 3. Pembayaran
- ✅ Multiple payment methods:
  - Transfer Bank
  - Kartu Kredit
  - E-Wallet
  - Tunai
- ✅ Konfirmasi pembayaran
- ✅ Riwayat pembayaran lengkap

### 4. Tracking Pesanan
- ✅ Lihat semua pesanan Anda
- ✅ Status real-time setiap pesanan
- ✅ Batalkan pesanan jika diperlukan
- ✅ Cetak kwitansi digital

---

## 📁 Struktur Folder Penting

```
app/
├── Http/
│   └── Controllers/
│       ├── BookingController.php
│       ├── PaymentController.php
│       └── BilliardTableController.php
├── Models/
│   ├── BilliardTable.php
│   ├── Booking.php
│   ├── Payment.php
│   └── User.php
routes/
├── web.php
database/
├── migrations/
│   ├── *_create_billiard_tables_table.php
│   ├── *_create_bookings_table.php
│   └── *_create_payments_table.php
└── seeders/
    ├── DatabaseSeeder.php
    └── BilliardTableSeeder.php
resources/
├── views/
│   ├── layouts/app.blade.php
│   ├── bookings/
│   ├── payments/
│   └── tables/
├── css/
│   └── billiard.css
└── js/
    └── billiard.js
```

---

## 🌐 API Endpoints

### Tables (Meja)
```
GET    /tables                    - Lihat semua meja
GET    /tables/{id}               - Detail meja
GET    /api/available-tables      - Check ketersediaan meja
```

### Bookings (Pesanan)
```
GET    /bookings                  - Lihat pesanan saya
GET    /bookings/create           - Form pesan meja baru
POST   /bookings                  - Buat pesanan baru
GET    /bookings/{id}             - Detail pesanan
POST   /bookings/{id}/cancel      - Batalkan pesanan
```

### Payments (Pembayaran)
```
GET    /payments/{bookingId}      - Halaman pembayaran
POST   /payments/{bookingId}/process - Proses pembayaran
GET    /payments                  - Riwayat pembayaran
GET    /payments/{bookingId}/receipt - Cetak kwitansi
```

---

## 🎯 Workflow Booking

1. **Login** → Masuk ke sistem
2. **Lihat Meja** → Browse daftar meja billiard
3. **Pesan Meja** → Pilih meja, tanggal, waktu, durasi
4. **Review Booking** → Cek ringkasan dan total harga
5. **Lakukan Pembayaran** → Pilih metode pembayaran
6. **Konfirmasi** → Terima kwitansi dan nomor transaksi
7. **Track Pesanan** → Monitor status pesanan

---

## 🔒 Keamanan

- ✅ CSRF Protection (Laravel Token)
- ✅ Input Validation
- ✅ Authentication
- ✅ Authorization (user hanya bisa lihat pesanan mereka)
- ✅ SQL Injection Prevention (ORM Eloquent)
- ✅ XSS Protection

---

## 🐛 Troubleshooting

### Error: "No application encryption key has been specified"
```bash
php artisan key:generate
```

### Error: "Class not found"
```bash
composer dump-autoload
```

### Error: "Table doesn't exist"
```bash
php artisan migrate
php artisan db:seed
```

### Error: Port 8000 already in use
```bash
php artisan serve --port=8001
```

---

## 📱 Responsive Design

Aplikasi sudah responsive dan bisa diakses dari:
- ✅ Desktop
- ✅ Tablet
- ✅ Mobile

---

## 🎨 Customization

### Mengubah Warna Tema
Edit `resources/css/billiard.css`:
```css
:root {
    --primary-color: #667eea;      /* Ubah warna utama */
    --secondary-color: #764ba2;    /* Ubah warna sekunder */
}
```

### Mengubah Harga Meja
Edit database atau form di admin panel.

### Menambah Metode Pembayaran
Edit enum di migration `payments` table.

---

## 📊 Database Schema Relationship

```
Users (1) ---> (Many) Bookings
Bookings (1) ---> (1) BilliardTables
Bookings (1) ---> (1) Payments
Payments (Many) ---> (1) Users
```

---

## ✨ Fitur yang Bisa Dikembangkan

1. **Admin Dashboard**
   - Statistik penjualan
   - Laporan booking
   - Manajemen meja

2. **Email Notifications**
   - Confirmation email
   - Reminder sebelum booking
   - Invoice email

3. **Payment Gateway Integration**
   - Midtrans
   - PayPal
   - Stripe

4. **Mobile App**
   - React Native / Flutter

5. **Advanced Features**
   - Multi-location support
   - Package pricing
   - Member loyalty system
   - Reviews & ratings

---

## 📞 Support

Untuk pertanyaan atau bantuan, hubungi tim development.

---

**Selamat menggunakan Billiard Management System! 🎱**
