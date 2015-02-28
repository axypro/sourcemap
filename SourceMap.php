<?php
/**
 * @package axy\sourcemap
 * @author Oleg Grigoriev
 */

namespace axy\sourcemap;

use axy\sourcemap\parsing\FormatChecker;
use axy\sourcemap\parsing\Context;

/**
 * The Source Map Class
 */
class SourceMap
{
    /**
     * The constructor
     *
     * @param array $data [optional]
     * @throws \axy\sourcemap\errors\InvalidFormat
     */
    public function __construct(array $data = null)
    {
        $this->context = new Context(FormatChecker::check($data));
    }

    /**
     * Returns the data of the json file
     *
     * @return array
     */
    public function getData()
    {
        return $this->context->getOutData();
    }

    /**
     * @var \axy\sourcemap\parsing\Context
     */
    private $context;
}
