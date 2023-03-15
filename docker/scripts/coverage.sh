# Run unit tests with coverage (runs inside container)

cd /app && composer install --no-cache && ./vendor/bin/phpunit --coverage-html local/coverage "$@"
