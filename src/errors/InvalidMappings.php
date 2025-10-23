<?php

namespace axy\sourcemap\errors;

use axy\errors\Runtime;

/**
 * The source map mappings has an invalid format
 */
final class InvalidMappings extends Runtime implements InvalidFormat
{
    /**
     * {@inheritdoc}
     */
    protected $defaultMessage = 'Source map mappings is invalid: "{{ errorMessage }}"';

    /**
     * @param string|null $errorMessage
     * @param \Exception|null $previous [optional]
     * @param mixed $thrower [optional]
     */
    public function __construct(?string $errorMessage = null, ?\Exception $previous = null, mixed $thrower = null)
    {
        $this->errorMessage = $errorMessage;
        $message = [
            'errorMessage' => $errorMessage,
        ];
        parent::__construct($message, 0, $previous, $thrower);
    }

    /**
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * @var string
     */
    private $errorMessage;
}
