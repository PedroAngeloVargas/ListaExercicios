FROM php:8.2-apache                                                          
                                           
COPY . /var/www/html/   

RUN apt-get update -y && apt-get upgrade -y

RUN apt-get install -y libpq-dev

RUN docker-php-ext-install pdo pdo_pgsql

RUN addgroup --system prod && adduser --system --ingroup prod pedro

RUN chown -R pedro:prod /var/www/html/

USER pedro
                                                                                      
EXPOSE 80