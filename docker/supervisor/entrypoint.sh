#!/usr/bin/env bash

/usr/bin/supervisord -c ${CONFIG_NAME}

# start "daemon"
while true
do
  sleep 1
done
