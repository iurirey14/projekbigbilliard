{{-- Menggunakan layout app.blade.php sebagai template utama --}}
@extends('layouts.app')

{{-- Menetapkan judul halaman sebagai "Login" --}}
@section('title', 'Login')

{{-- Bagian konten utama halaman --}}
@section('content')
    {{-- Container utama dengan styling responsive dan shadow effect --}}
    {{-- max-width: 400px untuk membuat lebar maksimal form --}}
    {{-- margin: 3rem auto untuk memusatkan container secara horizontal --}}
    {{-- padding: 2rem untuk ruang internal container --}}
    {{-- background: white untuk warna latar belakang putih --}}
    {{-- border-radius: 8px untuk sudut melengkung --}}
    {{-- box-shadow untuk efek bayangan 3D --}}
    <div style="max-width: 400px; margin: 3rem auto; padding: 2rem; background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
        {{-- Judul halaman login dengan styling center dan spacing --}}
        <h1 style="text-align: center; margin-bottom: 2rem; color: #333;">Login</h1>
        
        {{-- Menampilkan pesan error jika ada validasi yang gagal --}}
        {{-- $errors->any() mengecek apakah ada error dari validasi form --}}
        @if ($errors->any())
            {{-- Container error dengan styling warna merah muda untuk indikasi error --}}
            {{-- background: #fee adalah warna latar merah muda yang lembut --}}
            {{-- color: #c33 adalah warna teks merah gelap untuk kontras yang jelas --}}
            <div style="background: #fee; padding: 1rem; border-radius: 4px; margin-bottom: 1rem; color: #c33;">
                {{-- Loop melalui semua pesan error dan tampilkan satu per satu --}}
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        
        {{-- Form POST untuk submit data login ke route 'login.post' --}}
        {{-- method="POST" mengirim data secara aman ke server --}}
        {{-- action="{{ route('login.post') }}" mengeset destinasi form ke endpoint login --}}
        {{-- display: flex; flex-direction: column membuat input fields tersusun vertikal --}}
        {{-- gap: 1rem memberikan jarak antar elemen form --}}
        <form method="POST" action="{{ route('login.post') }}" style="display: flex; flex-direction: column; gap: 1rem;">
            {{-- @csrf adalah token keamanan Laravel untuk melindungi dari CSRF attack --}}
            @csrf
            
            {{-- Div container untuk field email dengan spacing vertical --}}
            <div>
                {{-- Label untuk input email dengan styling custom --}}
                {{-- display: block membuat label full width --}}
                {{-- font-weight: 500 membuat teks label sedikit tebal --}}
                <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Email</label>
                {{-- Input field email untuk menerima input email pengguna --}}
                {{-- type="email" melakukan validasi format email secara otomatis browser --}}
                {{-- name="email" adalah nama field yang dikirim ke server --}}
                {{-- value="{{ old('email') }}" mempertahankan nilai email jika ada error validasi (flash data) --}}
                {{-- required memastikan field email harus diisi sebelum submit --}}
                {{-- width: 100% membuat input full width sesuai container --}}
                {{-- padding: 0.75rem memberikan ruang internal dalam input --}}
                {{-- border: 1px solid #ddd membuat border abu-abu tipis --}}
                {{-- border-radius: 4px membuat sudut input sedikit melengkung --}}
                {{-- font-size: 1rem mengatur ukuran font sama dengan ukuran default --}}
                <input type="email" name="email" value="{{ old('email') }}" required 
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
            </div>
            
            {{-- Div container untuk field password dengan spacing vertical --}}
            <div>
                {{-- Label untuk input password dengan styling yang sama seperti email --}}
                <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Password</label>
                {{-- Input field password untuk menerima input password pengguna --}}
                {{-- type="password" menyembunyikan karakter yang diketik untuk keamanan --}}
                {{-- name="password" adalah nama field yang dikirim ke server --}}
                {{-- required memastikan field password harus diisi sebelum submit --}}
                {{-- tidak menggunakan old() untuk password karena alasan keamanan tidak boleh disimpan di server --}}
                {{-- Styling sama seperti field email untuk konsistensi UI --}}
                <input type="password" name="password" required 
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
            </div>
            
            {{-- Tombol submit untuk mengirim form login --}}
            {{-- type="submit" membuat button berfungsi untuk submit form --}}
            {{-- padding: 0.75rem memberikan ruang internal tombol --}}
            {{-- background: #667eea adalah warna biru ungu untuk tombol --}}
            {{-- color: white membuat teks tombol berwarna putih untuk kontras --}}
            {{-- border: none menghilangkan border default tombol --}}
            {{-- border-radius: 4px membuat sudut tombol sedikit melengkung --}}
            {{-- cursor: pointer mengubah kursor menjadi pointer saat hover tombol --}}
            {{-- font-weight: 500 membuat teks tombol lebih tebal dan terlihat --}}
            {{-- font-size: 1rem mengatur ukuran font tombol --}}
            <button type="submit" style="padding: 0.75rem; background: #667eea; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: 500; font-size: 1rem;">
                Login
            </button>
        </form>
        
        {{-- Paragraph untuk menampilkan link registrasi bagi pengguna yang belum punya akun --}}
        {{-- text-align: center memusatkan teks secara horizontal --}}
        {{-- margin-top: 1.5rem memberikan ruang di atas paragraph --}}
        {{-- color: #666 adalah warna teks abu-abu gelap untuk tampilan lembut --}}
        <p style="text-align: center; margin-top: 1.5rem; color: #666;">
            {{-- Teks statis "Belum punya akun?" --}}
            Belum punya akun? 
            {{-- Link ke halaman registrasi menggunakan route helper --}}
            {{-- route('register') menghasilkan URL ke halaman registrasi --}}
            {{-- color: #667eea membuat link berwarna biru ungu (warna tema) --}}
            {{-- text-decoration: none menghilangkan underline default link --}}
            {{-- font-weight: 500 membuat teks link terlihat lebih menonjol --}}
            <a href="{{ route('register') }}" style="color: #667eea; text-decoration: none; font-weight: 500;">Daftar di sini</a>
        </p>
    </div>
{{-- Akhir dari section content --}}
@endsection
