@echo off
REM Test script untuk Queue:Work -> Send Mail

echo.
echo ========================================
echo ^|  Queue:Work TEST - Send Mail  ^|
echo ========================================
echo.

REM Get current directory
cd /d d:\xampp\htdocs\TTCK\bai8

echo [1] Checking servers...
echo.

REM Check if Laravel server is running
echo Checking Laravel server (http://localhost:8000)...
curl -s http://localhost:8000 >nul 2>&1
if %errorlevel% equ 0 (
    echo     OK: Server running
) else (
    echo     ERROR: Server not running!
    echo     Run: php artisan serve
    exit /b 1
)

echo.
echo [2] Checking database connection...
echo.
d:\xampp\mysql\bin\mysql.exe -u root ttck_bai8 -e "SELECT 'Database Connected' as status;" 2>nul
if %errorlevel% neq 0 (
    echo     ERROR: Database not connected!
    exit /b 1
)

echo.
echo [3] Current job statistics...
echo.
d:\xampp\mysql\bin\mysql.exe -u root ttck_bai8 -e "SELECT status, COUNT(*) as count FROM job_logs GROUP BY status;"

echo.
echo [4] Queue worker status...
tasklist | find /i "php.exe" >nul
if %errorlevel% equ 0 (
    echo     OK: PHP running (queue worker likely active)
) else (
    echo     WARNING: No PHP process found
    echo     Run in another terminal: php artisan queue:work --tries=3 --timeout=120
)

echo.
echo ========================================
echo     SYSTEM READY FOR TESTING
echo ========================================
echo.
echo Next steps:
echo   1. Open http://localhost:8000/register in browser
echo   2. Fill form and submit
echo   3. Watch queue worker process job
echo   4. Check dashboard: http://localhost:8000/dashboard
echo.
echo Or run: php test_queue_dispatch.php
echo.
pause
