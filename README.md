# Project Daily Log Karyawan
Sistem reporting karyawan berbasis web menggunakan Laravel 8.x

## Cara setup project di local
### 1. Install vendor
- run `composer install` atau `composer update`
### 2. Config Env & Setup DB
- buat file `.env` baru dengan meng-copy file `.env.example`
- lalu ubah value dari `APP_NAME`, `DB_DATABASE` pada file `.env` sesuai dengan database yang kalian buat
- run `php artisan key:generate`
- run `composer dump-autoload`
- run `php artisan optimize`
- run `php artisan migrate:fresh --seed`
### 3. Generate APP_KEY
- run `php artisan key:generate`
### 4. Menjalankan project
- run `php artisan serve`
- kemudian buka di browser `localhost:8000` atau `127.0.0.1:8000`.
- Catatan: port `8000` bisa saja berubah. maka harap perhatikan port yang keluar di terminal
## Daftar library yang digunakan
- [spatie laravel permission](https://spatie.be/docs/laravel-permission/v4/introduction)