# 🔧 Troubleshooting Guide

## Common Issues & Solutions

---

## 🔴 Installation Issues

### Issue 1: "No application encryption key has been specified"
**Error Message:**
```
RuntimeException : No application encryption key has been specified.
```

**Solution:**
```bash
php artisan key:generate
```

Make sure `.env` file exists and has `APP_KEY=base64:...`

---

### Issue 2: "Class 'Illuminate\...' not found"
**Error Message:**
```
Fatal error: Uncaught Error: Class not found
```

**Solution:**
```bash
composer dump-autoload
composer install
```

---

### Issue 3: "SQLSTATE[HY000]: General error: 1030 Got error..."
**Error Message:**
```
SQLSTATE[HY000]: General error: 1030 Got error
```

**Solution:**
```bash
php artisan migrate:refresh
php artisan migrate
php artisan db:seed
```

---

### Issue 4: Port 8000 Already in Use
**Error Message:**
```
Address already in use
```

**Solution:**
```bash
# Option 1: Use different port
php artisan serve --port=8001

# Option 2: Kill process on port 8000 (Windows PowerShell)
netstat -ano | findstr :8000
taskkill /PID [PID] /F
```

---

### Issue 5: Database Connection Failed
**Error Message:**
```
SQLSTATE[HY000] [2002] Connection refused
```

**Solutions:**
1. Check MySQL is running (XAMPP Control Panel)
2. Verify database name in `.env`
3. Verify username and password in `.env`
4. Check host is correct (127.0.0.1 or localhost)

---

## 🔴 Database Issues

### Issue 6: Migration Fails
**Solution:**
```bash
# Check migration status
php artisan migrate:status

# Rollback last migration
php artisan migrate:rollback

# Fresh migration (WARNING: Deletes data!)
php artisan migrate:fresh
php artisan db:seed
```

---

### Issue 7: "Table doesn't exist" after migrate
**Solution:**
```bash
# Check tables were created
php artisan tinker
>>> DB::select('SHOW TABLES');

# If tables missing, run again
php artisan migrate
```

---

### Issue 8: Seeding Fails
**Error Message:**
```
Class not found in seeder
```

**Solution:**
```bash
# Check class names match exactly
composer dump-autoload

# Run seeder again
php artisan db:seed
php artisan db:seed --class=BilliardTableSeeder
```

---

## 🔴 Authentication Issues

### Issue 9: Cannot Login
**Solution:**
1. Check user exists in database:
   ```bash
   php artisan tinker
   >>> App\Models\User::all();
   ```

2. Verify password:
   ```bash
   >>> App\Models\User::first()->password;
   ```

3. Reset user password:
   ```bash
   >>> $user = App\Models\User::first();
   >>> $user->password = bcrypt('password');
   >>> $user->save();
   ```

---

### Issue 10: Logout Not Working
**Solution:**
1. Check session driver in `.env`:
   ```env
   SESSION_DRIVER=database
   ```

2. Check sessions table exists:
   ```bash
   php artisan migrate
   ```

3. Clear session:
   ```bash
   php artisan cache:clear
   ```

---

## 🔴 Payment Issues

### Issue 11: Payment Status Not Updating
**Solution:**
1. Check payment record exists:
   ```bash
   php artisan tinker
   >>> App\Models\Payment::all();
   ```

2. Verify booking_id is correct
3. Check payment status enum in database
4. Manually update for testing:
   ```bash
   >>> $payment = App\Models\Payment::first();
   >>> $payment->status = 'completed';
   >>> $payment->save();
   ```

---

### Issue 12: Cannot Create Booking
**Solution:**
1. Check table exists:
   ```bash
   >>> App\Models\BilliardTable::all();
   ```

2. Check user is authenticated
3. Verify booking date is in future
4. Check for conflicting bookings:
   ```bash
   >>> App\Models\Booking::where('table_id', 1)->get();
   ```

---

## 🔴 Frontend Issues

