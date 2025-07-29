FROM python:3.11-slim

WORKDIR /app

COPY ./calculadora_flask/requirements.txt .

RUN pip install --no-cache-dir -r requirements.txt

COPY ./calculadora_flask .

RUN addgroup --system prod && adduser --system --ingroup prod pedro

RUN chown -R pedro:prod /app 

USER pedro

EXPOSE 5000

CMD ["gunicorn", "--bind", "0.0.0.0:5000", "app:app"]