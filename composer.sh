#!/usr/bin/env bash
# Runs a composer command.
# Arguments and options are equal to composer ("./composer.sh --no-cache install" for example).
# Host script that executes internal script (inside docker container)

. $(dirname "$0")/docker/scripts/boot_host.sh

docker-compose run -T --rm php /bin/sh -c "/bin/sh /app/docker/scripts/composer.sh $*"
