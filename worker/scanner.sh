#!/bin/sh

CONFIG_FILE="worker/config.cfg"
USERNAME=$(grep "username" "${CONFIG_FILE}" | cut -d" " -f3)
PASSWORD=$(grep "password" "${CONFIG_FILE}" | cut -d" " -f3)

. worker/venv/bin/activate

gvm-cli --gmp-username "${USERNAME}" --gmp-password "${PASSWORD}" socket --xml "<get_version/>"