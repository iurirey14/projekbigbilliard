# 📸 PANDUAN VISUAL MENGGUNAKAN WEBSITE

---

## 🌐 AKSES WEBSITE

### ✅ Langkah 1: Buka Browser

Ketik URL ini di address bar browser Anda:
```
http://localhost:8000
```

**Atau:**
```
http://127.0.0.1:8000
```

Kedua URL sama. Pilih salah satu.

---

## 🔑 LOGIN KE SISTEM

### ✅ Langkah 2: Klik Login

Jika halaman pertama adalah homepage:
1. Cari tombol **"Login"** di bagian atas/kanan halaman
2. Klik tombol Login

**Atau buka langsung:**
```
http://localhost:8000/login
```

### ✅ Langkah 3: Masukkan Akun Test

Di form login, masukkan:

**Email:**
```
test@example.com
```

**Password:**
```
password
```

Kemudian klik tombol **"Login"** atau **"Sign In"**

---

## 🎮 SETELAH LOGIN BERHASIL

Anda akan masuk ke dashboard dengan menu:

```
📋 Daftar Meja
📝 Pemesanan Saya
💳 Pembayaran
👤 Profil
🚪 Logout
```

---

## 📋 FITUR 1: LIHAT DAFTAR MEJA

### ✅ Langkah-langkah:

1. **Klik menu "Daftar Meja"** (atau buka `/tables`)

2. **Halaman akan menampilkan:**
   - 5 kartu meja biliar
   - Nama meja dan nomor
   - Status (Tersedia/Booked)
   - Harga per jam
   - Deskripsi

3. **Setiap kartu ada tombol:**
   - **"Pesan Sekarang"** - Untuk membuat booking

### 💰 Harga Meja:
```
- Meja Premium 1 & 2: Rp 50.000/jam
- Meja Standard 1 & 2: Rp 30.000/jam
- Meja VIP 1: Rp 75.000/jam
```

---

## 📅 FITUR 2: BUAT PEMESANAN BARU

### ✅ Langkah-langkah:

1. **Klik "Pesan Sekarang"** dari halaman daftar meja

2. **Halaman form booking akan terbuka dengan field:**

   ```
   [Pilih Meja] ▼
   [Tanggal Pemesanan] (date picker)
   [Jam Mulai] (format HH:MM)
   [Durasi] ▼ (1-12 jam)
   [Catatan] (text area - opsional)
   
   [Ringkasan Pemesanan]
   - Meja: ...
   - Tanggal: ...
   - Jam: ...
   - Durasi: ... jam
   - Total Harga: Rp ...
   
   [PESAN SEKARANG] button
   ```

3. **Isi form dengan lengkap:**
   - **Pilih Meja**: Dropdown memilih meja
   - **Tanggal**: Minimal untuk besok (tidak bisa hari ini)
   - **Jam Mulai**: Misalnya 14:00 (format 24 jam)
   - **Durasi**: 1-12 jam
   - **Catatan**: Optional, tapi bisa isi untuk catatan khusus

4. **Harga Otomatis Terhitung:**
   - Saat Anda mengisi form, otomatis muncul ringkasan
   - Harga = Harga Meja/jam × Durasi jam
   - Contoh: Rp 50.000 × 2 jam = Rp 100.000

5. **Klik "PESAN SEKARANG"**
   - Sistem akan validasi input
   - Check conflict booking (apakah sudah ada yang booking saat itu)
   - Jika OK, pemesanan dibuat

6. **Halaman Konfirmasi:**
   - Berhasil membuat pemesanan
   - ID booking muncul
   - Tombol "Bayar" untuk lanjut pembayaran

---

## 📝 FITUR 3: LIHAT RIWAYAT PEMESANAN

### ✅ Langkah-langkah:

1. **Klik menu "Pemesanan Saya"** (atau buka `/bookings`)

2. **Halaman akan menampilkan tabel dengan kolom:**
   ```
   Meja | Tanggal | Waktu | Durasi | Total | Status | Pembayaran | Aksi
   ```

3. **Status Pemesanan:**
   - 🟡 **Pending** - Belum dibayar
   - 🟢 **Confirmed** - Sudah dibayar
   - 🔴 **Cancelled** - Dibatalkan
   - ⚫ **Completed** - Selesai

