@echo off
set PATH=C:\app\Nadun\product\21c\dbhomeXE\bin;C:\xampp\php;%PATH%
echo Running AdminSeeder with Oracle database support...
C:\xampp\php\php.exe artisan db:seed --class=AdminSeeder
