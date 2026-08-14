@echo off
set PATH=C:\oracle\instantclient_23_26;C:\xampp\php;%PATH%
echo Starting AgriScout Laravel Server on http://127.0.0.1:8000 with Oracle & MongoDB support...
"C:\xampp\php\php.exe" -c "C:\xampp\php\php.ini" artisan serve --host=127.0.0.1 --port=8000
