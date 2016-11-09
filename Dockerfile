FROM ubuntu:latest

RUN apt-get update && apt-get -y install vim apache2 php php7.0-pgsql libapache2-mod-php7.0 postgresql-client

#COPY * /var/www/html/

EXPOSE 80

CMD /usr/sbin/apache2ctl -D FOREGROUND