#!/usr/bin/env bash
# Source for including from a host script
# Builds docker compose project and set the current directory to the compose root for docker-compose run

COMPOSE_PROJECT_NAME="axy_sourcemap_test"
export COMPOSE_PROJECT_NAME

cd "$(dirname "${BASH_SOURCE[0]}")" || exit 1;
CURRENT_DIR=$(pwd)
ROOT_DIR="$CURRENT_DIR/../.."

# Use this file owner as the user under which docker is running
USER_ID=$(stat -c '%u' "$CURRENT_DIR")
GROUP_ID=$(stat -c '%g' "$CURRENT_DIR")
export USER_ID
export GROUP_ID

# Create empty composer.lock if it isn't exists yet
# because docker will be mount it as not read-only and it will be created as directory
if [[ ! -e "$ROOT_DIR/composer.lock" ]]
then
    echo "{}" > "$ROOT_DIR/composer.lock";
fi
mkdir -p "$ROOT_DIR/vendor" || exit 1
mkdir -p "$ROOT_DIR/local" || exit 1

cd "$CURRENT_DIR/.." && docker-compose build || exit 1
