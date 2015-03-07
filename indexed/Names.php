<?php
/**
 * @package axy\sourcemap
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\sourcemap\indexed;

/**
 * Wrapper for section "names"
 */
final class Names extends Base
{
    /**
     * {@inheritdoc}
     */
    protected $contextKey = 'names';

    /**
     * {@inheritdoc}
     */
    protected function onRename($index, $newName)
    {
        $this->context->mappings->renameName($index, $newName);
    }

    /**
     * {@inheritdoc}
     */
    protected function onRemove($index)
    {
        $this->context->mappings->removeName($index);
    }
}
