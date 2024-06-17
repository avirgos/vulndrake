#!/bin/sh

. worker/venv/bin/activate

USERNAME="${GMP_USERNAME}"
PASSWORD="${GMP_PASSWORD}"
SOCKET_PATH="/run/gvmd/gvmd.sock"

gvm_command_check_status() {
    gvm-cli --gmp-username "${USERNAME}" --gmp-password "${PASSWORD}" socket --socketpath "${SOCKET_PATH}" --xml "<get_version/>"
}

while true
do
    RESPONSE=$(gvm_command_check_status)

    if echo "${RESPONSE}" | grep -q '<get_version_response.*status="200"'
    then
        echo "VulnDrake connected to socket."
        exit 0
    else
        sleep 5
    fi
done