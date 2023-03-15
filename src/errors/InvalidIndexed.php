<?php

namespace axy\sourcemap\errors;

use axy\errors\Runtime;

/**
 * Error when working with indexed sections ("sources" and "names")
 * - Invalid index
 * - An index index does not match a name
 * - etc
 */
class InvalidIndexed extends Runtime implements Error
{
}
