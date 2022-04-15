<?php
/**
 * @package axy\sourcemap
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\sourcemap\tests\helpers;

use axy\sourcemap\helpers\IO;

/**
 * coversDefaultClass axy\sourcemap\helpers\IO
 */
class IOTest extends \PHPUnit\Framework\TestCase
{
    /**
     * covers ::load
     */
    public function testLoad()
    {
        $content = IO::load(__DIR__.'/../tst/invalid.json.js.map');
        $this->assertSame('qwerty', trim($content));
    }

    /**
     * covers ::load
     *
     *
     */
    public function testLoadIOError()
    {
        $this->expectExceptionMessage("not.found.js.map");
        $this->expectException(\axy\sourcemap\errors\IOError::class);
        IO::load(__DIR__.'/../not.found.js.map');
    }

    /**
     * covers ::save
     */
    public function testSave()
    {
        $fn = __DIR__.'/../tmp/test.txt';
        $content = 'The test content';
        if (is_file($fn)) {
            unlink($fn);
        }
        IO::save($fn, $content);
        $this->assertFileExists($fn);
        $this->assertStringEqualsFile($fn, $content);
    }

    /**
     * covers ::load
     *
     *
     */
    public function testSaveIOError()
    {
        $this->expectExceptionMessage("tmp/und/und.txt");
        $this->expectException(\axy\sourcemap\errors\IOError::class);
        $fn = __DIR__.'/../tmp/und/und.txt';
        IO::save($fn, 'Content');
    }
}
