@extends('layouts.app')

@section('title', 'Kwitansi Pembayaran')

@section('content')
    <div style="max-width: 600px; margin: 0 auto;">
        <div class="card" style="border: 2px solid #667eea;">
            <div style="text-align: center; border-bottom: 2px solid #667eea; padding-bottom: 1.5rem; margin-bottom: 1.5rem;">
                <h1 style="color: #667eea; margin: 0;">🎱 KWITANSI PEMBAYARAN</h1>
                <p style="margin: 0; color: #666;">Billiard Management System</p>
            </div>

            <div class="summary">
                <h3 style="margin-bottom: 1rem;">Detail Transaksi</h3>
                
                <div class="summary-item">
                    <span><strong>Nomor Transaksi:</strong></span>
                    <span>{{ $booking->payment->transaction_id ?? 'N/A' }}</span>
                </div>
                <div class="summary-item">
                    <span><strong>Tanggal Pembayaran:</strong></span>
                    <span>{{ $booking->payment->paid_at ? $booking->payment->paid_at->format('d F Y H:i') : '-' }}</span>
                </div>
                <div class="summary-item">
                    <span><strong>Metode Pembayaran:</strong></span>
                    <span>{{ $booking->payment->payment_method ? ucfirst(str_replace('_', ' ', $booking->payment->payment_method)) : '-' }}</span>
                </div>
            </div>

            <div class="summary" style="margin-top: 1.5rem;">
                <h3 style="margin-bottom: 1rem;">Detail Pesanan</h3>
                
                <div class="summary-item">
                    <span><strong>Nama Pelanggan:</strong></span>
                    <span>{{ Auth::user()->name }}</span>
                </div>
                <div class="summary-item">
                    <span><strong>Email:</strong></span>
                    <span>{{ Auth::user()->email }}</span>
                </div>
                <div class="summary-item">
                    <span><strong>Meja:</strong></span>
                    <span>{{ $booking->table->table_name }}</span>
                </div>
                <div class="summary-item">
                    <span><strong>Tanggal Pesanan:</strong></span>
                    <span>{{ $booking->booking_date->format('d F Y') }}</span>
                </div>
                <div class="summary-item">
                    <span><strong>Waktu:</strong></span>
                    <span>{{ $booking->start_time }} - {{ $booking->end_time }}</span>
                </div>
                <div class="summary-item">
                    <span><strong>Durasi:</strong></span>
                    <span>{{ $booking->duration_hours }} jam</span>
                </div>
                <div class="summary-item">
                    <span><strong>Harga Per Jam:</strong></span>
                    <span>Rp {{ number_format($booking->table->price_per_hour, 0, ',', '.') }}</span>
                </div>
                <div class="summary-total">
                    <span><strong>Total Pembayaran:</strong></span>
                    <span>Rp {{ number_format($booking->payment->amount, 0, ',', '.') }}</span>
                </div>
            </div>

            <div style="background: #d4edda; padding: 1rem; border-radius: 5px; margin-top: 1.5rem; text-align: center;">
                <p style="margin: 0; color: #155724;"><strong>✓ PEMBAYARAN BERHASIL</strong></p>
                <p style="margin: 0.5rem 0 0 0; color: #155724; font-size: 0.9rem;">Pesanan Anda telah dikonfirmasi. Silakan hadir 15 menit sebelum waktu pesanan dimulai.</p>
            </div>

            <div style="margin-top: 2rem; text-align: center; padding-top: 1.5rem; border-top: 1px solid #ddd;">
                <p style="margin: 0; color: #666; font-size: 0.9rem;">Terima kasih telah menggunakan Billiard Management System</p>
                <p style="margin: 0.5rem 0 0 0; color: #999; font-size: 0.85rem;">Cetak dokumen ini untuk arsip Anda</p>
            </div>
        </div>

        <div style="margin-top: 2rem; text-align: center;">
            <button onclick="window.print()" class="btn btn-primary">Cetak Kwitansi</button>
            <a href="{{ route('bookings.index') }}" class="btn btn-primary" style="margin-left: 1rem;">Kembali ke Pesanan</a>
        </div>
    </div>

    <style>
        @media print {
            .navbar, .footer, button, a.btn {
                display: none !important;
            }
            .container {
                margin: 0 !important;
                padding: 0 !important;
            }
        }
    </style>
@endsection
