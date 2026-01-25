@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <div style="max-width: 400px; margin: 3rem auto; padding: 2rem; background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
        <h1 style="text-align: center; margin-bottom: 2rem; color: #333;">Register</h1>
        
        @if ($errors->any())
            <div style="background: #fee; padding: 1rem; border-radius: 4px; margin-bottom: 1rem; color: #c33;">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        
        <form method="POST" action="{{ route('register.post') }}" style="display: flex; flex-direction: column; gap: 1rem;">
            @csrf
            
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Nama</label>
                <input type="text" name="name" value="{{ old('name') }}" required 
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
            </div>
            
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required 
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
            </div>
            
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Password</label>
                <input type="password" name="password" required 
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
            </div>
            
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Confirm Password</label>
                <input type="password" name="password_confirmation" required 
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
            </div>
            
            <button type="submit" style="padding: 0.75rem; background: #764ba2; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: 500; font-size: 1rem;">
                Register
            </button>
        </form>
        
        <p style="text-align: center; margin-top: 1.5rem; color: #666;">
            Sudah punya akun? <a href="{{ route('login') }}" style="color: #667eea; text-decoration: none; font-weight: 500;">Login di sini</a>
        </p>
    </div>
@endsection
