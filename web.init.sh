#!/bin/ash
#

if [ ! -d $PWD/node_modules ]; then
  npm install
fi

if [ ! -d $PWD/dist ]; then
  npm run build
fi

/usr/sbin/httpd -D FOREGROUND -f /etc/apache2/httpd.conf
