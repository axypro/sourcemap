<?php
/**
 * @package axy\sourcemap
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\sourcemap\helpers;

use axy\sourcemap\errors\IOError;

/**
 * Helpers for I/O file operations
 */
class IO
{
    /**
     * Loads a content from a file
     *
     * @param string $filename
     * @return string
     * @throws \axy\sourcemap\errors\IOError
     */
    public static function load($filename)
    {
        if (!is_readable($filename)) {
            throw new IOError($filename, 'File not found or file is not readable');
        }
        $content = @file_get_contents($filename);
        if ($content === false) {
            self::throwNativeError($filename);
        }
        return $content;
    }

    /**
     * Saves a content to a file
     *
     * @param string $filename
     * @param string $content
     * @throws \axy\sourcemap\errors\IOError
     */
    public static function save($filename, $content)
    {
        if (!@file_put_contents($filename, $content)) {
            self::throwNativeError($filename);
        }
    }

    /**
     * @param string $filename
     * @throws \axy\sourcemap\errors\IOError
     */
    private static function throwNativeError($filename)
    {
        $error = error_get_last();
        if (isset($error['message'])) {
            $message = $error['message'];
        } else {
            $message = null;
        }
        throw new IOError($filename, $message);
    }
}
