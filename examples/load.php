<?php

declare(strict_types=1);

namespace axy\sourcemap\examples;

use axy\sourcemap\SourceMap;

require_once __DIR__ . '/../index.php';

$map = SourceMap::loadFromFile(__DIR__ . '/map.js.map');

print_r($map->names->getNames());
