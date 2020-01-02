<?php

defined('MAD') or die('ERROR');

class Start {
	
	public function run() {
		$url = explode('/', strtolower(trim($_SERVER['REQUEST_URI'], '')));
		unset($url[0]);

		// INCLUDE db and core class
		require_once($_SERVER['DOCUMENT_ROOT'].'/sys/core.php');
		require_once($_SERVER['DOCUMENT_ROOT'].'/sys/func.php');
		require_once($_SERVER['DOCUMENT_ROOT'].'/sys/db.php');
		
		// GET class and method from url
		if ((empty($url[1]) and !empty($url[2])) or (($url[1] == 'load') and (empty($url[2]) or ($url[2] == 'main')))) {
			header('Location: /');
		} else {
			$class = (!empty($url[1])) ? ucfirst(strtolower($url[1])) : 'Load';
			$method = (!empty($url[2])) ? strtolower($url[2]) : 'main';
			$default_method = ($class == 'Load') ? 'text' : 'main';
		}

		// REQUIRE class and method files
		$c_file = (file_exists($_SERVER['DOCUMENT_ROOT'].'/sys/php/'.$class.'.php')) ? $class : 'Load';
		require_once($_SERVER['DOCUMENT_ROOT'].'/sys/php/'.$c_file.'.php');

		// CREATE class and SET vars
		if (class_exists($class)) {
			$start = new $class;
		} else {
			$start = new Load();
			$start->err = '404';
		}
		$start->url = $url;
		$start->cat = raw('SELECT * FROM `cat`');

		// RUN method, GEN. path to view's file
		if (!empty($start->err)) {
			$res = Core::error($start->err);
			$view_file = 'load.error';
		} else {
			$res = method_exists($start, $method) ? $start->$method() : $start->$default_method();
			$view_file = strtolower($class).'.';
			$view_file .= (file_exists($_SERVER['DOCUMENT_ROOT'].'/sys/view/'.$view_file.$method.'.php')) ? $method : $default_method;
		}
		$res['cat'] = $start->cat;

		// GEN. VIEW
		$this->html($res, $view_file, $url);
	}

	public function html($r, $file, $url) {
		require_once($_SERVER['DOCUMENT_ROOT'].'/sys/view/.head.php');
		require_once($_SERVER['DOCUMENT_ROOT'].'/sys/view/'.$file.'.php');
		require_once($_SERVER['DOCUMENT_ROOT'].'/sys/view/.foot.php');
	}
}

?>