### Issue 13: Styles Not Loading
**Solution:**
```bash
# Rebuild assets
npm run build

# For development
npm run dev

# Clear browser cache (Ctrl+Shift+Delete)
```

---

### Issue 14: JavaScript Not Working
**Error:**
```
Uncaught SyntaxError in console
```

**Solution:**
```bash
# Check syntax
node -c resources/js/billiard.js

# Rebuild
npm run build

# Check for console errors (F12)
```

---

### Issue 15: Images Not Showing
**Solution:**
1. Check image path in view
2. Ensure images in `public/` directory
3. Clear browser cache
4. Check file permissions

---

## 🔴 Performance Issues

### Issue 16: Slow Page Load
**Solution:**
1. Check N+1 query problem:
   ```php
   // Bad
   foreach($bookings as $booking) {
       echo $booking->user->name;  // Query per loop
   }
   
   // Good
   $bookings = Booking::with('user')->get();
   ```

2. Enable query caching
3. Optimize database indexes
4. Use asset minification

---

### Issue 17: High Memory Usage
**Solution:**
```bash
# Check memory limit in php.ini
php -i | grep memory_limit

# Increase if needed
# memory_limit = 256M

# Or set in .env
PHP_MEMORY_LIMIT=256M
```

---

## 🔴 Booking Validation Issues

### Issue 18: Cannot Book Future Date
**Reason:** Date validation requires future dates

**Solution:**
- Select date after tomorrow (minimum 1 day in future)
- Check your system date is correct

---

### Issue 19: Booking Time Conflict Not Detected
**Solution:**
1. Check overlapping bookings logic
2. Verify booking_date format (YYYY-MM-DD)
3. Verify time format (HH:MM)
4. Check status filter (exclude 'cancelled')

---

## 🔴 Email/Notification Issues

### Issue 20: Emails Not Sending
**Setup:**
```env
MAIL_MAILER=log
MAIL_FROM_ADDRESS=noreply@billiard.com
MAIL_FROM_NAME="Billiard Management"
```

Check logs in `storage/logs/`

---

## 🟡 Warning Issues

### Issue 21: "Trying to access property on null"
**Solution:**
```php
// Bad
echo $booking->payment->amount;

// Good
echo optional($booking->payment)->amount;
// Or
echo $booking->payment?->amount ?? 0;
```

---

### Issue 22: "Undefined variable"
**Solution:**
- Check variable is passed from controller to view
- Verify @php variable declaration if needed
- Check variable name spelling

---

## 🟡 Deprecation Warnings

### Issue 23: Laravel Deprecation Warnings
**Solution:**
```bash
# Update Laravel and dependencies
composer update

# Check for deprecations
php artisan tinker
>>> echo \Laravel\Framework\VERSION;
```

---

## 🔵 General Maintenance

### Clear All Caches
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

---

### Fresh Start (Development Only)
```bash
# ⚠️ WARNING: This deletes all data!
php artisan migrate:fresh --seed
```

---

### Check Application Health
```bash
php artisan tinker
>>> health_check()
>>> DB::connection()->getPdo();  // Test DB connection
>>> auth()->check();              // Test auth
```

---

## 📝 Debug Tips

### Enable Debug Mode
In `.env`:
```env
APP_DEBUG=true
```

### View Debug Bar (if installed)
Should appear at bottom of page when debug=true

### Check Logs
```bash
tail -f storage/logs/laravel.log
```

### Use Tinker REPL
```bash
php artisan tinker
>>> App\Models\Booking::latest()->first();
>>> auth()->id();
>>> DB::getQueryLog();
```

---

## 🆘 Still Need Help?

1. Check `.env` file configuration
2. Review error logs in `storage/logs/`
3. Use `php artisan tinker` to test
4. Check Laravel documentation
5. Test with fresh installation

---

## 📞 Support Resources

- Laravel Docs: https://laravel.com/docs
- Laravel Discord: https://discord.gg/laravel
- Stack Overflow: Tag with [laravel]
- GitHub Issues: Check repository

---

**Last Updated**: January 22, 2026
