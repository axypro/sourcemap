<?php

declare(strict_types=1);

namespace axy\sourcemap\tests;

require_once __DIR__ . '/../index.php';

if (!file_exists(__DIR__ . '/../local')) {
    mkdir(__DIR__ . '/../local');
}
