<?php

namespace axy\sourcemap\tests\parsing;

use axy\sourcemap\parsing\FormatChecker;

/**
 * coversDefaultClass axy\sourcemap\parsing\FormatChecker
 */
class FormatCheckerTest extends \PHPUnit\Framework\TestCase
{
    /**
     * covers ::check
     * @dataProvider providerCheck
     * @param array|null $origin
     * @param array $normalized
     */
    public function testCheck($origin, array $normalized)
    {
        $this->assertEquals($normalized, FormatChecker::check($origin));
    }

    public static function providerCheck(): array
    {
        return [
            [
                [
                    'version' => 3,
                    'file' => 'out.js',
                    'sourceRoot' => '',
                    'sources' => ['a.js', 'b.js'],
                    'sourcesContent' => ['aaa', 'bbb'],
                    'names' => ['one', 'two'],
                    'mappings' => 'AAAA',
                ],
                [
                    'version' => 3,
                    'file' => 'out.js',
                    'sourceRoot' => '',
                    'sources' => ['a.js', 'b.js'],
                    'sourcesContent' => ['aaa', 'bbb'],
                    'names' => ['one', 'two'],
                    'mappings' => 'AAAA',
                ],
            ],
            [
                [
                    'version' => '3',
                    'sources' => ['a.js', 'b.js'],
                    'mappings' => 'AAAA',
                ],
                [
                    'version' => 3,
                    'file' => null,
                    'sourceRoot' => null,
                    'sources' => ['a.js', 'b.js'],
                    'sourcesContent' => [],
                    'names' => [],
                    'mappings' => 'AAAA',
                ],
            ],
            [
                null,
                [
                    'version' => 3,
                    'file' => null,
                    'sourceRoot' => null,
                    'sources' => [],
                    'sourcesContent' => [],
                    'names' => [],
                    'mappings' => '',
                ],
            ],
        ];
    }

    /**
     * covers ::check
     *
     */
    public function testUnsupportedVersion()
    {
        $this->expectException(\axy\sourcemap\errors\UnsupportedVersion::class);
        $data = [
            'version' => 5,
            'sources' => ['a.js', 'b.js'],
            'mappings' => 'AAAA',
        ];
        FormatChecker::check($data);
    }

    /**
     * covers ::check
     * @dataProvider providerInvalidSection
     * @param array $data
     * @param array $data
     *
     */
    public function testInvalidSection(array $data)
    {
        $this->expectException(\axy\sourcemap\errors\InvalidSection::class);
        FormatChecker::check($data);
    }

    public static function providerInvalidSection(): array
    {
        return [
            [
                [
                    'sources' => ['a.js', 'b.js'],
                    'mappings' => 'AAAA',
                ],
            ],
            [
                [
                    'version' => [3],
                    'sources' => ['a.js', 'b.js'],
                    'mappings' => 'AAAA',
                ],
            ],
            [
                [
                    'version' => 3,
                    'file' => ['out.js'],
                    'sources' => ['a.js', 'b.js'],
                    'mappings' => 'AAAA',
                ],
            ],
            [
                [
                    'version' => 3,
                    'file' => 'out.js',
                    'sources' => 'a.js',
                    'mappings' => 'AAAA',
                ],
            ],
            [
                [
                    'version' => 3,
                    'file' => 'out.js',
                    'sources' => (object)['a' => 'a.js'],
                    'mappings' => 'AAAA',
                ],
            ],
            [
                [
                    'version' => 3,
                    'file' => 'out.js',
                    'sourceRoot' => ['a'],
                    'sources' => ['a.js', 'b.js'],
                    'mappings' => 'AAAA',
                ],
            ],
            [
                [
                    'version' => 3,
                    'file' => 'out.js',
                    'sources' => ['a.js', 'b.js'],
                    'names' => 'name',
                    'mappings' => 'AAAA',
                ],
            ],
            [
                [
                    'version' => 3,
                    'file' => 'out.js',
                    'sources' => ['a.js', 'b.js'],
                    'mappings' => ['AAAA'],
                ],
            ],
            [
                [
                    'version' => 3,
                    'file' => 'out.js',
                    'sources' => ['a.js', 'b.js'],
                ],
            ],
            [
                [
                    'version' => 3,
                    'file' => 'out.js',
                    'sources' => ['a.js', 'b.js'],
                    'sourcesContent' => ['aaa', 'bbb', 'ccc'],
                    'mappings' => 'AAAA',
                ],
            ],
            [
                [
                    'version' => 3,
                    'file' => 'out.js',
                    'sources' => ['a' => 'a.js', 'b' => 'b.js'],
                    'mappings' => 'AAAA',
                ],
            ],
        ];
    }
}
