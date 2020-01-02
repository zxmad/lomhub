<?php

defined('MAD') or die('ERROR');

class Product extends Core {

	public function main() {
		if (is_numeric($_GET['save'])) {
			$is_exsist = raw('SELECT * FROM `bookmark` WHERE `user_id`='.$_SESSION['user']['uid'].' AND `item_id`='.$_GET['save'],1);
			$save = (!$is_exsist) ? raw('INSERT INTO `bookmark`(`user_id`, `item_id`) VALUES ("'.$_SESSION['user']['uid'].'","'.$_GET['save'].'")',2) : null;
			header('Location: '.$_SERVER['HTTP_REFERER']);
		} elseif (is_numeric($_GET['del'])) {
			$is_exsist = raw('SELECT * FROM `bookmark` WHERE `user_id`='.$_SESSION['user']['uid'].' AND `item_id`='.$_GET['del'],1);
			$del = ($is_exsist) ? raw('DELETE FROM `bookmark` WHERE `item_id`='.$_GET['del'].' AND `user_id`='.$_SESSION['user']['uid'],2) : null;
			header('Location: '.$_SERVER['HTTP_REFERER']);
		} elseif (!empty($this->url[2])) {
			$id = explode('-', strtolower(trim($this->url[2])))[0];
			$item = raw('SELECT * FROM `item` WHERE `id`='.$id,1);
			if ($item) {
				$res['item'] = $item;
				$res['item']['filters'] = explode(';', strtolower(trim($item['filters'])));
				$res['item']['photos'] = explode('~', strtolower(trim($item['photos'])));
				unset($res['item']['filters'][0]);
				unset($res['item']['photos'][0]);
				$res['item']['lombard'] = raw('SELECT * FROM `lombard` WHERE `id`='.$item['lom_id'],1);
				if (!empty($res['item']['filters'])) {
					for ($i=1; $i <= count($res['item']['filters']); $i++) { 
						$res['item']['filters'][$i] = raw('SELECT * FROM `filter` WHERE `id`='.$res['item']['filters'][$i],1);
					}
				}
				$path = raw('SELECT * FROM `subcat` WHERE `id`='.$res['item']['subcat_id'],1);
				$res['item']['path'] = raw('SELECT * FROM `cat` WHERE `id`='.$path['cat_id'],1);
				$res['item']['path']['subcat'] = $path;
				if (isset($_SESSION['user'])) {
					$res['item']['bookmark'] = raw('SELECT * FROM `bookmark` WHERE `user_id`='.$_SESSION['user']['uid'].' AND `item_id`='.$res['item']['id'],1);
				}
				
				$res['title'] = $res['item']['title'];
			} else {
				$this->err = '404';
			}
		} else {
			$this->err = '404';
		}
		return $res;
	}
}

?>