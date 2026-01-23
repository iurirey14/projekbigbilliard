@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
    <div style="text-align: center; padding: 3rem 1rem;">
        <h1 style="font-size: 2.5rem; margin-bottom: 1rem; color: #333;">
            Selamat Datang di Billiard Management
        </h1>
        
        <p style="font-size: 1.1rem; color: #666; margin-bottom: 2rem; max-width: 600px; margin-left: auto; margin-right: auto;">
            Sistem Manajemen Pemesanan Meja Billiard yang Modern dan Mudah Digunakan
        </p>
        
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; max-width: 600px; margin-left: auto; margin-right: auto;">
            @auth
                <a href="{{ route('tables.index') }}" style="padding: 0.75rem 1.5rem; background: #667eea; color: white; text-decoration: none; border-radius: 0.25rem; display: inline-block; font-weight: 500;">
                    📋 Lihat Meja
                </a>
                
                <a href="{{ route('bookings.index') }}" style="padding: 0.75rem 1.5rem; background: #764ba2; color: white; text-decoration: none; border-radius: 0.25rem; display: inline-block; font-weight: 500;">
                    📝 Pemesanan Saya
                </a>
                
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" style="padding: 0.75rem 1.5rem; background: #ff6b6b; color: white; border: none; border-radius: 0.25rem; cursor: pointer; font-weight: 500;">
                        🚪 Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" style="padding: 0.75rem 1.5rem; background: #667eea; color: white; text-decoration: none; border-radius: 0.25rem; display: inline-block; font-weight: 500;">
                    🔑 Login
                </a>
                
                <a href="{{ route('register') }}" style="padding: 0.75rem 1.5rem; background: #764ba2; color: white; text-decoration: none; border-radius: 0.25rem; display: inline-block; font-weight: 500;">
                    ✍️ Register
                </a>
            @endauth
        </div>

        @if (!auth()->check())
            <div style="margin-top: 3rem; padding: 1.5rem; background: #f0f0f0; border-radius: 0.5rem; max-width: 500px; margin-left: auto; margin-right: auto;">
                <p style="color: #666; margin-bottom: 1rem;">
                    <strong>Demo Account:</strong>
                </p>
                <p style="color: #666; margin: 0.5rem 0;">
                    Email: <code style="background: white; padding: 0.25rem 0.5rem; border-radius: 3px;">test@example.com</code>
                </p>
                <p style="color: #666; margin: 0.5rem 0;">
                    Password: <code style="background: white; padding: 0.25rem 0.5rem; border-radius: 3px;">password</code>
                </p>
            </div>
        @endif
    </div>
@endsection
