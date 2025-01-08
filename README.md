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

- 🏗️ `app/`: Kode aplikasi utama
- 🎨 `resources/views/`: Template tampilan
- 🗄️ `database/migrations/`: File migrasi database
- 🌱 `database/seeders/`: File seeder untuk mengisi data awal
- 📂 `public/`: Aset publik
- 🛣️ `routes/`: Definisi rute aplikasi

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
