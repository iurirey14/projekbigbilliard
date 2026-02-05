@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
    <div style="max-width: 800px; margin: 0 auto;">
        <h2>Detail Pesanan</h2>

        <div class="card">
            <h3>Informasi Pesanan</h3>
            
            <div class="summary">
                <div class="summary-item">
                    <span><strong>Meja:</strong></span>
                    <span>{{ $booking->table?->table_name ?? 'Meja tidak ditemukan' }}</span>
                </div>
                <div class="summary-item">
                    <span><strong>Tanggal:</strong></span>
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
                <div class="summary-item">
                    <span><strong>Kategori:</strong></span>
                    <span><span class="badge" style="background: {{ $booking->category === 'vip' ? '#ffd700' : '#87ceeb' }}; color: #333;">{{ ucfirst($booking->category ?? 'Regular') }}</span></span>
                </div>
                <div class="summary-item">
                    <span><strong>Harga per Jam:</strong></span>
                    <span>Rp {{ number_format($booking->table?->price_per_hour ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="summary-total">
                    <span><strong>Total Harga:</strong></span>
                    <span>Rp {{ number_format($booking->total_price ?? 0, 0, ',', '.') }}</span>
                </div>
            </div>

            <div style="margin-top: 1rem;">
                <p><strong>Status Pesanan:</strong> <span class="badge badge-{{ str_replace('_', '-', $booking->status) }}">{{ ucfirst(str_replace('_', ' ', $booking->status)) }}</span></p>
                @if($booking->notes)
                    <p><strong>Catatan:</strong> {{ $booking->notes }}</p>
                @endif
            </div>
        </div>

        @if($payment ?? false)
            <div class="card" style="margin-top: 2rem;">
                <h3>Informasi Pembayaran</h3>
                
                <div class="summary">
                    <div class="summary-item">
                        <span><strong>Status Pembayaran:</strong></span>
                        <span><span class="badge badge-{{ str_replace('_', '-', $payment->status ?? 'pending') }}">{{ ucfirst(str_replace('_', ' ', $payment->status ?? 'pending')) }}</span></span>
                    </div>
                    <div class="summary-item">
                        <span><strong>Jumlah Pembayaran:</strong></span>
                        <span>Rp {{ number_format($payment->amount ?? 0, 0, ',', '.') }}</span>
                    </div>
                    @if($payment->payment_method)
                        <div class="summary-item">
                            <span><strong>Metode Pembayaran:</strong></span>
                            <span>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</span>
                        </div>
                    @endif
                    @if($payment->paid_at)
                        <div class="summary-item">
                            <span><strong>Tanggal Pembayaran:</strong></span>
                            <span>{{ $payment->paid_at?->format('d/m/Y H:i') ?? '-' }}</span>
                        </div>
                    @endif
                </div>

                @if($payment && $payment->status === 'pending')
                    <a href="{{ route('payments.show', $booking->id) }}" class="btn btn-success" style="margin-top: 1rem; display: inline-block;">Lakukan Pembayaran</a>
                @elseif($payment && $payment->status === 'completed')
                    <a href="{{ route('payments.receipt', $booking->id) }}" class="btn btn-primary" style="margin-top: 1rem; display: inline-block;">Lihat Kwitansi</a>
                @endif
            </div>
        @endif

        <div style="margin-top: 2rem;">
            @if($booking->status !== 'completed' && $booking->status !== 'cancelled')
                <form method="POST" action="{{ route('bookings.cancel', $booking->id) }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin membatalkan booking ini?');">Batalkan Pesanan</button>
                </form>
            @endif
            <a href="{{ route('bookings.index') }}" class="btn btn-primary">Kembali ke Pesanan</a>
        </div>
    </div>
@endsection
