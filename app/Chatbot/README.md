# Chatbot PT Digital Raya Fokus

Chatbot berbasis web menggunakan algoritma pencocokan pola dan natural language processing untuk layanan informasi digital pada PT Digital Raya Fokus.

## Struktur Direktori

```
app/Chatbot/
├── ChatbotService.php           # Service PHP untuk pattern matching sederhana
├── PythonChatbotService.php     # Service PHP untuk integrasi dengan Python API
├── README.md                    # Dokumentasi (file ini)
├── docker-compose.yml           # Konfigurasi Docker untuk menjalankan Python API
└── python/                      # Direktori untuk kode Python
    ├── app.py                   # API Flask 
    ├── chatbot.py               # Implementasi chatbot dengan pattern matching
    ├── nlp_processor.py         # Processor NLP menggunakan spaCy dan NLTK
    ├── Dockerfile               # Dockerfile untuk image Python
    └── gunicorn_config.py       # Konfigurasi Gunicorn
```

## Fitur

1. **Pattern Matching Sederhana**
   - Implementasi pattern matching menggunakan regular expression
   - Pencocokan pola dalam Bahasa Indonesia
   - Fallback ke respons default jika tidak ada pola yang cocok

2. **Natural Language Processing**
   - Preprocessing teks: tokenisasi, stopword removal, stemming
   - Ekstraksi entitas menggunakan spaCy
   - Analisis sentimen sederhana
   - Ekstraksi kata kunci dari input pengguna

3. **Integrasi PHP-Python**
   - REST API menggunakan Flask
   - Komunikasi antar layanan melalui HTTP
   - Fallback ke PHP jika layanan Python tidak tersedia

4. **Penyimpanan Riwayat Percakapan**
   - Menyimpan riwayat percakapan ke database
   - Menggunakan session ID untuk mengelompokkan percakapan
   - Dapat melihat riwayat percakapan pada panel admin

5. **Dashboard Admin**
   - Statistik penggunaan chatbot
   - Grafik analisis sentimen
   - Manajemen riwayat percakapan

6. **Widget Chatbot**
   - Tombol floating di kanan bawah halaman
   - Dapat dikustomisasi warna dan pesan sambutan
   - Responsif untuk berbagai ukuran layar

## Cara Menjalankan

### 1. Instalasi Dependensi PHP

Pastikan Laravel sudah terinstall dengan benar dan tambahkan ChatbotServiceProvider ke dalam `config/app.php`.

### 2. Jalankan Migrasi Database

```bash
php artisan migrate
```

### 3. Instalasi Dependensi Python

```bash
cd app/Chatbot/python
pip install -r ../../../python_requirements.txt
python -m spacy download id_core_news_sm  # Model bahasa Indonesia untuk spaCy
```

### 4. Menjalankan API Python

```bash
cd app/Chatbot/python
gunicorn -c gunicorn_config.py app:app
```

Atau menggunakan Docker:

```bash
cd app/Chatbot
docker-compose up -d
```

### 5. Konfigurasi .env

Tambahkan konfigurasi berikut di file `.env`:

```
PYTHON_CHATBOT_API_URL=http://localhost:5000
```

### 6. Akses Chatbot

Chatbot akan muncul otomatis sebagai ikon di kanan bawah pada semua halaman yang menggunakan layout utama.

## Penggunaan Widget Chatbot

Widget chatbot dapat dikustomisasi dengan mudah. Untuk menambahkan widget ke halaman, tambahkan kode berikut:

```php
<x-chatbot-widget 
    buttonColor="#008080"
    headerColor="#008080"
    headerText="Chat dengan PT Digital Raya Fokus"
    welcomeMessage="Halo! Selamat datang di PT Digital Raya Fokus. Ada yang bisa saya bantu?"
/>
```

Parameter yang tersedia:

| Parameter | Deskripsi | Default |
|-----------|-----------|---------|
| buttonColor | Warna tombol dan pesan pengguna | #007bff |
| headerColor | Warna header chatbot | #007bff |
| headerText | Teks pada header chatbot | Chat dengan Digital Raya Fokus |
| welcomeMessage | Pesan sambutan awal dari chatbot | Halo! Selamat datang di Digital Raya Fokus. Ada yang bisa saya bantu? |

## Pengembangan Lanjutan

### Menambahkan Pattern dan Response Baru

Untuk menambahkan pola dan respons baru, Anda dapat mengedit file `app/Chatbot/python/chatbot.py` dan menambahkan pola serta respons pada metode `initialize_patterns()`.

### Integrasi dengan NLP Lanjutan

Untuk meningkatkan kemampuan NLP, Anda dapat mengintegrasikan dengan model machine learning seperti BERT atau menggunakan layanan cloud seperti Dialogflow atau Amazon Lex.

### Penyesuaian UI

Anda dapat menyesuaikan tampilan chatbot dengan mengedit file CSS di `public/css/chatbot-widget.css`. 