#!/bin/sh

. worker/venv/bin/activate

USERNAME="${GMP_USERNAME}"
PASSWORD="${GMP_PASSWORD}"

TIMESTAMP=$(date +%Y%m%d%H%M%S)
UNIQUE_ID=$$
TARGET_NAME="VulnDrake-Scan-Host-${TIMESTAMP}-${UNIQUE_ID}"
TASK_NAME="VulnDrake-Scan-Task-${TIMESTAMP}-${UNIQUE_ID}"

TARGET_IP="${1}"

PORT_LIST_ID="730ef368-57e2-11e1-a90f-406186ea4fc5" # to customize
CONFIG_ID="d21f6c81-2b88-4ac1-b7b4-a2a9f2ad4663"    # to customize
FORMAT_ID="a994b278-1f62-11e1-96ac-406186ea4fc5"    # XML

REPORT_DIR="/worker/reports"
REPORT_FILE="${REPORT_DIR}/VulnDrake-Report-${TIMESTAMP}-${UNIQUE_ID}.xml"

mkdir -p "${REPORT_DIR}"

gvm_command() {
    gvm-cli --gmp-username "${USERNAME}" --gmp-password "${PASSWORD}" socket --socketpath /run/gvmd/gvmd.sock --xml "$1"
}

CREATE_TARGET_XML="<create_target><name>${TARGET_NAME}</name><hosts>${TARGET_IP}</hosts><port_list id='${PORT_LIST_ID}'/></create_target>"
CREATE_TARGET_RESPONSE=$(gvm_command "${CREATE_TARGET_XML}")
TARGET_ID=$(echo "${CREATE_TARGET_RESPONSE}" | sed -n 's/.*id="\([^"]*\)".*/\1/p')

CREATE_TASK_XML="<create_task><name>${TASK_NAME}</name><target id='${TARGET_ID}'/><config id='${CONFIG_ID}'/></create_task>"
CREATE_TASK_RESPONSE=$(gvm_command "${CREATE_TASK_XML}")
TASK_ID=$(echo "${CREATE_TASK_RESPONSE}" | sed -n 's/.*id="\([^"]*\)".*/\1/p')

START_TASK_XML="<start_task task_id='${TASK_ID}'/>"
START_TASK_RESPONSE=$(gvm_command "${START_TASK_XML}")

while true
do
    GET_TASK_XML="<get_tasks task_id='${TASK_ID}'/>"
    GET_TASK_RESPONSE=$(gvm_command "${GET_TASK_XML}")
    TASK_STATUS=$(echo "${GET_TASK_RESPONSE}" | sed -n 's/.*<status>\(.*\)<\/status>.*/\1/p')

    if test "${TASK_STATUS}" = "Done"
    then
        REPORT_ID=$(echo "${GET_TASK_RESPONSE}" | sed -n 's/.*<last_report>.*<report id="\([^"]*\)".*/\1/p')

        if test -n "${REPORT_ID}"
        then
            GET_REPORT_XML="<get_reports report_id='${REPORT_ID}' format_id='${FORMAT_ID}'/>"
            GET_REPORT_RESPONSE=$(gvm_command "${GET_REPORT_XML}")
               
            echo "${GET_REPORT_RESPONSE}" > "${REPORT_FILE}"
            echo "Report saved as ${REPORT_FILE}"
            chmod 644 "${REPORT_FILE}"

            exit 0
        else
            echo "No report ID found. Task completed but no report generated."
            exit 1
        fi
    fi

    sleep 5
done