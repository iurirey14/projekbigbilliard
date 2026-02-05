<?php

/**
 * ============================================================================
 * AuthController - Controller untuk mengelola autentikasi pengguna
 * ============================================================================
 * Controller ini bertanggung jawab atas:
 * - Proses login pengguna
 * - Proses registrasi pengguna baru
 * - Proses logout pengguna
 * ============================================================================
 */

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * login - Fungsi untuk menangani proses login pengguna
     * @param Request $request - Object request dari form login
     * @return \Illuminate\Http\RedirectResponse - Redirect ke halaman tables atau kembali ke login dengan error
     * 
     * Proses:
     * 1. Validasi input email dan password dari form
     * 2. Coba autentikasi dengan email dan password
     * 3. Jika berhasil, regenerate session dan redirect ke halaman tables
     * 4. Jika gagal, kembali ke form dengan pesan error
     */
    public function login(Request $request)
    {
        // Validasi input dari form login
        // email: harus ada dan format email valid
        // password: harus ada
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Coba autentikasi dengan menggunakan email dan password yang dikirim
        // Auth::attempt() mencocokan credentials dengan database
        if (Auth::attempt($credentials)) {
            // Jika autentikasi berhasil, regenerate session untuk keamanan
            $request->session()->regenerate();
            // Redirect ke halaman tables (dashboard billiard)
            return redirect('/tables')->with('success', 'Login berhasil!');
        }

        // Jika autentikasi gagal, kembali ke halaman login dengan error
        // withErrors() menampilkan pesan error di halaman login
        // onlyInput() hanya mempertahankan field email (password tidak disimpan untuk keamanan)
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * register - Fungsi untuk menangani proses registrasi pengguna baru
     * @param Request $request - Object request dari form register
     * @return \Illuminate\Http\RedirectResponse - Redirect ke halaman tables atau kembali ke register dengan error
     * 
     * Proses:
     * 1. Validasi input name, email (harus unique), dan password (min 8 char, harus match)
     * 2. Hash password untuk keamanan
     * 3. Buat user baru di database
     * 4. Login otomatis ke user yang baru dibuat
     * 5. Redirect ke halaman tables
     */
    public function register(Request $request)
    {
        // Validasi input dari form register
        // name: harus ada, string, max 255 karakter
        // email: harus ada, format email, dan unique di tabel users (tidak boleh duplikat)
        // password: harus ada, minimal 8 karakter, dan harus match dengan password_confirmation
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        // Buat user baru
        // Hash::make() mengenkripsi password untuk keamanan
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Login otomatis ke user yang baru dibuat
        Auth::login($user);
        // Redirect ke halaman tables (dashboard)
        return redirect('/tables')->with('success', 'Registrasi berhasil!');
    }

    /**
     * logout - Fungsi untuk menangani proses logout pengguna
     * @param Request $request - Object request
     * @return \Illuminate\Http\RedirectResponse - Redirect ke halaman home
     * 
     * Proses:
     * 1. Logout user dari sistem
     * 2. Invalidate session (hapus semua session data)
     * 3. Regenerate token CSRF untuk keamanan
     * 4. Redirect ke halaman home
     */
    public function logout(Request $request)
    {
        // Logout user dari sistem
        Auth::logout();
        // Invalidate session - menghapus semua data session pengguna
        $request->session()->invalidate();
        // Regenerate CSRF token untuk keamanan
        $request->session()->regenerateToken();
        // Redirect ke halaman home
        return redirect('/');
    }
}
