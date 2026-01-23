@echo off
REM Billiard Management System - Automated Setup Script

echo.
echo ====================================
echo Billiard Management System Setup
echo ====================================
echo.

REM Check if .env exists
if not exist .env (
    echo Creating .env file...
    copy .env.example .env
) else (
    echo .env file already exists.
)

echo.
echo Installing dependencies...
call composer install
call npm install

echo.
echo Generating application key...
call php artisan key:generate

echo.
echo Running database migrations...
call php artisan migrate

echo.
echo Seeding database with initial data...
call php artisan db:seed

echo.
echo Building frontend assets...
call npm run build

echo.
echo ====================================
echo Setup Complete!
echo ====================================
echo.
echo You can now run: php artisan serve
echo Then visit: http://localhost:8000
echo.
echo Test User:
echo Email: test@example.com
echo Password: password
echo.
pause
