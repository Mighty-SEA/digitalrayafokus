from flask import Flask, request, jsonify
from chatbot import PatternMatchingChatbot
from nlp_processor import NLPProcessor
import os
import nltk
import json
import logging

# Konfigurasi logging
logging.basicConfig(level=logging.INFO, 
                    format='%(asctime)s - %(name)s - %(levelname)s - %(message)s')
logger = logging.getLogger(__name__)

# Download NLTK data
try:
    nltk.data.find('tokenizers/punkt')
except LookupError:
    nltk.download('punkt')

try:
    nltk.data.find('corpora/stopwords')
except LookupError:
    nltk.download('stopwords')

app = Flask(__name__)
chatbot = PatternMatchingChatbot()
nlp_processor = NLPProcessor()

@app.route('/api/chatbot', methods=['POST'])
def process_message():
    try:
        data = request.get_json()
        
        if not data or 'message' not in data:
            return jsonify({'error': 'No message provided'}), 400
        
        user_message = data['message']
        logger.info(f"Received message: {user_message}")
        
        # Preprocess message with NLP
        processed_data = nlp_processor.preprocess_text(user_message)
        logger.info(f"Preprocessed message: {processed_data['processed_text']}")
        
        # Extract entities
        entities = nlp_processor.extract_entities(user_message)
        logger.info(f"Extracted entities: {entities}")
        
        # Analyze sentiment
        sentiment = nlp_processor.analyze_sentiment(user_message)
        logger.info(f"Sentiment: {sentiment}")
        
        # Get keywords
        keywords = nlp_processor.get_keywords(user_message)
        logger.info(f"Keywords: {keywords}")
        
        # Get response from chatbot
        response = chatbot.process_input(user_message)
        logger.info(f"Response: {response}")
        
        return jsonify({
            'message': response,
            'processed_data': {
                'entities': entities,
                'sentiment': sentiment,
                'keywords': keywords,
                'tokens': processed_data['tokens'],
                'filtered_tokens': processed_data['filtered_tokens']
            }
        })
    except Exception as e:
        logger.error(f"Error processing message: {str(e)}")
        return jsonify({'error': str(e)}), 500

@app.route('/api/health', methods=['GET'])
def health_check():
    return jsonify({'status': 'ok'})

@app.route('/api/debug', methods=['GET'])
def debug_info():
    # Informasi debugging untuk membantu diagnosa masalah
    info = {
        'nltk_data_path': nltk.data.path,
        'spacy_models': list(nlp_processor.nlp.pipe_names),
        'patterns_count': sum(len(patterns) for patterns in chatbot.patterns.values()),
        'responses_count': sum(len(responses) for responses in chatbot.responses.values())
    }
    return jsonify(info)

if __name__ == '__main__':
    port = int(os.environ.get('PORT', 5000))
    app.run(host='0.0.0.0', port=port, debug=True) 