URLize
======

PHP CLI script for encoding into URL, base64 and others.

Requirements
============

As a PHP version 5 CLI script, it requires the cli package for PHP 5 (php5-cli) installed, at least on Linux systems.

Examples
========

	urlize.php http://www.joanbotella.com/urlize
	http%3A%2F%2Fwww.joanbotella.com%2Furlize

	urlize.php -d https%3A%2F%2Fgithub.com%2FJoanBotella%2Furlize
	https://github.com/JoanBotella/urlize

	echo "This is an example" | urlize.php -n
	This+is+an+example

Help
====

	Description:
		Encodes text into web developers useful encodings. By default, the URL encoding is used.
	Usage:
		urlize.php {-b|-e|-r} [-d] [-n] [-h] [-o filename] [-i filename|"text to encode"]
	Options:
		-b, --base64
			Encodes using base64
		-d, --decode
			Decodes instead of encode.
		-e, --html-entities
			Encodes into HTML entities.
		-h, --help
			Shows this help.
		-i filename, --input filename
			Reads a file and encode its contents.
		-n, --no-line-break
			Don't append a \n to the console output.
		-o filename, --output filename
			Outputs result into a file, creating or overwriting it.
		-r, --raw
			URL encodes according to RFC 1738 <http://www.rfc-editor.org/rfc/rfc1738.txt>.
	Examples:
		urlize.php -r -i example.txt
		urlize.php -o example.txt "This is an example"
		echo "This is an example" | urlize.php -n
	Author:
		Joan Botella Vinaches <http://www.joanbotella.com>
	License:
		GNU/GPL v3 or later <http://www.gnu.org/licenses/gpl.html>

License
=======

Copyright (C) 2013 Joan Botella Vinaches

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or 
any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.

Author web site: <http://www.joanbotella.com>