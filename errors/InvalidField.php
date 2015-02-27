<?php
/**
 * @package axy\sourcemap
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\sourcemap\errors;

use axy\errors\Runtime;

/**
 * The source map field has an invalid format
 */
final class InvalidField extends Runtime implements InvalidFormat
{
    /**
     * {@inheritdoc}
     */
    protected $defaultMessage = 'Source map field "{{ field }}" is invalid: "{{ errorMessage }}"';

    /**
     * @param string $field
     * @param string $errorMessage
     * @param \Exception $previous [optional]
     * @param mixed $thrower [optional]
     */
    public function __construct($field = null, $errorMessage = null, \Exception $previous = null, $thrower = null)
    {
        $this->field = $field;
        $this->errorMessage = $errorMessage;
        $message = [
            'field' => $field,
            'errorMessage' => $errorMessage,
        ];
        parent::__construct($message, 0, $previous, $thrower);
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
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
    private $field;

    /**
     * @var string
     */
    private $errorMessage;
}
