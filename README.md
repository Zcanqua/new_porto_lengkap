# Tutorial Konfigurasi File .env
File `.env` digunakan untuk mengatur konfigurasi aplikasi YJ Store, termasuk koneksi database dan pengaturan lingkungan aplikasi.

### 1. Siapkan File .env
Pastikan file `.env` tersedia di direktori utama project Laravel. Jika belum tersedia, salin file `.env.example` dan ubah namanya menjadi `.env`.

### 2. Konfigurasi Database
Sesuaikan pengaturan database berikut dengan informasi database yang digunakan:

env
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=username_database
DB_PASSWORD=password_database


Ganti `nama_database`, `username_database`, dan `password_database` sesuai konfigurasi database masing-masing.

### 3. Konfigurasi Aplikasi
Atur informasi dasar aplikasi:

env
APP_NAME="portofolio"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://websitekamu.com

### 4. Simpan Konfigurasi
Simpan perubahan pada file `.env`, kemudian pastikan seluruh konfigurasi sudah sesuai dengan lingkungan hosting yang digunakan.

### 5. Keamanan
Jangan membagikan file `.env` kepada orang lain karena file ini berisi informasi sensitif, seperti kredensial database dan konfigurasi aplikasi.

**Penting:**
File `.env` merupakan konfigurasi internal aplikasi Laravel dan bukan file yang perlu diisi oleh pengunjung website. Pengunjung cukup menggunakan website kamu melalui browser tanpa mengubah konfigurasi tersebut.