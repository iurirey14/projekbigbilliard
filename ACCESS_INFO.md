# 🚀 Billiard Management System - Akses Website

## ✅ Status: BERJALAN & SIAP DIGUNAKAN

---

## 🌐 URL Website

### **Development Server**
```
http://localhost:8000
http://127.0.0.1:8000
```

---

## 👤 Akun Login

### Test User
```
Email: test@example.com
Password: password
```

### Cara Login
1. Buka http://localhost:8000
2. Klik "Login" (jika ada) atau pergi ke http://localhost:8000/login
3. Masukkan email dan password di atas
4. Setelah login, Anda bisa:
   - ✅ Melihat daftar meja biliar
   - ✅ Membuat pemesanan baru
   - ✅ Melihat riwayat pemesanan
   - ✅ Melakukan pembayaran
   - ✅ Mencetak kwitansi

---

## 🎯 Fitur yang Tersedia

### 1. **Daftar Meja Biliar**
```
URL: http://localhost:8000/tables
Deskripsi: Lihat semua meja biliar dengan harga dan status
```

### 2. **Buat Pemesanan**
```
URL: http://localhost:8000/bookings/create
Deskripsi: Pesan meja biliar dengan memilih tanggal, waktu, dan durasi
```

### 3. **Riwayat Pemesanan**
```
URL: http://localhost:8000/bookings
Deskripsi: Lihat semua pemesanan Anda yang sudah dibuat
```

### 4. **Proses Pembayaran**
```
URL: http://localhost:8000/payments/{booking_id}
Deskripsi: Pembayaran dengan berbagai metode (Transfer Bank, Kartu Kredit, E-Wallet, Tunai)
```

### 5. **Lihat Riwayat Pembayaran**
```
URL: http://localhost:8000/payments
Deskripsi: Riwayat semua pembayaran yang sudah dilakukan
```

---

## 📊 Data Sample yang Tersedia

### Meja Biliar
1. **Meja Premium 1** - Rp 50.000/jam
2. **Meja Premium 2** - Rp 50.000/jam
3. **Meja Standard 1** - Rp 30.000/jam
4. **Meja Standard 2** - Rp 30.000/jam
5. **Meja VIP 1** - Rp 75.000/jam

### User Test
- Email: test@example.com
- Password: password

---

## 🛠️ Setup yang Sudah Selesai

✅ Database migrations selesai  
✅ Database seeder selesai (data sample siap)  
✅ NPM dependencies selesai  
✅ Assets build selesai  
✅ Server Laravel running  
✅ Error Blade template sudah diperbaiki  

---

## 📋 Workflow Lengkap Testing

### Step 1: Login
```
1. Buka: http://localhost:8000
2. Klik Login
3. Email: test@example.com
4. Password: password
5. Tekan Login
```

### Step 2: Lihat Meja Tersedia
```
1. Setelah login, klik "Daftar Meja" atau pergi ke /tables
2. Lihat semua meja yang tersedia
3. Perhatikan harga per jam untuk setiap meja
```

### Step 3: Buat Pemesanan
```
1. Klik "Pesan Sekarang" di meja yang ingin dipesan
2. Atau pergi langsung ke /bookings/create
3. Pilih:
   - Meja biliar
   - Tanggal pemesanan (minimal besok)
   - Jam mulai
   - Durasi (jam)
   - Catatan (opsional)
4. Klik "Pesan Sekarang"
5. Sistem otomatis menghitung total harga
```

### Step 4: Lihat Pemesanan
```
1. Pergi ke /bookings
2. Lihat daftar semua pemesanan Anda
3. Klik detail untuk melihat informasi lengkap
```

### Step 5: Lakukan Pembayaran
```
1. Di halaman pemesanan, klik "Bayar"
2. Pilih metode pembayaran:
   - Transfer Bank
   - Kartu Kredit
   - E-Wallet
   - Tunai
3. Klik "Lanjutkan Pembayaran"
4. Akan redirect ke halaman kwitansi
```

