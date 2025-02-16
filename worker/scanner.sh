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

# generate a unique timestamp for the target and task names
TIMESTAMP=$(date +%Y%m%d%H%M%S)
UNIQUE_ID=$$
TARGET_NAME="VulnDrake-Scan-Host-${TIMESTAMP}-${UNIQUE_ID}"
TASK_NAME="VulnDrake-Scan-Task-${TIMESTAMP}-${UNIQUE_ID}"

# target IP and port list ID from the script arguments
TARGET_IP="${1}"
PORT_LIST_ID="${2}"

# configuration ID for a minimal set of NVTs required for a scan
CONFIG_ID="d21f6c81-2b88-4ac1-b7b4-a2a9f2ad4663"
# format ID for generating a PDF report
FORMAT_ID="c402cc3e-b531-11e1-9163-406186ea4fc5"

# directory and filename for the generated report
REPORT_DIR="/worker"
REPORT_FILE="${REPORT_DIR}/VulnDrake-Report-${TIMESTAMP}-${UNIQUE_ID}.pdf"

# function to execute GVM commands
gvm_command() {
    gvm-cli --gmp-username "${USERNAME}" --gmp-password "${PASSWORD}" socket --socketpath "${SOCKET_PATH}" --xml "$1"
}

# create a target in GVM with the specified IP address and port list
CREATE_TARGET_XML="<create_target><name>${TARGET_NAME}</name><hosts>${TARGET_IP}</hosts><port_list id='${PORT_LIST_ID}'/></create_target>"
CREATE_TARGET_RESPONSE=$(gvm_command "${CREATE_TARGET_XML}")
TARGET_ID=$(echo "${CREATE_TARGET_RESPONSE}" | sed -n 's/.*id="\([^"]*\)".*/\1/p')

# create a task in GVM with the specified target and configuration
CREATE_TASK_XML="<create_task><name>${TASK_NAME}</name><target id='${TARGET_ID}'/><config id='${CONFIG_ID}'/></create_task>"
CREATE_TASK_RESPONSE=$(gvm_command "${CREATE_TASK_XML}")
TASK_ID=$(echo "${CREATE_TASK_RESPONSE}" | sed -n 's/.*id="\([^"]*\)".*/\1/p')

# start the task in GVM
START_TASK_XML="<start_task task_id='${TASK_ID}'/>"
START_TASK_RESPONSE=$(gvm_command "${START_TASK_XML}")

while true
do
    GET_TASK_XML="<get_tasks task_id='${TASK_ID}'/>"
    GET_TASK_RESPONSE=$(gvm_command "${GET_TASK_XML}")
    TASK_STATUS=$(echo "${GET_TASK_RESPONSE}" | sed -n 's/.*<status>\(.*\)<\/status>.*/\1/p')

    # if the task is done, retrieve the report ID and export the report as a PDF
    if test "${TASK_STATUS}" = "Done"
    then
        REPORT_ID=$(echo "${GET_TASK_RESPONSE}" | sed -n 's/.*<last_report>.*<report id="\([^"]*\)".*/\1/p')

        if test -n "${REPORT_ID}"
        then
            gvm-script --gmp-username "${USERNAME}" --gmp-password "${PASSWORD}" socket --socketpath "${SOCKET_PATH}" worker/export-pdf-report.gmp.py "${REPORT_ID}" "${REPORT_FILE}"

            echo "Report saved as ${REPORT_FILE}"
            exit 0
        else
            echo "No report ID found. Task completed but no report generated."
            exit 1
        fi
    fi

    sleep 5
done