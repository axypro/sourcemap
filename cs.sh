#!/usr/bin/env bash
# Checks code style.
# Arguments and options are equal to phpcs.
# Without arguments checks /src/ and /tests/ directories.
# Host script that executes internal script (inside docker container)

. "$(dirname "$0")/docker/scripts/boot_host.sh"

docker-compose run -T --rm php /bin/sh /app/docker/scripts/cs.sh "$@"
