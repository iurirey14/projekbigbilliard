# 📡 Billiard Management System - API Documentation

## Base URL
```
http://localhost:8000/api
```

## Authentication
Semua endpoint memerlukan user login. Gunakan Laravel session atau bearer token.

---

## 🎱 Billiard Tables API

### 1. Get All Tables
```
GET /tables
```

**Response (200 OK)**
```json
{
    "data": [
        {
            "id": 1,
            "table_name": "Meja Premium 1",
            "table_number": 1,
            "description": "Meja billiard premium dengan cahaya LED",
            "status": "available",
            "price_per_hour": 50000,
            "created_at": "2026-01-22T10:00:00Z",
            "updated_at": "2026-01-22T10:00:00Z"
        }
    ]
}
```

### 2. Get Single Table
```
GET /tables/{id}
```

**Parameters**
- `id` (integer) - Table ID

**Response (200 OK)**
```json
{
    "data": {
        "id": 1,
        "table_name": "Meja Premium 1",
        "table_number": 1,
        "description": "Meja billiard premium dengan cahaya LED",
        "status": "available",
        "price_per_hour": 50000,
        "bookings": [
            {
                "id": 1,
                "booking_date": "2026-01-22",
                "start_time": "10:00",
                "end_time": "12:00"
            }
        ]
    }
}
```

### 3. Check Available Tables
```
GET /api/available-tables?date=2026-01-25&start_time=14:00&end_time=16:00
```

**Query Parameters**
- `date` (string, required) - Format: YYYY-MM-DD
- `start_time` (string, required) - Format: HH:MM
- `end_time` (string, required) - Format: HH:MM

**Response (200 OK)**
```json
{
    "data": [
        {
            "id": 1,
            "table_name": "Meja Premium 1",
            "status": "available",
            "price_per_hour": 50000
        },
        {
            "id": 3,
            "table_name": "Meja Standard 1",
            "status": "available",
            "price_per_hour": 30000
        }
    ]
}
```

---

## 📋 Bookings API

### 1. Get All User Bookings
```
GET /bookings
```

**Response (200 OK)**
```json
{
    "data": [
        {
            "id": 1,
            "table_id": 1,
            "table": {
                "id": 1,
                "table_name": "Meja Premium 1"
            },
            "booking_date": "2026-01-25",
            "start_time": "14:00",
            "end_time": "16:00",
            "duration_hours": 2,
            "total_price": 100000,
            "status": "confirmed",
            "notes": "Untuk acara kantor",
            "payment": {
                "id": 1,
                "status": "completed"
            },
            "created_at": "2026-01-22T10:00:00Z"
        }
    ]
}
```

### 2. Create New Booking
```
POST /bookings
```

**Request Body**
```json
{
    "table_id": 1,
    "booking_date": "2026-01-25",
    "start_time": "14:00",
    "duration_hours": 2,
    "notes": "Untuk acara kantor"
}
```

**Validation Rules**
- `table_id` (required, integer) - Must exist in billiard_tables
- `booking_date` (required, date) - Must be after today
- `start_time` (required, time format HH:MM)
- `duration_hours` (required, integer) - 1-12
- `notes` (optional, string max 500)

**Response (201 Created)**
```json
{
    "data": {
        "id": 1,
        "table_id": 1,
        "user_id": 1,
        "booking_date": "2026-01-25",
        "start_time": "14:00",
        "end_time": "16:00",
        "duration_hours": 2,
        "total_price": 100000,
        "status": "pending",
        "created_at": "2026-01-22T10:00:00Z"
    },
    "message": "Booking berhasil dibuat. Lanjutkan ke pembayaran."
}
```

**Error Response (422 Unprocessable Entity)**
```json
{
    "error": "Waktu booking tidak tersedia untuk meja ini."
}
```

### 3. Get Booking Detail
```
GET /bookings/{id}
```

**Parameters**
- `id` (integer) - Booking ID

**Response (200 OK)**
```json
{
    "data": {
        "id": 1,
        "table_id": 1,
        "user_id": 1,
        "booking_date": "2026-01-25",
        "start_time": "14:00",
        "end_time": "16:00",
        "duration_hours": 2,
        "total_price": 100000,
        "status": "confirmed",
        "notes": "Untuk acara kantor",
        "table": {
            "id": 1,
            "table_name": "Meja Premium 1",
            "price_per_hour": 50000
        },
        "payment": {
            "id": 1,
            "amount": 100000,
            "status": "completed",
            "payment_method": "transfer_bank",
            "transaction_id": "TXN-123456",
            "paid_at": "2026-01-22T10:30:00Z"
        }
    }
}
```

### 4. Cancel Booking
```
POST /bookings/{id}/cancel
```

**Parameters**
- `id` (integer) - Booking ID

