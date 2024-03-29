<?php

namespace axy\sourcemap\tests\errors;

use axy\sourcemap\errors\IOError;

/**
 * coversDefaultClass axy\sourcemap\errors\IOError
 */
class IOErrorTest extends \PHPUnit\Framework\TestCase
{
    /**
     * covers ::__construct
     * covers ::getFileName
     * covers ::getErrorMessage
     */
    public function testError()
    {
        $ep = new \RuntimeException();
        $e = new IOError('a.txt', 'Not found', $ep);
        $this->assertSame('I/O error. File "a.txt". Not found', $e->getMessage());
        $this->assertSame('a.txt', $e->getFileName());
        $this->assertSame('Not found', $e->getErrorMessage());
        $this->assertSame($ep, $e->getPrevious());
    }
}
