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
    protected $keyIndex = 'fileIndex';

    /**
     * {@inheritdoc}
     */
    protected $keyName = 'fileName';

    /**
     * {@inheritdoc}
     */
    protected function onRename($index, $newName)
    {
        $this->context->getMappings()->renameFile($index, $newName);
    }

    /**
     * {@inheritdoc}
     */
    protected function onRemove($index)
    {
        $this->context->getMappings()->removeFile($index);
    }
}
