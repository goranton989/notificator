#!/bin/bash

set -e

HORIZON_LOGS = /srv/horizon.log

start_supervisor() {
  service supervisor stop
  service supervisor start
  supervisorctl reread
  supervisorctl update
}

clear_horizon_logs() {
  echo "" > ${HORIZON_LOGS}
}

if [ "$1" == "horizon" ]; then
  echo "Run as horizon"
  start_supervisor
  clear_horizon_logs
fi

shift
exec $@