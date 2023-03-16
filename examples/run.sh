#!/usr/bin/env bash
# Runs an example.

. "$(dirname "$0")/../docker/scripts/boot_host.sh"

docker-compose run --rm php /bin/sh /app/docker/scripts/example.sh "$@"
