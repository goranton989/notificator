#!/bin/bash

set -e

start_supervisor() {
  service supervisor stop
  service supervisor start
  supervisorctl reread
  supervisorctl update
}

if [ "$1" == "horizon" ]; then
  echo "Run as horizon"
  start_supervisor
fi

shift
exec $@