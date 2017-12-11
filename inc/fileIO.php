<?php
/* Basic, low-resource file operations */

function basicRead($fileName) {
	if(!file_exists(getcwd() . "/" . $fileName)) {
		trigger_error("File " . $fileName . " does not exist", E_USER_WARNING);
		return null;
	}
	
	$raw = file_get_contents(getcwd() . "/" . $fileName);
	$clean = str_replace(array("\r\n", "\r", "\n"), "", $raw);
	return $clean;
}

function basicWrite($fileName, $data) {
	file_put_contents(getcwd() . "/" . $fileName, $data);
}
?>