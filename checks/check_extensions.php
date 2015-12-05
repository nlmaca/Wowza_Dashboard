<?php
if( ini_get('allow_url_fopen') ) {
	$result = "fsockopen is working / allow_url_fopen = <b>On</b> ";
} else {
	$result = "Sorry, error. fsockopen is NOT working / allow_url_fopen = Off ||";
}
if (extension_loaded('simplexml')) {
	$simpel = "simplexml extension is installed";
} else{ 
	$simpel = "simplexml extension <b>NOT</b> installed";}   

echo "<b>Webserver information:</b> " . $result . " || phpversion: " . phpversion() . "Simple Xml extsion: " . $simpel;

?>