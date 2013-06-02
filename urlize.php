#! /usr/bin/php5
<?php

/*

Title: urlize
Author: Joan Botella Vinaches <http://www.joanbotella.com>
License: Public Domain
Last Update: 2013/05/29

*/


// --- Options ------------------------------------------------------

$i=0;
define('OPTION_BASE64',$i++);
define('OPTION_DECODE',$i++);
define('OPTION_ENTITIES',$i++);
define('OPTION_INPUT',$i++);
define('OPTION_INPUT_FILE',$i++);
define('OPTION_LINE_BREAK',$i++);
define('OPTION_OUTPUT_FILE',$i++);
define('OPTION_RAW',$i++);
// define('OPTION_',$i++);

//defaults
$options=array(
	OPTION_BASE64=>false,
	OPTION_DECODE=>false,
	OPTION_ENTITIES=>false,
	OPTION_INPUT=>'',
	OPTION_INPUT_FILE=>'',
	OPTION_LINE_BREAK=>false,
	OPTION_OUTPUT_FILE=>'',
	OPTION_RAW=>false
);



// --- Errors ------------------------------------------------------

$i=0;
define('ERROR_DEFAULT',$i++);
define('ERROR_SYNTAX',$i++);
define('ERROR_FILE_DONT_EXISTS',$i++);
define('ERROR_FILE_NOT_READABLE',$i++);
define('ERROR_FILE_NOT_WRITABLE',$i++);
define('ERROR_MULTIPLE_ENCODINGS',$i++);
define('ERROR_MULTIPLE_INPUTS',$i++);
// define('ERROR_',$i++);



// --- Functions ----------------------------------------------------

function help(){
?>
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
		URL encodes according to RFC 1738 
		<http://www.rfc-editor.org/rfc/rfc1738.txt>.
Examples:
	urlize.php -r -i example.txt
	urlize.php -o example.txt "This is an example"
	echo "This is an example" | urlize.php -n
Author:
	Joan Botella Vinaches <http://www.joanbotella.com>
License:
	Public Domain
<?php
	exit(0);
}

function error($options,$e=false){

	switch($e){
		case ERROR_SYNTAX:
			$s='Bad syntax, use -h for help.';
			break;
		case ERROR_FILE_DONT_EXISTS:
			$s='File don\'t exists';
			break;
		case ERROR_FILE_NOT_READABLE:
			$s='File is not readable.';
			break;
		case ERROR_FILE_NOT_WRITABLE:
			$s='File is not writeable.';
			break;
		case ERROR_MULTIPLE_INPUTS:
			$s='Please, choose just one input method. Use -h for help.';
			break;
		case ERROR_MULTIPLE_ENCODINGS:
			$s='Please, choose just one encoding method. Use -h for help.';
			break;
		case ERROR_DEFAULT:
		default:
			$e=ERROR_DEFAULT;
			$s='Unknow error';
	}

	if(!$options[OPTION_LINE_BREAK]){
		$s.="\n";
	}
	fwrite(STDERR,$s);
	exit($e);
}

function manageParameters($options){

	for($i=1;$i<$_SERVER['argc'];$i++){

		switch($_SERVER['argv'][$i]){
			case '-b':
			case '--base64':
				$options[OPTION_BASE64]=true;
				break;
			case '-d':
			case '--decode':
				$options[OPTION_DECODE]=true;
				break;
			case '-e':
			case '--html-entities':
				$options[OPTION_ENTITIES]=true;
				break;
			case '-h':
			case '--help':
				help();
				break;
			case '-i':
			case '--input':
				if(
					isset($_SERVER['argv'][$i+1])
				){
					$options[OPTION_INPUT_FILE]=$_SERVER['argv'][$i+1];
					$i++;
				}else{
					error($options,ERROR_SYNTAX);
				}
				break;
			case '-n':
			case '--no-line-break':
				$options[OPTION_LINE_BREAK]=true;
				break;
			case '-o':
			case '--output':
				if(
					isset($_SERVER['argv'][$i+1])
				){
					$options[OPTION_OUTPUT_FILE]=$_SERVER['argv'][$i+1];
					$i++;
				}else{
					error($options,ERROR_SYNTAX);
				}
				break;
			case '-r':
			case '--raw':
				$options[OPTION_RAW]=true;
				break;
			default:
				if($options[OPTION_INPUT]==''){
					//Input
					$options[OPTION_INPUT]=$_SERVER['argv'][$i];
				}else{
					error($options,ERROR_SYNTAX);
				}
		}

	}

	return $options;
}

function getTheInput($options){

	$inputed=false;

	if($options[OPTION_INPUT_FILE]!=''){

		//File

		if(file_exists($options[OPTION_INPUT_FILE])){
			if(!($s=file_get_contents($options[OPTION_INPUT_FILE]))){
				error($options,ERROR_FILE_NOT_READABLE);
			}
		}else{
			error($options,ERROR_FILE_DONT_EXISTS);
		}
		$inputed=true;
	}

	if($options[OPTION_INPUT]!=''){
		if(!$inputed){

			//Command line

			$s=$options[OPTION_INPUT];
			$inputed=true;

		}else{
			error($options,ERROR_MULTIPLE_INPUTS);
		}
	}

	if(!$inputed){

		//Pipes

		$first=true;
		while($line=readline('')){
			if($first){
				$first=false;
			}else{
				$s.="\n";
			}
			$s.=$line;
		}
	}

	return $s;
}

function doTheEncoding($options,$s){

	$encoded=false;

	if($options[OPTION_BASE64]){

		if($options[OPTION_DECODE]){
			$s=base64_decode($s);
		}else{
			$s=base64_encode($s);
		}

		$encoded=true;
	}

	if($options[OPTION_ENTITIES]){
		if(!$encoded){

			$flags=ENT_COMPAT;
			$encoding='UTF-8';
			$double_encode=false;

			if($options[OPTION_DECODE]){
				$s=html_entity_decode($s,$flags,$encoding);
			}else{
				$s=htmlentities($s,$flags,$encoding,$double_encode);
			}

			$encoded=true;
		}else{
			error($options,ERROR_MULTIPLE_ENCODINGS);
		}
	}

	if($options[OPTION_RAW]){
		if(!$encoded){

			if($options[OPTION_DECODE]){
				$s=rawurldecode($s);
			}else{
				$s=rawurlencode($s);
			}

			$encoded=true;
		}else{
			error($options,ERROR_MULTIPLE_ENCODINGS);
		}
	}

	if(!$encoded){

		if($options[OPTION_DECODE]){
			$s=urldecode($s);
		}else{
			$s=urlencode($s);
		}

		$encoded=true;
	}

	return $s;
}

function doTheOutput($options,$s){

	if($options[OPTION_OUTPUT_FILE]!=''){
		if(!(file_put_contents($options[OPTION_OUTPUT_FILE],$s))){
			error($options,ERROR_FILE_NOT_WRITABLE);
		}
	}else{
		if(!$options[OPTION_LINE_BREAK]){
			$s.="\n";
		}
		fwrite(STDOUT,$s);
	}

}

function main($options){

	$options=manageParameters($options);
	$s=getTheInput($options);
	$s=doTheEncoding($options,$s);
	doTheOutput($options,$s);

	// If you are here, everything went ok
	exit(0);

}



// --- Start ----------------------------------------

main($options);

?>