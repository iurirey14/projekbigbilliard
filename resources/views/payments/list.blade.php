@extends('layouts.app')

@section('title', 'Daftar Pembayaran')

@section('content')
    <h2 style="margin-bottom: 2rem;">Riwayat Pembayaran</h2>

    @if($payments->count() > 0)
        <div style="overflow-x: auto;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nomor Transaksi</th>
                        <th>Meja</th>
                        <th>Tanggal Pesanan</th>
                        <th>Jumlah</th>
                        <th>Metode</th>
                        <th>Status</th>
                        <th>Tanggal Pembayaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                        <tr>
                            <td>{{ $payment->transaction_id ?? '-' }}</td>
                            <td>{{ $payment->booking && $payment->booking->table ? $payment->booking->table->table_name : '-' }}</td>
                            <td>{{ $payment->booking ? $payment->booking->booking_date->format('d/m/Y') : '-' }}</td>
                            <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                            <td>{{ $payment->payment_method ? ucfirst(str_replace('_', ' ', $payment->payment_method)) : '-' }}</td>
                            <td>
                                <span class="badge badge-{{ str_replace('_', '-', $payment->status) }}">
                                    {{ ucfirst(str_replace('_', ' ', $payment->status)) }}
                                </span>
                            </td>
                            <td>{{ $payment->paid_at ? $payment->paid_at->format('d/m/Y H:i') : '-' }}</td>
                            <td>
                                @if($payment->status === 'completed')
                                    <a href="{{ route('payments.receipt', $payment->booking->id) }}" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.9rem;">Kwitansi</a>
                                @else
                                    <a href="{{ route('payments.show', $payment->booking->id) }}" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.9rem;">Bayar</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="card">
            <p>Anda belum melakukan pembayaran. <a href="{{ route('bookings.create') }}">Pesan meja sekarang</a></p>
        </div>
    @endif

    <a href="{{ route('bookings.index') }}" class="btn btn-primary" style="margin-top: 2rem;">Kembali ke Pesanan</a>
@endsection
