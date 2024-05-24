#!/bin/sh

. worker/venv/bin/activate

gvm-cli --gmp-username admin --gmp-password admin socket --xml "<get_version/>"