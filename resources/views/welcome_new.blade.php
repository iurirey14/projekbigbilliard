@extends('layouts.app')

@section('title', 'Home - Billiard Management System')

@section('content')
    <div style="text-align: center; padding: 3rem 0;">
        <h1 style="font-size: 3rem; color: #667eea; margin-bottom: 1rem;">🎱 Selamat Datang di Billiard Management System</h1>
        <p style="font-size: 1.3rem; color: #666; margin-bottom: 2rem;">Pesan meja billiard favorit Anda dengan sistem pembayaran yang mudah dan aman</p>
        
        @if (Auth::check())
            <div style="display: flex; gap: 1rem; justify-content: center;">
                <a href="{{ route('tables.index') }}" class="btn btn-primary">Lihat Semua Meja</a>
                <a href="{{ route('bookings.index') }}" class="btn btn-primary">Lihat Pesanan Saya</a>
            </div>
        @else
            <div style="display: flex; gap: 1rem; justify-content: center;">
                <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Daftar</a>
            </div>
        @endif
    </div>

    @if (Auth::check())
        <div class="card">
            <h2>Informasi Terbaru</h2>
            <p>Selamat datang, <strong>{{ Auth::user()->name }}</strong>!</p>
            <p>Anda dapat memesan meja billiard kapan saja dan melakukan pembayaran dengan berbagai metode pembayaran yang tersedia.</p>
        </div>
    @endif
@endsection
