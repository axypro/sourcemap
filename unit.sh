#!/usr/bin/env bash
# Runs unit tests.
# Arguments and options are equal to phpunit.
# Without arguments runs all tests inside /tests/ directory.
# Host script that executes internal script (inside docker container)

. "$(dirname "$0")/docker/scripts/boot_host.sh"

docker-compose run --rm php /bin/sh /app/docker/scripts/unit.sh "$@"