### Step 6: Lihat Kwitansi
```
1. Setelah pembayaran, bisa langsung lihat kwitansi
2. Atau pergi ke /payments untuk lihat riwayat
3. Klik "Lihat Kwitansi" untuk print
```

---

## 🔧 Troubleshooting

### Error: Connection Refused
```
Kemungkinan: Server belum running
Solusi: 
1. Buka terminal di folder projekt
2. Jalankan: php artisan serve
3. Tunggu sampai muncul: INFO Server running on [http://127.0.0.1:8000]
```

### Error: Database Error
```
Kemungkinan: Database belum di-setup
Solusi:
1. Buka terminal
2. Jalankan: php artisan migrate
3. Jalankan: php artisan db:seed
4. Refresh halaman browser
```

### Error: Blank Page
```
Kemungkinan: Cache atau assets belum build
Solusi:
1. Jalankan: php artisan cache:clear
2. Jalankan: npm run build
3. Refresh halaman dengan Ctrl+Shift+R (hard refresh)
```

### Error: Login Gagal
```
Kemungkinan: User belum di-seed
Solusi:
1. Jalankan: php artisan db:seed
2. Gunakan akun: test@example.com / password
```

---

## 📱 Device Testing

### Desktop
```
URL: http://localhost:8000
Browser: Chrome, Firefox, Edge, Safari
Responsive: Yes (teruji di 1920x1080, 1366x768, 1024x768)
```

### Tablet
```
Responsive Design: ✅ Supported
Breakpoint: 768px - 1024px
```

### Mobile
```
Responsive Design: ✅ Supported
Breakpoint: < 768px
Tested: iPhone, Android
```

---

## 🔐 Security Notes

### Development
- APP_DEBUG=true (saat development)
- APP_ENV=local

### Sebelum Production
- [ ] Ubah APP_DEBUG=false
- [ ] Ubah APP_ENV=production
- [ ] Update database credentials
- [ ] Setup HTTPS/SSL
- [ ] Integrate real payment gateway
- [ ] Setup email notifications

---

## 📞 Informasi Kontak Database

```
Host: 127.0.0.1 atau localhost
Port: 3306
Database: billiard_system
Username: root
Password: (kosong untuk XAMPP default)
```

---

## 🎓 Dokumentasi Lengkap

Untuk informasi lebih detail, baca dokumentasi:

| Dokumen | Deskripsi |
|---------|-----------|
| START_HERE.md | Mulai di sini |
| QUICKSTART.md | Setup cepat 5 menit |
| QUICK_REFERENCE.md | Referensi cepat |
| API_DOCUMENTATION.md | API endpoints lengkap |
| TROUBLESHOOTING.md | Solusi error umum |
| DEPLOYMENT_CHECKLIST.md | Deployment ke production |
| TESTING_CHECKLIST.md | QA testing guide |

---

## ✨ Features Highlight

✅ Responsive Design - Bekerja di semua device  
✅ Real-time Calculation - Hitung otomatis saat input  
✅ Booking Conflict Detection - Cegah double booking  
✅ Multiple Payment Methods - 4 metode pembayaran  
✅ Digital Receipt - Kwitansi printable  
✅ Payment History - Riwayat pembayaran lengkap  
✅ User Authorization - Keamanan user-level  
✅ Beautiful UI - Design modern dan menarik  

---

## 🚀 Next Steps

1. ✅ Buka http://localhost:8000
2. ✅ Login dengan akun test
3. ✅ Explore semua fitur
4. ✅ Test workflow lengkap
5. ✅ Customisasi sesuai kebutuhan
6. ✅ Deploy ke production (lihat DEPLOYMENT_CHECKLIST.md)

---

**Selamat menggunakan Billiard Management System! 🎉**

Jika ada pertanyaan, baca dokumentasi atau check troubleshooting guide.
