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

	urlize.php -a md5 JoanBotella
	2e831ecdf98bd74a22582b8ada4195de

	echo "This is an example" | urlize.php -n
	This+is+an+example

Help
====

	Description:
		Encodes text into web developers useful encodings. By default, the URL encoding is used.
	Usage:
		urlize.php {-a algorithm [-r]|-b|-e|-r} [-d] [-n] [-h] [-o filename] [-i filename|"text to encode"]
	Options:
		-a algorithm, --algorithm algorithm
			Encodes using the selected algorithm. Not supported algorithms returns an empty string. Combine with -r for raw output.
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
			URL encodes according to RFC 1738 <http://www.rfc-editor.org/rfc/rfc1738.txt>, or returns raw output when using with -a .
	Examples:
		urlize.php -r -i example.txt
		urlize.php -o example.txt "This is an example"
		echo "This is an example" | urlize.php -n
	Author:
		Joan Botella Vinaches <http://www.joanbotella.com>
	License:
		GNU/GPL v3 or later <http://www.gnu.org/licenses/gpl.html>