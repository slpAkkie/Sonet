#!/bin/ash
#

if [ ! -d $PWD/vendor ]; then
  composer install

  if [ ! -f $PWD/.env ]; then
    cp $PWD/.env.example $PWD/.env
    php artisan key:generate
  fi

  php artisan migrate
fi

chown -R apache:apache ./

/usr/sbin/httpd -D FOREGROUND -f /etc/apache2/httpd.conf
