<?php

defined('MAD') or die('ERROR');

class Load extends Core {

	public function main() {
		$res['title'] = 'Lomhub';
		$res['ad'] = raw('SELECT * FROM `reklama` ORDER BY RAND() LIMIT 1',1);
		$best = ($res['ad']) ? 5 : 6;
		$res['best'] = raw('SELECT * FROM `item` ORDER BY RAND() LIMIT '.$best);
		$res['new'] = raw('SELECT * FROM `item` ORDER BY `id` DESC LIMIT 6');
		$res['poster'] = raw('SELECT * FROM `poster` WHERE `home`=1');
		for ($i=0; $i < count($res['best']); $i++) { 
			$res['best'][$i]['photo'] = explode('~', strtolower(trim($res['best'][$i]['photos'])))[1];
		}
		for ($i=0; $i < count($res['new']); $i++) { 
			$res['new'][$i]['photo'] = explode('~', strtolower(trim($res['new'][$i]['photos'])))[1];
		}
		return $res;
	}

	public function text() {
		$raw = raw('SELECT * FROM `info` WHERE `url`="'.$this->url[2].'"',1);
		if (!$raw) $this->err = '404';
		$res['info'] = $raw;
		$res['title'] = $raw['title'];
		return $res;
	}

	public function search() {
		if (empty($this->url[3])) {
			header('Location: /');
		} else {
			if (empty($_GET['q']) or !is_numeric($_GET['cat'])) {
				header('Location: /');
			}
			$res['title'] = 'Поиск: ' . $_GET['q'];
			$subcat = raw('SELECT * FROM `subcat` WHERE `cat_id`='.$_GET['cat']);
			if ($subcat or $_GET['cat']==0) {
				for ($i=0; $i < count($subcat); $i++) { 
					$subcat_ids .= $subcat[$i]['id'].', ';
				}
				$cat = ($_GET['cat'] != 0) ? '(`subcat_id` IN('.substr($subcat_ids, 0, -2).')) AND ' : '';
				$sql = 'SELECT * FROM `item` WHERE '.$cat.'(`title` LIKE "%'.$_GET['q'].'%" OR `info` LIKE "%'.$_GET['q'].'%")';
				$res['result'] = raw($sql);
				for ($i=0; $i < count($res['result']); $i++) {
					$res['result'][$i]['info'] = substr($res['result'][$i]['info'], 0, 250);
					$res['result'][$i]['lombard'] = raw('SELECT * FROM `lombard` WHERE `id`='.$res['result'][$i]['lom_id'],1);
					$res['result'][$i]['photo'] = explode('~', strtolower(trim($res['result'][$i]['photos'])))[1];
				}
			}
		}
		return $res;
	}

	public function go() {
		if (isset($_GET['url'])) {
			header('Location: '.$_GET['url']);
		} else {
			header('Location: /');
		}
	}

	public function lombards() {
		$res['title'] = 'Ломбарды';
		$res['lom'] = raw('SELECT * FROM `lombard`');
		return $res;
	}
}

?>