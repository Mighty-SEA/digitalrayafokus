import re
import random
import json
import os
from collections import defaultdict

# Kelas untuk chatbot dengan pattern matching
class PatternMatchingChatbot:
    def __init__(self):
        self.patterns = defaultdict(list)
        self.responses = defaultdict(list)
        self.initialize_patterns()
    
    def initialize_patterns(self):
        # Pola sapaan
        self.patterns['greetings'] = [
            r'\b(?:halo|hai|hi|hello|hey)\b',
            r'\bselamat\s+(?:pagi|siang|sore|malam)\b',
            r'\bpermisi\b',
        ]
        
        self.responses['greetings'] = [
            'Halo! Ada yang bisa saya bantu tentang layanan PT Digital Raya Fokus?',
            'Hai, selamat datang di layanan informasi digital PT Digital Raya Fokus. Ada yang bisa saya bantu?',
            'Selamat datang! Saya adalah chatbot PT Digital Raya Fokus. Silakan tanyakan informasi yang Anda butuhkan.',
        ]
        
        # Pola pertanyaan tentang layanan
        self.patterns['services'] = [
            r'\b(?:layanan|jasa|produk|service)\b',
            r'\bapa\s+(?:saja|yang|)\s+(?:layanan|jasa|produk|ditawarkan)\b',
        ]
        
        self.responses['services'] = [
            'PT Digital Raya Fokus menyediakan berbagai layanan digital seperti pengembangan aplikasi web, mobile, dan sistem informasi terintegrasi.',
            'Layanan kami meliputi konsultasi IT, pengembangan software, dan solusi digital untuk bisnis Anda.',
        ]
        
        # Pola pertanyaan tentang kontak
        self.patterns['contact'] = [
            r'\b(?:kontak|hubungi|telepon|email|alamat)\b',
            r'\bbagaimana\s+(?:cara|untuk|)\s+(?:menghubungi|kontak)\b',
        ]
        
        self.responses['contact'] = [
            'Anda dapat menghubungi PT Digital Raya Fokus melalui email: info@digitalrayafokus.com atau telepon: 021-XXXXXXXX.',
            'Silakan kunjungi kantor kami di Jl. Contoh No. 123, Jakarta atau hubungi kami di nomor 021-XXXXXXXX.',
        ]
        
        # Pola pertanyaan tentang harga
        self.patterns['price'] = [
            r'\b(?:harga|biaya|tarif|budget|anggaran)\b',
            r'\bberapa\s+(?:harga|biaya|tarif)\b',
        ]
        
        self.responses['price'] = [
            'Harga layanan kami bervariasi tergantung kebutuhan dan kompleksitas proyek. Silakan hubungi tim sales kami untuk mendapatkan penawaran.',
            'Untuk informasi harga, silakan kirimkan detail kebutuhan Anda ke email sales@digitalrayafokus.com untuk mendapatkan penawaran terbaik.',
        ]
        
        # Pola pertanyaan tentang waktu pengerjaan
        self.patterns['timeline'] = [
            r'\b(?:lama|waktu|durasi|timeline)\s+(?:pengerjaan|kerja|project|proyek)\b',
            r'\bberapa\s+(?:lama|waktu)\b',
        ]
        
        self.responses['timeline'] = [
            'Waktu pengerjaan proyek tergantung pada kompleksitas dan ruang lingkup. Proyek sederhana bisa selesai dalam 2-4 minggu, sedangkan proyek besar bisa memakan waktu beberapa bulan.',
            'Kami akan memberikan estimasi waktu pengerjaan setelah melakukan analisis kebutuhan. Silakan hubungi tim kami untuk konsultasi lebih lanjut.',
        ]
        
        # Pola pertanyaan tentang portofolio
        self.patterns['portfolio'] = [
            r'\b(?:portofolio|portfolio|contoh|hasil|kerja|klien|client)\b',
            r'\bsiapa\s+(?:saja|)\s+(?:klien|client)\b',
        ]
        
        self.responses['portfolio'] = [
            'Kami telah bekerja sama dengan berbagai perusahaan dari berbagai industri. Anda dapat melihat portofolio kami di website resmi digitalrayafokus.com/portofolio.',
            'Portofolio kami mencakup proyek-proyek untuk perusahaan besar seperti ABC Corp, XYZ Inc, dan banyak lagi. Silakan kunjungi website kami untuk informasi lebih detail.',
        ]
        
        # Pola default jika tidak ada yang cocok
        self.patterns['default'] = [r'.']
        self.responses['default'] = [
            'Maaf, saya belum memahami pertanyaan Anda. Bisa disampaikan dengan cara lain?',
            'Saya masih belajar untuk memahami pertanyaan Anda. Coba tanyakan dengan cara berbeda.',
            'Mohon maaf, saya tidak mengerti pertanyaan Anda. Silakan hubungi customer service kami untuk bantuan lebih lanjut.',
        ]
    
    def process_input(self, user_input):
        # Normalisasi input
        user_input = user_input.lower().strip()
        
        # Cek pola yang cocok
        for intent, pattern_list in self.patterns.items():
            if intent == 'default':
                continue  # Lewati pola default dulu
            
            for pattern in pattern_list:
                if re.search(pattern, user_input, re.IGNORECASE):
                    # Ambil respons acak dari kategori yang cocok
                    return random.choice(self.responses[intent])
        
        # Jika tidak ada yang cocok, berikan respons default
        return random.choice(self.responses['default'])
    
    def add_pattern_responses(self, intent, patterns, responses):
        self.patterns[intent].extend(patterns)
        self.responses[intent].extend(responses)

# Fungsi untuk digunakan oleh API
def get_response(user_input):
    chatbot = PatternMatchingChatbot()
    return chatbot.process_input(user_input)

# Untuk testing
if __name__ == "__main__":
    chatbot = PatternMatchingChatbot()
    print("Chatbot PT Digital Raya Fokus siap membantu Anda!")
    print("Ketik 'keluar' untuk mengakhiri percakapan.")
    
    while True:
        user_input = input("Anda: ")
        if user_input.lower() == 'keluar':
            print("Chatbot: Terima kasih telah menggunakan layanan kami. Sampai jumpa!")
            break
        
        response = chatbot.process_input(user_input)
        print(f"Chatbot: {response}") 