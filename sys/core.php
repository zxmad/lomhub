<?php

defined('MAD') or die('ERROR');

class Core {

	public $url;
	public $cat;
	public $err;

	public function error($type = '404') {
		$raw = raw('SELECT * FROM `info` WHERE `url`="error_'.$type.'"',1);
		$res['err'] = $raw;
		$res['title'] = $raw['title'];
		return $res;
	}
}

?>