@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')
    <div style="max-width: 600px; margin: 0 auto;">
        <h2>Proses Pembayaran</h2>

        @if($payment)
        <div class="card">
            <h3>Detail Tagihan</h3>
            
            <div class="summary">
                <div class="summary-item">
                    <span><strong>Meja:</strong></span>
                    <span>{{ $booking->table?->table_name ?? 'Meja tidak ditemukan' }}</span>
                </div>
                <div class="summary-item">
                    <span><strong>Tanggal Pesanan:</strong></span>
                    <span>{{ $booking->booking_date?->format('d F Y') ?? 'Tanggal tidak ada' }}</span>
                </div>
                <div class="summary-item">
                    <span><strong>Waktu:</strong></span>
                    <span>{{ $booking->start_time ?? '-' }} - {{ $booking->end_time ?? '-' }}</span>
                </div>
                <div class="summary-item">
                    <span><strong>Durasi:</strong></span>
                    <span>{{ $booking->duration_hours ?? '-' }} jam</span>
                </div>
                <div class="summary-total">
                    <span><strong>Total Pembayaran:</strong></span>
                    <span>Rp {{ number_format($payment->amount ?? 0, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
        @else
        <div class="card" style="background: #fee; padding: 1.5rem; text-align: center;">
            <p style="color: #c33; margin: 0;"><strong>Kesalahan: Pembayaran tidak ditemukan</strong></p>
            @if($booking ?? false)
                <a href="{{ route('bookings.show', $booking->id) }}" style="display: inline-block; margin-top: 1rem;" class="btn btn-primary">Kembali ke Pesanan</a>
            @else
                <a href="{{ route('bookings.index') }}" style="display: inline-block; margin-top: 1rem;" class="btn btn-primary">Kembali ke Pesanan Saya</a>
            @endif
        </div>
        @endif

        @if($payment)
            <h3>Pilih Metode Pembayaran</h3>
            
            <form method="POST" action="{{ route('payments.process', $booking?->id ?? 0) }}">
                @csrf
                
                <div class="form-group">
                    <label>Metode Pembayaran</label>
                    <link href="https://example.com/styles.css">
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <label style="display: flex; align-items: center; border: 1px solid #ddd; padding: 1rem; border-radius: 5px; cursor: pointer; transition: all 0.3s;">
                            <input type="radio" name="payment_method" value="transfer_bank" required>
                            <img src="{{ asset('images/images.jpg') }}" alt="Transfer Bank" style="margin-left: 1rem; width: 50px; height: 50px; flex-shrink: 0;">
                            <span style="margin-left: 1rem;">
                                <strong>Transfer Bank</strong>
                                <p style="margin: 0; color: #666; font-size: 0.9rem;">Transfer ke rekening bank kami</p>
                            </span>
                        </label>

                        <label style="display: flex; align-items: center; border: 1px solid #ddd; padding: 1rem; border-radius: 5px; cursor: pointer; transition: all 0.3s;">
                            <input type="radio" name="payment_method" value="credit_card" required>
                            <img src="{{ asset('images/blackcard.webp') }}" alt="Kartu Kredit" style="margin-left: 1rem; width: 50px; height: 50px; flex-shrink: 0;">
                            <span style="margin-left: 1rem;">
                                <strong>Kartu Kredit</strong>
                                <p style="margin: 0; color: #666; font-size: 0.9rem;">Visa, Mastercard, American Express</p>
                            </span>
                        </label>

                        <label style="display: flex; align-items: center; border: 1px solid #ddd; padding: 1rem; border-radius: 5px; cursor: pointer; transition: all 0.3s;">
                            <input type="radio" name="payment_method" value="e_wallet" required>
                            <img src="{{ asset('images/images.png') }}" alt="E-Wallet" style="margin-left: 1rem; width: 50px; height: 50px; flex-shrink: 0;">
                            <span style="margin-left: 1rem;">
                                <strong>E-Wallet</strong>
                                <p style="margin: 0; color: #666; font-size: 0.9rem;">GCash, PayMaya, OVO, DANA</p>
                            </span>
                        </label>

                        <label style="display: flex; align-items: center; border: 1px solid #ddd; padding: 1rem; border-radius: 5px; cursor: pointer; transition: all 0.3s;">
                            <input type="radio" name="payment_method" value="cash" required>
                            <img src="{{ asset('images/tl.jpg') }}" alt="Tunai" style="margin-left: 1rem; width: 50px; height: 50px; flex-shrink: 0;">
                            <span style="margin-left: 1rem;">
                                <strong>Tunai</strong>
                                <p style="margin: 0; color: #666; font-size: 0.9rem;">Pembayaran saat kedatangan</p>
                            </span>
                        </label>
                    </div>
                </div>

                <div style="background: #f0f4ff; padding: 1rem; border-radius: 5px; margin-top: 1rem;">
                    <p style="margin: 0; color: #667eea;"><strong>⚠️ Catatan Penting:</strong></p>
                    <p style="margin: 0.5rem 0 0 0; color: #666;">Pastikan Anda memilih metode pembayaran yang sesuai. Pembayaran harus dikonfirmasi sebelum jam pesanan dimulai.</p>
                </div>

                <button type="submit" class="btn btn-success" style="width: 100%; margin-top: 1.5rem; padding: 1rem;">Lanjutkan Pembayaran</button>
                <a href="{{ route('bookings.show', $booking?->id ?? 0) }}" class="btn" style="width: 100%; margin-top: 1rem; padding: 1rem; text-align: center; background: #999;">Kembali</a>
            </form>
        @endif
    </div>
@endsection
