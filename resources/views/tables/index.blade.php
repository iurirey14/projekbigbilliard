@extends('layouts.app')

@section('title', 'Daftar Meja Billiard')

@section('content')
    <h2 style="margin-bottom: 2rem;">Daftar Meja Billiard</h2>
    
    <div class="grid">
        @forelse($tables as $table)
            <div class="table-card">
                <h3>{{ $table->table_name }}</h3>
                <p><strong>Nomor Meja:</strong> {{ $table->table_number }}</p>
                <p><strong>Status:</strong> <span class="status-{{ $table->status }}">{{ ucfirst($table->status) }}</span></p>
                @if($table->description)
                    <p><strong>Deskripsi:</strong> {{ $table->description }}</p>
                @endif
                <div class="price">Rp {{ number_format($table->price_per_hour, 0, ',', '.') }}/jam</div>
                @if($table->status === 'available')
                    <a href="{{ route('bookings.create') }}?table_id={{ $table->id }}" class="btn btn-primary" style="margin-top: 1rem;">Pesan Sekarang</a>
                @else
                    <button class="btn btn-primary" disabled style="margin-top: 1rem; opacity: 0.5;">Tidak Tersedia</button>
                @endif
            </div>
        @empty
            <div class="card">
                <p>Belum ada meja billiard yang tersedia.</p>
            </div>
        @endforelse
    </div>
@endsection
