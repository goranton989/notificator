#!/bin/bash

set -e

service supervisor stop
service supervisor start

supervisorctl reread
supervisorctl update

exec $@