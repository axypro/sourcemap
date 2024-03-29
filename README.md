# axy\sourcemap

The library for work with Source Map files from PHP.

[![Latest Stable Version](https://img.shields.io/packagist/v/axy/sourcemap.svg?style=flat-square)](https://packagist.org/packages/axy/sourcemap)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%208.1-8892BF.svg?style=flat-square)](https://php.net/)
[![Tests](https://github.com/axypro/sourcemap/actions/workflows/test.yml/badge.svg)](https://github.com/axypro/sourcemap/actions/workflows/test.yml)
[![Coverage Status](https://coveralls.io/repos/github/axypro/sourcemap/badge.svg?branch=master)](https://coveralls.io/github/axypro/sourcemap?branch=master)
[![License](https://poser.pugx.org/axy/sourcemap/license)](LICENSE)

### Documentation

The library provider the following features for work with source map:

* Creating a new source map file.
* Search in an existing file.
* Making changes to an existing file.
* Simple changes: remove and rename sources, modify positions, etc.
* Changing source map when inserted and removal from the generated content.
* Concatenation source map files when concatenated files of code.
* Merge intermediate source map files.

The library works with source map only.
The library does not process the source files and does not generates the output file.

## Contents

* [Supported Format of Source Map](doc/format.md)
* [Basic Concepts](doc/concepts.md)
* [Position Map](doc/PosMap.md)
* [Create, Load, Save](doc/common.md)
* [Search in Map](doc/search.md)
* [Build Source Map](doc/build.md)
* [Sources and Names](doc/sources.md)
* [Insert/Remove Blocks](doc/blocks.md)
* [Concatenation of Files](doc/concat.md)
* [Merging](doc/merge.md)
* [Other Methods](doc/other.md)
* [Errors](doc/errors.md)
