#!/bin/bash

rm -f ssl/vulndrake.crt ssl/vulndrake.key ssl/dhparam.pem

openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout ssl/vulndrake.key -out ssl/vulndrake.crt
openssl dhparam -out ssl/dhparam.pem 2048