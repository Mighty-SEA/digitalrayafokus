FROM python:3.11-slim

WORKDIR /app

# Install dependencies
COPY ../../../python_requirements.txt .
RUN pip install --no-cache-dir -r python_requirements.txt
RUN python -m spacy download id_core_news_sm

# Copy application files
COPY . .

# Expose the port
EXPOSE 5000

# Run the application
CMD ["gunicorn", "-c", "gunicorn_config.py", "app:app"] 