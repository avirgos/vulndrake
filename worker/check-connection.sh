#!/bin/sh

######################################################################
# Template
######################################################################
set -o errexit  # Exit if command failed.
set -o pipefail # Exit if pipe failed.
set -o nounset  # Exit if variable not set.
IFS=$'\n\t'     # Remove the initial space and instead use '\n'.

# activate the Python virtual environment
. worker/venv/bin/activate

# set environment variables for GMP username and password
USERNAME="${GMP_USERNAME}"
PASSWORD="${GMP_PASSWORD}"
SOCKET_PATH="/run/gvmd/gvmd.sock"

# function to check the GVM connection status
gvm_command_check_status() {
    gvm-cli --gmp-username "${USERNAME}" --gmp-password "${PASSWORD}" socket --socketpath "${SOCKET_PATH}" --xml "<get_version/>"
}

while true
do
    RESPONSE=$(gvm_command_check_status)

    # successful connection
    if echo "${RESPONSE}" | grep -q '<get_version_response.*status="200"'
    then
        echo "VulnDrake connected to socket."
        exit 0
    else
        sleep 5
    fi
done