# 📊 Sistem Manajemen Faktur

> Solusi manajemen faktur modern untuk PT. Digital Raya Fokus, dibangun dengan Laravel & Filament Admin Panel untuk pengalaman pengguna yang optimal.

## ✨ Fitur Unggulan

### 💼 Manajemen Faktur
- ⚡️ Buat & edit faktur secara instan dengan UI yang intuitif
- 🌏 Dukungan multi-mata uang (IDR & USD) 
- 📄 Ekspor ke PDF dengan satu klik

### 👥 Manajemen Pelanggan
- 🔍 Pencarian & filter pelanggan yang powerful
- 📊 Analisis riwayat transaksi komprehensif
- 💫 Database pelanggan yang terorganisir

### 📝 Manajemen Item
- 🧮 Kalkulasi otomatis harga & total
- ➕ Fitur repeater yang fleksibel
- 📦 Pengelolaan item yang efisien

### 💰 Fitur Keuangan
- 💱 Konversi mata uang real-time
- 📈 Laporan keuangan detail
- 🎯 Analisis bisnis mendalam

### 📤 Ekspor & Pelaporan
- 📊 Ekspor ke PDF & Excel
- 📧 Sistem email terintegrasi
- 📑 Dokumentasi yang rapi

### 📊 Dasbor & Analitik
- 📈 Visualisasi data yang informatif
- 📉 Analisis tren penjualan
- 🎯 Insights bisnis yang akurat

## 🛠 Tech Stack

### Backend
- 🚀 Laravel 11
- ⚡️ PHP 8.2
- 🗄 MySQL

### Frontend
- 🎨 Tailwind CSS
- ⚡️ Livewire
- 🔄 Alpine.js

### Packages
- 📄 barryvdh/laravel-dompdf
- 🔔 filament/notifications
- 🎨 hasnayeen/themes

## 🚀 Panduan Penggunaan

### Membuat Faktur Baru
1. 📂 Akses menu Faktur
2. ➕ Klik "Buat Faktur Baru"
3. ✍️ Isi informasi pelanggan & item
4. 💾 Pilih mata uang & simpan

### Pengiriman Faktur
- 📧 Kirim faktur individual/massal
- ✨ Template email yang customizable

## 🔄 Alur Kerja

1. 🔐 **Login**: Autentikasi pengguna
2. 👥 **Kelola Pelanggan**: CRUD operasi
3. 📝 **Buat Faktur**:
   - 👤 Pilih pelanggan
   - 📦 Tambah item
   - 💰 Set mata uang
4. 📤 **Ekspor**: Generate PDF
5. 📧 **Kirim**: Email ke pelanggan
6. 📊 **Analisis**: Review statistik

## 📁 Struktur Aplikasi

- 🏗️ `app/`: Kode aplikasi utama, termasuk model, controller, dan resource.
  - `Filament/Resources/`: Resource untuk Filament, seperti `InvoiceResource`.
    - `Actions/`: Tindakan khusus untuk resource, seperti `GeneratePdfAction`.
  - `Filament/Widgets/`: Widget untuk Filament, seperti `StatsOverview`.
  - `Mail/`: Kelas untuk mengirim email, seperti `InvoiceMail`.
- 🎨 `resources/views/`: Template tampilan, termasuk file Blade untuk tampilan web.
  - `invoices/`: Template untuk faktur, seperti `pdf.blade.php` dan `send.blade.php`.
- 🗄️ `database/migrations/`: File migrasi database untuk membuat tabel.
  - `2024_11_20_080724_create_companies_table.php`: Menciptakan tabel perusahaan.
  - `2024_11_20_090713_create_customers_table.php`: Menciptakan tabel pelanggan.
  - `2024_11_20_092543_create_items_table.php`: Menciptakan tabel item.
- 🌱 `database/seeders/`: File seeder untuk mengisi data awal.
  - `CustomerSeeder.php`: Seeder untuk data pelanggan.
  - `InvoicesSeeder.php`: Seeder untuk data faktur.
- 📂 `public/`: Aset publik seperti CSS, JavaScript, dan gambar.
  - `css/`: File CSS untuk tema dan tampilan.
  - `js/`: File JavaScript untuk interaktivitas.
- 🛣️ `routes/`: Definisi rute aplikasi.
  - `web.php`: Rute untuk aplikasi web.
- 📦 `config/`: Konfigurasi aplikasi, termasuk `app.php` dan `filesystems.php`.
- 📜 `composer.json`: File konfigurasi Composer untuk dependensi PHP.
- 📜 `package.json`: File konfigurasi npm untuk dependensi JavaScript.

## 💾 Struktur Database

### 👥 Tabel Customers
Menyimpan data pelanggan
- 🔑 `id`: Primary key
- 👤 `nama`: Nama pelanggan
- 📧 `email`: Email pelanggan  
- 📱 `phone`: Nomor telepon pelanggan

### 📄 Tabel Invoices 
Menyimpan data faktur
- 🔑 `id`: Primary key
- 🔗 `customer_id`: Foreign key ke tabel customers
- 📅 `invoice_date`: Tanggal faktur
- ⏰ `due_date`: Tanggal jatuh tempo
- 💱 `is_dollar`: Indikator mata uang

### 📦 Tabel Items
Menyimpan data item dalam faktur
- 🔑 `id`: Primary key
- 🔗 `invoice_id`: Foreign key ke tabel invoices
- 📝 `name`: Nama item
- 📋 `description`: Deskripsi item
- 🔢 `quantity`: Kuantitas item
- 💰 `price_rupiah`: Harga dalam IDR
- 💵 `price_dollar`: Harga dalam USD
- 💸 `amount_rupiah`: Total harga dalam IDR
- 💲 `amount_dollar`: Total harga dalam USD
