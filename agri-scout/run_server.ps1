$env:PATH = "C:\oracle\instantclient_23_26;C:\xampp\php;" + $env:PATH
Set-Location -Path "c:\Users\MSI\Documents\GitHub\agri-scout"
Write-Host "Starting AgriScout server on http://127.0.0.1:8000 with Oracle & MongoDB support..."
& "C:\xampp\php\php.exe" -S 127.0.0.1:8000 -t public vendor/laravel/framework/src/Illuminate/Foundation/resources/server.php
