@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
    <h2 style="margin-bottom: 2rem;">Pesanan Saya</h2>

    @if($bookings->count() > 0)
        <div style="overflow-x: auto;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Meja</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Durasi</th>
                        <th>Kategori</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Pembayaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                        <tr>
                            <td>{{ $booking->table?->table_name ?? 'Meja tidak ditemukan' }}</td>
                            <td>{{ $booking->booking_date?->format('d/m/Y') ?? '-' }}</td>
                            <td>{{ $booking->start_time ?? '-' }} - {{ $booking->end_time ?? '-' }}</td>
                            <td>{{ $booking->duration_hours ?? '-' }} jam</td>
                            <td>
                                <span class="badge" style="background: {{ $booking->category === 'vip' ? '#ffd700' : '#87ceeb' }}; color: #333; padding: 0.3rem 0.8rem; border-radius: 20px;">
                                    {{ ucfirst($booking->category ?? 'Regular') }}
                                </span>
                            </td>
                            <td>Rp {{ number_format($booking->total_price ?? 0, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge badge-{{ str_replace('_', '-', $booking->status ?? 'pending') }}">
                                    {{ ucfirst(str_replace('_', ' ', $booking->status ?? 'pending')) }}
                                </span>
                            </td>
                            <td>
                                @if($booking->payment)
                                    <span class="badge badge-{{ str_replace('_', '-', $booking->payment->status) }}">
                                        {{ ucfirst(str_replace('_', ' ', $booking->payment->status)) }}
                                    </span>
                                @else
                                    <span class="badge badge-warning">Belum ada</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.9rem;">Lihat</a>
                                @if($booking->status !== 'completed' && $booking->status !== 'cancelled')
                                    <form method="POST" action="{{ route('bookings.cancel', $booking->id) }}" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-danger" style="padding: 0.5rem 1rem; font-size: 0.9rem;" onclick="return confirm('Yakin ingin membatalkan booking ini?');">Batalkan</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="card">
            <p>Anda belum memiliki pesanan. <a href="{{ route('bookings.create') }}">Pesan meja sekarang</a></p>
        </div>
    @endif

    <a href="{{ route('tables.index') }}" class="btn btn-primary" style="margin-top: 2rem;">Pesan Meja Baru</a>
@endsection
