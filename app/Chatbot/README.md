# Sistem Chatbot Digital Raya Fokus

Sistem chatbot ini dikembangkan sebagai bagian dari skripsi dengan judul "RANCANG BANGUN SISTEM CHATBOT BERBASIS WEB MENGGUNAKAN ALGORITMA PENCOCOKAN POLA DAN NATURAL LANGUAGE PROCESSING UNTUK LAYANAN INFORMASI DIGITAL PADA PT DIGITAL RAYA FOKUS".

## Fitur Utama

- **Pattern Matching**: Memanfaatkan algoritma pencocokan pola (regex) untuk merespons pertanyaan umum
- **Pemrosesan Bahasa Alami Sederhana**: Implementasi sederhana untuk ekstraksi kata kunci dan analisis sentimen
- **Knowledge Base**: Sistem basis pengetahuan yang dapat dikelola melalui admin panel
- **Widget Web**: Widget chatbot yang dapat diintegrasikan dengan mudah di website
- **Mode Debug**: Fitur debugging untuk membantu pengembangan dan analisis (tekan Ctrl+Shift+D saat chatbot aktif)

## Struktur Direktori

```
app/Chatbot/
└── ChatbotService.php            # Service PHP untuk pattern matching dan NLP sederhana
```

## Mengintegrasikan Chatbot Widget

Tambahkan kode berikut di dalam blade template Anda:

```php
<x-chatbot-widget 
    buttonColor="#007bff" 
    headerColor="#007bff" 
    headerText="Chat dengan Digital Raya Fokus"
    welcomeMessage="Halo! Selamat datang di Digital Raya Fokus. Ada yang bisa saya bantu?"
/>
```

## Tutorial Mengelola FAQ Chatbot

### 1. Akses Admin Panel

1. Login ke admin panel Filament (URL: `/admin` atau `/dashboard`)
2. Masukkan username dan password admin Anda
3. Di sidebar kiri, cari menu **"Chatbot FAQ"** dan klik

### 2. Menambahkan FAQ Baru

1. Di halaman Chatbot FAQ, klik tombol **"Create Chatbot FAQ"** atau **"New Chatbot FAQ"** di pojok kanan atas
2. Form tambah FAQ akan terbuka dengan field-field berikut:

#### Detail Formulir FAQ:

| Field | Keterangan | Contoh |
|-------|------------|--------|
| **Question** | Pertanyaan yang mungkin ditanyakan pengguna | "Apa saja layanan Digital Raya Fokus?" |
| **Answer** | Jawaban yang akan diberikan chatbot | "PT Digital Raya Fokus menyediakan layanan pengembangan web, aplikasi mobile, dan sistem informasi terintegrasi." |
| **Keywords** | Kata kunci untuk membantu pencocokan (pisahkan dengan koma) | "layanan, jasa, produk, digital" |
| **Category** | Kategori pertanyaan untuk pengelompokan | "layanan" atau "produk" |
| **Is Active** | Toggle/switch untuk mengaktifkan FAQ | Aktifkan (ON) |
| **Priority** | Angka prioritas, semakin tinggi semakin diprioritaskan | 10 |

3. Setelah mengisi semua field, klik tombol **"Create"** atau **"Save"** di bagian bawah form

### 3. Mengedit FAQ yang Sudah Ada

1. Di halaman daftar FAQ, cari FAQ yang ingin diubah
2. Klik tombol **Edit** (biasanya ikon pensil) di kolom Actions di sebelah kanan
3. Lakukan perubahan pada field yang ingin diubah
4. Klik tombol **"Save"** untuk menyimpan perubahan

### 4. Menghapus FAQ

1. Di halaman daftar FAQ, cari FAQ yang ingin dihapus
2. Klik tombol **Delete** (biasanya ikon tempat sampah) di kolom Actions
3. Konfirmasi penghapusan pada dialog yang muncul

### 5. Tips Membuat FAQ yang Efektif

- **Gunakan pertanyaan umum**: Tuliskan pertanyaan seperti yang akan ditanyakan pengguna
- **Tambahkan keywords**: Semakin banyak keywords relevan, semakin mudah chatbot mengenali pertanyaan
- **Tentukan prioritas**: Berikan prioritas lebih tinggi untuk FAQ yang lebih penting
- **Kategori yang jelas**: Gunakan kategori konsisten untuk memudahkan pengelolaan
- **Jawaban ringkas**: Berikan jawaban yang informatif tapi tetap ringkas

### 6. Pengujian FAQ

Setelah menambahkan FAQ baru:
1. Buka website yang memiliki widget chatbot
2. Ajukan pertanyaan yang serupa dengan FAQ yang baru ditambahkan
3. Chatbot akan otomatis memberikan jawaban yang telah diatur

## Mode Debug

Untuk mengaktifkan mode debug:
1. Buka chatbot widget
2. Tekan `Ctrl+Shift+D`
3. Refresh halaman
4. Sekarang chatbot akan menampilkan informasi NLP tambahan

## Analisis Sentimen

Sistem ini menganalisis sentimen dari pesan pengguna dan menyimpannya dalam database. Data ini dapat dilihat melalui admin panel untuk analisis lebih lanjut.

## Teknologi

Sistem chatbot ini hanya menggunakan PHP dan Laravel, tanpa memerlukan layanan eksternal atau dependensi tambahan. Ini membuatnya sangat mudah di-deploy dan diintegrasikan ke dalam aplikasi web yang sudah ada. 