4. **Setiap baris ada tombol:**
   - **"Lihat Detail"** - Lihat informasi lengkap
   - **"Bayar"** - Jika status pending
   - **"Batal"** - Untuk membatalkan (jika belum bayar)

5. **Klik "Lihat Detail":**
   - Halaman menampilkan detail lengkap booking
   - Termasuk info meja, waktu, harga
   - Status pembayaran
   - Tombol untuk aksi (Bayar, Batal, etc)

---

## 💳 FITUR 4: PEMBAYARAN

### ✅ Langkah-langkah:

1. **Klik tombol "Bayar"** dari:
   - Halaman detail booking, atau
   - Halaman list pemesanan

2. **Halaman Pembayaran akan terbuka:**
   ```
   [Detail Billing]
   - Meja: ...
   - Tanggal: ...
   - Durasi: ... jam
   - Total: Rp ...
   
   [Pilih Metode Pembayaran]
   ◯ Transfer Bank
   ◯ Kartu Kredit
   ◯ E-Wallet
   ◯ Tunai
   
   [LANJUTKAN PEMBAYARAN] button
   ```

3. **Pilih Metode Pembayaran (4 opsi):**
   
   - **Transfer Bank**
     - Kirim ke rekening yang ditampilkan
     - Konfirmasi dengan bukti transfer
   
   - **Kartu Kredit**
     - Isikan detail kartu
     - 3D Secure verification
   
   - **E-Wallet**
     - Pilih provider (GCash, OVO, GoPay, etc)
     - Redirect ke app
   
   - **Tunai**
     - Langsung bayar saat menjemput kunci meja
     - Tanda terima fisik

4. **Klik "LANJUTKAN PEMBAYARAN"**

5. **Setelah Pembayaran Sukses:**
   - Sistem redirect ke halaman receipt/kwitansi
   - Status berubah menjadi "Confirmed"
   - Email konfirmasi dikirim (jika email setup)

---

## 🧾 FITUR 5: LIHAT KWITANSI

### ✅ Langkah-langkah:

1. **Klik menu "Pembayaran"** (atau buka `/payments`)

2. **Halaman Riwayat Pembayaran:**
   ```
   Tabel dengan kolom:
   ID Transaksi | Meja | Tanggal | Jumlah | Metode | Status | Tgl Bayar | Aksi
   ```

3. **Setiap baris bisa:**
   - **"Lihat Kwitansi"** - Buka/print digital receipt
   - **"Download PDF"** - Unduh sebagai file PDF

4. **Halaman Kwitansi menampilkan:**
   ```
   ┌─────────────────────────────────────┐
   │     KWITANSI PEMBAYARAN BILLIARD    │
   ├─────────────────────────────────────┤
   │ ID Transaksi: #001                  │
   │ Tanggal: 23 Jan 2026                │
   │                                     │
   │ DETAIL BOOKING:                     │
   │ Meja: Premium 1                     │
   │ Tanggal: 23 Jan 2026                │
   │ Waktu: 14:00 - 16:00                │
   │ Durasi: 2 jam                       │
   │                                     │
   │ DETAIL PEMBAYARAN:                  │
   │ Subtotal: Rp 100.000                │
   │ Total: Rp 100.000                   │
   │ Status: Lunas ✓                     │
   │ Metode: Transfer Bank               │
   │                                     │
   │ [PRINT] [DOWNLOAD PDF] buttons      │
   └─────────────────────────────────────┘
   ```

5. **Untuk Print:**
   - Klik tombol "PRINT"
   - Browser print dialog muncul
   - Pilih printer atau "Save as PDF"
   - Selesai!

---

## ⚙️ MENU TAMBAHAN

### 👤 Menu Profil
- Lihat informasi user
- Update password
- Logout

### 🚪 Logout
- Untuk keluar dari sistem
- Klik Logout
- Kembali ke halaman login

---

## 🔍 RESPONSIVE DESIGN

Website bekerja di:

### 📱 Mobile (Smartphone)
- Ukuran: < 768px
- Layout: Stack vertikal
- Optimized untuk sentuhan

### 📱 Tablet
- Ukuran: 768px - 1024px
- Layout: Flexible
- Touch-friendly

### 💻 Desktop
- Ukuran: > 1024px
- Layout: Full width
- Mouse-friendly

