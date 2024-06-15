#!/bin/sh

USERNAME=${GMP_USERNAME}
PASSWORD=${GMP_PASSWORD}

. worker/venv/bin/activate

gvm-cli --gmp-username "${USERNAME}" --gmp-password "${PASSWORD}" socket --xml "<get_version/>"