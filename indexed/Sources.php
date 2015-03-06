<?php
/**
 * @package axy\sourcemap
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\sourcemap\indexed;

/**
 * Wrapper for section "sources" (and "sourcesContent")
 */
final class Sources extends Base
{
    /**
     * {@inheritdoc}
     */
    protected $contextKey = 'sources';

    /**
     * {@inheritdoc}
     */
    protected function onRename($index, $newName)
    {
        $this->context->mappings->renameFile($index, $newName);
    }
}
