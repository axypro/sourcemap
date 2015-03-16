# axy\sourcemap

The library for work with Source Map files from PHP.

* GitHub: [axypro/sourcemap](https://github.com/axypro/sourcemap)
* Composer: [axypro/sourcemap](https://packagist.org/packages/axy/sourcemap)
* LICENSE: [MIT](LICENSE)
* Author: Oleg Grigoriev

PHP 5.4+

Library does not require any dependencies (except composer packages).

## Overview

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
