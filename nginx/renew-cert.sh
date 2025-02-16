#!/bin/bash

######################################################################
# Template
######################################################################
set -o errexit  # Exit if command failed.
set -o pipefail # Exit if pipe failed.
set -o nounset  # Exit if variable not set.
IFS=$'\n\t'     # Remove the initial space and instead use '\n'.

# remove existing SSL certificates and Diffie-Hellman parameters
rm -f ssl/vulndrake.crt ssl/vulndrake.key ssl/dhparam.pem

# generate a new self-signed SSL certificate
openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout ssl/vulndrake.key -out ssl/vulndrake.crt
# generate new Diffie-Hellman parameters
openssl dhparam -out ssl/dhparam.pem 2048