#!/bin/bash

set -e

redis-server --requirepass $REDIS_PASSWORD
