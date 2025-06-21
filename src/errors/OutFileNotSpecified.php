<?php

namespace axy\sourcemap\errors;

use axy\errors\Runtime;

/**
 * The default file name of the map is not specified
 */
final class OutFileNotSpecified extends Runtime implements Error
{
    /**
     * {@inheritdoc}
     */
    protected $defaultMessage = 'The default file name of the map is not specified';

    /**
     * @param \Exception|null $previous [optional]
     * @param mixed $thrower [optional]
     */
    public function __construct(?\Exception $previous = null, mixed $thrower = null)
    {
        parent::__construct([], 0, $previous, $thrower);
    }
}
