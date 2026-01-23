# 🎱 Billiard Management System

Sistem manajemen billiard dengan fitur reservasi meja, pembayaran, dan tracking pesanan.

## 📋 Fitur Utama

- **Manajemen Meja Billiard**: Kelola daftar meja dengan status dan harga
- **Sistem Reservasi**: Pelanggan dapat memesan meja dengan tanggal dan waktu spesifik
- **Sistem Pembayaran**: Integrasi multiple metode pembayaran (Transfer Bank, Kartu Kredit, E-Wallet, Tunai)
- **Riwayat Pesanan**: Pantau semua pesanan dengan status real-time
- **Kwitansi Digital**: Generate dan cetak kwitansi pembayaran
- **Validasi Booking**: Otomatis cek ketersediaan meja berdasarkan waktu

## 🛠️ Teknologi yang Digunakan

- **Backend**: PHP Laravel 11
- **Database**: MySQL/MariaDB
- **Frontend**: HTML5, CSS3, JavaScript (Vanilla)
- **Authentication**: Laravel Authentication

## 📦 Instalasi

### Prasyarat
- PHP >= 8.2
- Composer
- MySQL/MariaDB
- Node.js (untuk build assets)

### Langkah-Langkah

1. **Clone atau setup project**
   ```bash
   cd c:\xampp\htdocs\projekbesariuridanmeisa
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Setup file environment**
   ```bash
   cp .env.example .env
   ```
   
   Edit `.env` dan konfigurasi database:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=billiard_system
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Generate application key**
   ```bash
   php artisan key:generate
   ```

5. **Migrasi database**
   ```bash
   php artisan migrate
   ```

6. **Seed data awal (opsional)**
   ```bash
   php artisan db:seed
   ```

7. **Build assets**
   ```bash
   npm run build
   ```

8. **Jalankan development server**
   ```bash
   php artisan serve
   ```

   Server akan berjalan di `http://localhost:8000`

## 📚 Struktur Database

### Tabel: billiard_tables
- `id`: ID unik meja
- `table_name`: Nama meja (contoh: "Meja Premium 1")
- `table_number`: Nomor urut meja
- `description`: Deskripsi meja
- `status`: Status (available, booked, maintenance)
- `price_per_hour`: Harga per jam dalam Rupiah
- `timestamps`: Created/Updated at

### Tabel: bookings
- `id`: ID unik pesanan
- `user_id`: ID pengguna
- `table_id`: ID meja
- `booking_date`: Tanggal pemesanan
- `start_time`: Jam mulai
- `end_time`: Jam selesai
- `duration_hours`: Durasi dalam jam
- `total_price`: Total harga
- `status`: Status pesanan (pending, confirmed, cancelled, completed)
- `notes`: Catatan tambahan
- `timestamps`: Created/Updated at

### Tabel: payments
- `id`: ID unik pembayaran
- `booking_id`: ID pesanan terkait
- `user_id`: ID pengguna
- `amount`: Jumlah pembayaran
- `status`: Status pembayaran (pending, completed, failed, refunded)
- `payment_method`: Metode pembayaran
- `transaction_id`: ID transaksi
- `payment_details`: Detail pembayaran (JSON)
- `paid_at`: Waktu pembayaran
- `timestamps`: Created/Updated at

## 🚀 Penggunaan

### Sebagai Admin
1. Login ke aplikasi
2. Navigasi ke "Meja Billiard" untuk melihat daftar meja
3. Kelola status dan harga meja

### Sebagai Pengguna
1. Daftar atau login
2. Lihat daftar meja yang tersedia
3. Klik "Pesan Sekarang" pada meja pilihan
4. Isi form pemesanan (tanggal, waktu, durasi)
5. Lanjut ke pembayaran
6. Pilih metode pembayaran
7. Konfirmasi pembayaran
8. Terima kwitansi digital

## 🔐 Fitur Keamanan

- Authentication & Authorization
- CSRF Protection
- Input Validation
- SQL Injection Prevention
- XSS Protection

## 📧 Routes Utama

- `GET /` - Halaman beranda
- `GET /tables` - Daftar meja billiard
- `GET /bookings` - Daftar pesanan pengguna
- `POST /bookings` - Buat pesanan baru
- `GET /bookings/{id}` - Detail pesanan
- `POST /bookings/{id}/cancel` - Batalkan pesanan
- `GET /payments/{bookingId}` - Halaman pembayaran
- `POST /payments/{bookingId}/process` - Proses pembayaran
- `GET /payments` - Riwayat pembayaran
- `GET /payments/{bookingId}/receipt` - Kwitansi

## 💡 Saran Pengembangan

1. **Integrasi Payment Gateway**: Implementasikan Midtrans, PayPal, atau payment gateway lokal
2. **Email Notifications**: Kirim email konfirmasi dan reminder pesanan
3. **SMS Notifications**: Notifikasi via SMS untuk reminder pesanan
4. **Dashboard Admin**: Buat dashboard statistik dan laporan penjualan
5. **API REST**: Buat API untuk mobile app
6. **Push Notifications**: Implementasikan push notification
7. **Multi-Language**: Support bahasa Indonesia dan Inggris
8. **Analytics**: Tracking penjualan dan trend booking

## 📝 Lisensi

Proyek ini adalah contoh pembelajaran dan dapat dimodifikasi sesuai kebutuhan.

## 👨‍💻 Pengembang

Billiard Management System v1.0

---

**Catatan**: Sistem ini masih dalam tahap development. Untuk production, pastikan:
- Setup SSL/HTTPS
- Konfigurasi payment gateway yang sebenarnya
- Setup email service
- Backup database regular
- Monitor error logs