**Cobalah resize browser untuk lihat responsive design!**

---

## ✅ CHECKLIST FITUR YANG BISA DICOBA

Setelah login, coba semua fitur ini:

- [ ] Lihat daftar 5 meja
- [ ] Lihat harga masing-masing meja
- [ ] Pesan meja dengan form lengkap
- [ ] Lihat auto-calculation harga
- [ ] Lihat notifikasi sukses booking
- [ ] Lihat riwayat pemesanan
- [ ] Lihat status pemesanan (pending/confirmed)
- [ ] Klik detail booking
- [ ] Proses pembayaran dengan metode
- [ ] Lihat halaman kwitansi
- [ ] Print kwitansi
- [ ] Lihat payment history
- [ ] Test responsive di mobile/tablet
- [ ] Logout dan login ulang

---

## 🎯 CONTOH WORKFLOW LENGKAP

### Skenario: Pesan Meja Premium 1 untuk 2 jam besok

**Step 1: Login**
```
Email: test@example.com
Password: password
↓ Klik Login
```

**Step 2: Lihat Daftar Meja**
```
Klik "Daftar Meja"
↓ Lihat Meja Premium 1 (Rp 50.000/jam)
```

**Step 3: Mulai Booking**
```
Klik "Pesan Sekarang" pada Meja Premium 1
```

**Step 4: Isi Form Booking**
```
Pilih Meja: Meja Premium 1
Tanggal: 24 Jan 2026 (besok)
Jam Mulai: 14:00
Durasi: 2 jam
Catatan: (kosong / isi sesuai kebutuhan)

Ringkasan otomatis:
Meja: Meja Premium 1
Tanggal: 24 Jan 2026
Jam: 14:00 - 16:00
Durasi: 2 jam
Total: Rp 100.000
↓ Klik "PESAN SEKARANG"
```

**Step 5: Konfirmasi Booking**
```
Booking berhasil dibuat!
ID: #123
Status: Pending (belum bayar)
↓ Klik "BAYAR"
```

**Step 6: Pilih Metode Pembayaran**
```
Pilih: Transfer Bank
(atau pilihan lain sesuai preferensi)
↓ Klik "LANJUTKAN PEMBAYARAN"
```

**Step 7: Pembayaran Berhasil**
```
Halaman Kwitansi muncul
Status: Paid ✓
↓ Klik "PRINT KWITANSI"
```

**Step 8: Print Kwitansi**
```
Dialog print browser muncul
Pilih printer atau Save as PDF
↓ Selesai!
```

---

## 🎨 TAMPILAN UI

### Warna Utama
- **Purple-Blue**: #667eea (Primary action)
- **Dark Purple**: #764ba2 (Hover state)
- **Green**: #51cf66 (Success)
- **Red**: #ff6b6b (Danger/Error)

### Font
- Header: Bold, 24-32px
- Body: Regular, 14-16px
- Small text: 12px

### Layout
- Navbar di atas dengan logo
- Main content di tengah
- Footer di bawah
- Full responsive

---

## 🔐 KEAMANAN

Website sudah aman dengan:
- ✅ CSRF Protection
- ✅ Password Hashing
- ✅ Input Validation
- ✅ User Authorization
- ✅ Session Security

Jangan share akun Anda dengan orang lain!

---

## 💡 TIPS PENGGUNAAN

1. **Gunakan Meja yang Tersedia**
   - Sistem cegah double-booking
   - Jika sudah penuh, tidak bisa pesan

2. **Tentukan Waktu dengan Tepat**
   - Minimal besok
   - Gunakan format 24 jam
   - Durasi 1-12 jam

3. **Simpan Kwitansi**
   - Print setiap kali pembayaran
   - Gunakan sebagai bukti pembayaran

4. **Hubungi Support**
   - Jika ada error/masalah
   - Cek TROUBLESHOOTING.md
   - Atau check browser console (F12)

---

## 📞 PERLU BANTUAN?

1. **Setup Error**: Baca `QUICKSTART.md`
2. **Fitur Error**: Baca `TROUBLESHOOTING.md`
3. **API Info**: Baca `API_DOCUMENTATION.md`
4. **Referensi Cepat**: Baca `QUICK_REFERENCE.md`

---

**Selamat menikmati Billiard Management System!** 🎉
