#Dockerfile vulnerável
#FROM python:3.9
#WORKDIR /app COPY requirements.txt . RUN pip install -r
#requirements.txt
#COPY . .
#CMD ["python", "app.py"]

FROM python:3.14-rc-alpine

WORKDIR /app 

COPY ./flask/requirements.txt . 

RUN pip install -r requirements.txt

COPY ./flask .

RUN apk update && apk upgrade 

RUN addgroup -S prod && adduser -S -G prod pedro

RUN chown -R pedro:prod /app 

USER pedro

EXPOSE 5000

CMD ["gunicorn", "--bind", "0.0.0.0:5000", "app:app"]
