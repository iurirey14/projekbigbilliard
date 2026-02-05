# Admin & Test Account Credentials

## Akun Admin
- **Email**: admin@example.com
- **Password**: Admin123456
- **Role**: admin

## Akun Test User
- **Email**: test@example.com
- **Password**: Test123456
- **Role**: user

## Fitur Waktu yang Ditambahkan
- **last_login_at**: Mencatat waktu login terakhir user (timestamp)
- **timestamps()**: Migrasi users sudah memiliki created_at dan updated_at

## Cara Login
1. Gunakan email dan password di atas untuk login
2. Admin akan memiliki akses ke fitur administrative
3. Test user memiliki akses normal

## File yang Dimodifikasi
- `/app/Models/User.php` - Menambahkan role dan last_login_at fields + isAdmin() method
- `/database/migrations/2026_02_05_000001_add_role_to_users_table.php` - Migrasi baru untuk role dan last_login_at
- `/database/seeders/DatabaseSeeder.php` - Membuat akun admin dan test user

## Menggunakan isAdmin() di Blade/Controller
```php
@if(auth()->user()->isAdmin())
    <!-- Admin content -->
@endif
```

Atau di controller:
```php
if(auth()->user()->isAdmin()) {
    // Admin logic
}
```
