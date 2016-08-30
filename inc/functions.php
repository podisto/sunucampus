<?php

	function debug($variable){
		echo '<pre>'.print_r($variable,true).'</pre>';
	}

	function str_random($length){
		$caracteres = "1234567890azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
		return substr((str_shuffle(str_repeat($caracteres, $length))),0,$length);
	}

	