**Response (200 OK)**
```json
{
    "message": "Booking berhasil dibatalkan."
}
```

**Error Response (403 Forbidden)**
```json
{
    "error": "Tidak bisa membatalkan booking yang sudah selesai."
}
```

---

## 💳 Payments API

### 1. Get Payment Page
```
GET /payments/{bookingId}
```

**Parameters**
- `bookingId` (integer) - Booking ID

**Response (200 OK)**
- Returns payment form page with booking details

### 2. Process Payment
```
POST /payments/{bookingId}/process
```

**Parameters**
- `bookingId` (integer) - Booking ID

**Request Body**
```json
{
    "payment_method": "transfer_bank"
}
```

**Validation Rules**
- `payment_method` (required, enum) - Values: transfer_bank, credit_card, cash, e_wallet

**Response (200 OK)**
```json
{
    "data": {
        "id": 1,
        "booking_id": 1,
        "amount": 100000,
        "status": "completed",
        "payment_method": "transfer_bank",
        "transaction_id": "TXN-1234567890",
        "paid_at": "2026-01-22T10:30:00Z"
    },
    "message": "Pembayaran berhasil! Booking Anda telah dikonfirmasi."
}
```

### 3. Get Payment History
```
GET /payments
```

**Response (200 OK)**
```json
{
    "data": [
        {
            "id": 1,
            "booking_id": 1,
            "amount": 100000,
            "status": "completed",
            "payment_method": "transfer_bank",
            "transaction_id": "TXN-123456",
            "booking": {
                "id": 1,
                "booking_date": "2026-01-25",
                "table": {
                    "id": 1,
                    "table_name": "Meja Premium 1"
                }
            },
            "paid_at": "2026-01-22T10:30:00Z",
            "created_at": "2026-01-22T10:00:00Z"
        }
    ]
}
```

### 4. Get Payment Receipt
```
GET /payments/{bookingId}/receipt
```

**Parameters**
- `bookingId` (integer) - Booking ID

**Response (200 OK)**
- Returns receipt page (printable)

---

## 🔑 Response Status Codes

| Code | Meaning | Description |
|------|---------|-------------|
| 200 | OK | Request successful |
| 201 | Created | Resource created successfully |
| 400 | Bad Request | Invalid request format |
| 403 | Forbidden | User not authorized |
| 404 | Not Found | Resource not found |
| 422 | Unprocessable Entity | Validation failed |
| 500 | Server Error | Internal server error |

---

## 📊 Data Types

### Booking Status
- `pending` - Menunggu pembayaran
- `confirmed` - Sudah dibayar
- `cancelled` - Dibatalkan oleh user
- `completed` - Selesai

### Payment Status
- `pending` - Menunggu pembayaran
- `completed` - Pembayaran sukses
- `failed` - Pembayaran gagal
- `refunded` - Refund diterima

### Table Status
- `available` - Tersedia
- `booked` - Sudah dipesan
- `maintenance` - Dalam perawatan

### Payment Methods
- `transfer_bank` - Transfer Bank
- `credit_card` - Kartu Kredit
- `e_wallet` - E-Wallet (DANA, OVO, dll)
- `cash` - Tunai

---

## ⏱️ Rate Limiting

- Maksimal 60 requests per menit per user

---

## 🔐 Error Handling

Semua error response mengikuti format:

```json
{
    "error": "Error message",
    "validation_errors": {
        "field_name": ["error message"]
    }
}
```

---

## 💡 Tips

1. **Date Format**: Selalu gunakan format `YYYY-MM-DD` untuk tanggal
2. **Time Format**: Gunakan format `HH:MM` (24 jam) untuk waktu
3. **Currency**: Semua harga dalam Rupiah (IDR)
4. **Timezone**: Gunakan timezone lokal user

---

## 📝 Example Integration

### Contoh Booking Flow
```javascript
// 1. Check Available Tables
fetch('/api/available-tables?date=2026-01-25&start_time=14:00&end_time=16:00')
  .then(r => r.json())
  .then(data => console.log(data));

// 2. Create Booking
fetch('/bookings', {
  method: 'POST',
  body: JSON.stringify({
    table_id: 1,
    booking_date: '2026-01-25',
    start_time: '14:00',
    duration_hours: 2,
    notes: 'Untuk acara kantor'
  })
})
.then(r => r.json())
.then(data => window.location.href = `/payments/${data.data.id}`);

// 3. Process Payment
fetch('/payments/1/process', {
  method: 'POST',
  body: JSON.stringify({
    payment_method: 'transfer_bank'
  })
})
.then(r => r.json())
.then(data => console.log('Payment Success:', data));
```

---

**API Version**: v1.0  
**Last Updated**: 2026-01-22
