FROM ubuntu:18.04

RUN apt-get update && \
    apt-get install -y && \
    apt-get -y install sudo
ENV DEBIAN_FRONTEND=noninteractive
ENV TZ=Pacific
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
RUN sudo apt-get install apache2 -y
RUN sudo apt-get install php -y
RUN apt-get install php-redis -y
COPY . /var/www/html/
WORKDIR /var/www/html

CMD [ "php", "-S", "0.0.0.0:8080", "./index.php"]