@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')
    <div style="max-width: 600px; margin: 0 auto;">
        <h2>Proses Pembayaran</h2>

        <div class="card">
            <h3>Detail Tagihan</h3>
            
            <div class="summary">
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
                <div class="summary-total">
                    <span><strong>Total Pembayaran:</strong></span>
                    <span>Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="card" style="margin-top: 2rem;">
            <h3>Pilih Metode Pembayaran</h3>
            
            <form method="POST" action="{{ route('payments.process', $booking->id) }}">
                @csrf
                
                <div class="form-group">
                    <label>Metode Pembayaran</label>
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <label style="display: flex; align-items: center; border: 1px solid #ddd; padding: 1rem; border-radius: 5px; cursor: pointer;">
                            <input type="radio" name="payment_method" value="transfer_bank" required>
                            <span style="margin-left: 1rem;">
                                <strong>Transfer Bank</strong>
                                <p style="margin: 0; color: #666; font-size: 0.9rem;">Transfer ke rekening bank kami</p>
                            </span>
                        </label>

                        <label style="display: flex; align-items: center; border: 1px solid #ddd; padding: 1rem; border-radius: 5px; cursor: pointer;">
                            <input type="radio" name="payment_method" value="credit_card" required>
                            <span style="margin-left: 1rem;">
                                <strong>Kartu Kredit</strong>
                                <p style="margin: 0; color: #666; font-size: 0.9rem;">Visa, Mastercard, American Express</p>
                            </span>
                        </label>

                        <label style="display: flex; align-items: center; border: 1px solid #ddd; padding: 1rem; border-radius: 5px; cursor: pointer;">
                            <input type="radio" name="payment_method" value="e_wallet" required>
                            <span style="margin-left: 1rem;">
                                <strong>E-Wallet</strong>
                                <p style="margin: 0; color: #666; font-size: 0.9rem;">GCash, PayMaya, OVO, DANA</p>
                            </span>
                        </label>

                        <label style="display: flex; align-items: center; border: 1px solid #ddd; padding: 1rem; border-radius: 5px; cursor: pointer;">
                            <input type="radio" name="payment_method" value="cash" required>
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
                <a href="{{ route('bookings.show', $booking->id) }}" class="btn" style="width: 100%; margin-top: 1rem; padding: 1rem; text-align: center; background: #999;">Kembali</a>
            </form>
        </div>
    </div>
@endsection
