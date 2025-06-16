import spacy
import nltk
from nltk.tokenize import word_tokenize
from nltk.corpus import stopwords
from nltk.stem import PorterStemmer
import re
import numpy as np
import os
import logging

# Konfigurasi logging
logging.basicConfig(level=logging.INFO, 
                    format='%(asctime)s - %(name)s - %(levelname)s - %(message)s')
logger = logging.getLogger(__name__)

# Download NLTK data yang diperlukan
try:
    nltk.data.find('tokenizers/punkt')
except LookupError:
    nltk.download('punkt')

try:
    nltk.data.find('corpora/stopwords')
except LookupError:
    nltk.download('stopwords')

# Stopwords bahasa Indonesia tambahan
indonesian_stopwords = [
    'yang', 'di', 'dan', 'ke', 'pada', 'untuk', 'dari', 'dalam', 'dengan', 
    'adalah', 'ini', 'itu', 'atau', 'juga', 'saya', 'kamu', 'kami', 'mereka',
    'dia', 'nya', 'anda', 'ada', 'akan', 'tidak', 'bisa', 'sudah', 'jika',
    'jadi', 'oleh', 'karena', 'secara', 'ketika', 'maka', 'hanya', 'tentang'
]

# Load model spaCy untuk bahasa Indonesia
# Catatan: Perlu diinstal dengan command: python -m spacy download id_core_news_sm
logger.info("Loading spaCy model...")
try:
    nlp = spacy.load("id_core_news_sm")
    logger.info("Loaded Indonesian spaCy model")
except OSError:
    try:
        # Fallback ke model bahasa Inggris jika model bahasa Indonesia tidak tersedia
        nlp = spacy.load("en_core_web_sm")
        logger.info("Loaded English spaCy model (fallback)")
    except OSError:
        # Jika tidak ada model yang terinstall, gunakan blank model
        logger.warning("No spaCy model found, using blank model")
        nlp = spacy.blank("id")  # Blank model untuk bahasa Indonesia

class NLPProcessor:
    def __init__(self):
        self.nlp = nlp
        self.stemmer = PorterStemmer()
        
        # Kombinasi stopwords Bahasa Indonesia dan Inggris
        try:
            english_stopwords = stopwords.words('english')
            try:
                indo_stopwords = stopwords.words('indonesian')
            except:
                indo_stopwords = indonesian_stopwords
                
            self.stop_words = set(indo_stopwords + english_stopwords)
        except:
            # Jika terjadi error, gunakan stopwords default
            self.stop_words = set(indonesian_stopwords)
            
        logger.info(f"NLP Processor initialized with {len(self.stop_words)} stopwords")
    
    def preprocess_text(self, text):
        """
        Melakukan preprocessing pada teks input:
        - Mengubah ke lowercase
        - Menghapus karakter khusus
        - Tokenisasi
        - Menghapus stopwords
        - Stemming
        """
        # Mengubah ke lowercase dan menghapus karakter khusus
        text = text.lower()
        text = re.sub(r'[^\w\s]', '', text)
        
        # Tokenisasi
        tokens = word_tokenize(text)
        
        # Menghapus stopwords
        filtered_tokens = [token for token in tokens if token not in self.stop_words]
        
        # Stemming
        try:
            stemmed_tokens = [self.stemmer.stem(token) for token in filtered_tokens]
        except Exception as e:
            logger.error(f"Error during stemming: {str(e)}")
            stemmed_tokens = filtered_tokens
        
        return {
            'original_text': text,
            'tokens': tokens,
            'filtered_tokens': filtered_tokens,
            'stemmed_tokens': stemmed_tokens,
            'processed_text': ' '.join(stemmed_tokens)
        }
    
    def extract_entities(self, text):
        """
        Menggunakan spaCy untuk mengekstrak entitas seperti:
        - Nama orang
        - Organisasi
        - Lokasi
        - Tanggal
        - dll.
        """
        try:
            doc = self.nlp(text)
            entities = {}
            
            for ent in doc.ents:
                if ent.label_ not in entities:
                    entities[ent.label_] = []
                entities[ent.label_].append(ent.text)
            
            return entities
        except Exception as e:
            logger.error(f"Error during entity extraction: {str(e)}")
            return {}
    
    def analyze_sentiment(self, text):
        """
        Analisis sentimen sederhana berdasarkan kata positif dan negatif
        """
        # Daftar kata positif dan negatif yang umum dalam Bahasa Indonesia
        positive_words = ['bagus', 'baik', 'senang', 'suka', 'luar biasa', 'hebat', 'keren', 
                         'mantap', 'terima kasih', 'membantu', 'puas', 'memuaskan', 'ramah']
        negative_words = ['buruk', 'jelek', 'tidak suka', 'tidak bagus', 'kecewa', 'marah', 
                         'sedih', 'lambat', 'susah', 'sulit', 'masalah', 'komplain']
        
        text = text.lower()
        tokens = word_tokenize(text)
        
        positive_count = sum(1 for token in tokens if token in positive_words)
        negative_count = sum(1 for token in tokens if token in negative_words)
        
        if positive_count > negative_count:
            return 'positive'
        elif negative_count > positive_count:
            return 'negative'
        else:
            return 'neutral'
    
    def get_keywords(self, text, num_keywords=5):
        """
        Ekstraksi kata kunci dari teks
        """
        try:
            doc = self.nlp(text)
            keywords = []
            
            # Ekstrak kata benda dan kata kerja sebagai kata kunci
            for token in doc:
                if token.pos_ in ['NOUN', 'VERB'] and token.text.lower() not in self.stop_words:
                    keywords.append(token.text)
            
            # Jika tidak ada keyword yang ditemukan, ambil token terpanjang
            if not keywords:
                tokens = word_tokenize(text.lower())
                filtered_tokens = [token for token in tokens if token not in self.stop_words]
                if filtered_tokens:
                    # Urutkan berdasarkan panjang token (terpanjang dulu)
                    keywords = sorted(filtered_tokens, key=len, reverse=True)
            
            # Batasi jumlah kata kunci yang dikembalikan
            return keywords[:num_keywords]
        except Exception as e:
            logger.error(f"Error during keyword extraction: {str(e)}")
            return []
    
    def find_similar_intent(self, user_input, intents_list):
        """
        Mencari intent yang paling mirip dengan input pengguna
        """
        try:
            max_similarity = 0
            most_similar_intent = None
            
            user_doc = self.nlp(user_input.lower())
            
            for intent in intents_list:
                intent_doc = self.nlp(intent.lower())
                
                try:
                    similarity = user_doc.similarity(intent_doc)
                    
                    if similarity > max_similarity and similarity > 0.6:  # threshold 0.6
                        max_similarity = similarity
                        most_similar_intent = intent
                except Exception as e:
                    logger.warning(f"Error calculating similarity: {str(e)}")
                    continue
            
            return most_similar_intent, max_similarity
        except Exception as e:
            logger.error(f"Error during intent similarity check: {str(e)}")
            return None, 0

# Contoh penggunaan
if __name__ == "__main__":
    processor = NLPProcessor()
    
    # Test preprocessing
    text = "Halo, saya ingin mengetahui layanan apa saja yang ditawarkan oleh PT Digital Raya Fokus?"
    result = processor.preprocess_text(text)
    print("Preprocessing result:", result)
    
    # Test entity extraction
    entities = processor.extract_entities(text)
    print("Entities:", entities)
    
    # Test sentiment analysis
    sentiment = processor.analyze_sentiment(text)
    print("Sentiment:", sentiment)
    
    # Test keyword extraction
    keywords = processor.get_keywords(text)
    print("Keywords:", keywords) 