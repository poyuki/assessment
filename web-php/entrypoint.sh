mkdir /var/log/supervisor/
chmod 555 -R /var/log/supervisor/
/usr/bin/supervisord -nc /etc/supervisord.conf
