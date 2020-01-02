<?php

defined('MAD') or die('ERROR');

class Shop extends Core {

	public function main() {
		if (!empty($this->url[2])) {
			$id = explode('-', strtolower(trim($this->url[2])))[0];
			$res['lombard'] = raw('SELECT * FROM `lombard` WHERE `id`='.$id,1);
			if (!$res['lombard']) header('Location: /');
			$res['title'] = $res['lombard']['name'];
			$res['items'] = raw('SELECT * FROM `item` WHERE `lom_id`='.$id);
			for ($i=0; $i < count($res['items']); $i++) { 
				$res['items'][$i]['photo'] = explode('~', strtolower(trim($res['items'][$i]['photos'])))[1];
			}
			$res['poster'] = raw('SELECT * FROM `poster` WHERE `lom_id`='.$id);
		} else {
			header('Location: /');
		}
		return $res;
	}

	public function lombard() {
		if ($_SESSION['user']['type'] != 2) header('Location: '.$_SESSION['user']['home']);
		$res['lom'] = raw('SELECT * FROM `lombard` WHERE `id`='.$_SESSION['user']['lom_id'],1);
		if (!$res['lom']) header('Location: /user/bookmark/');
		$res['title'] = $res['lom']['name'];
		if (isset($_GET['edit_lom'])) {
			$res['subtitle'] = 'Редактировать информацию';
			if (isset($_POST['save_lom'])) {
				$name = (!empty($_POST['name'])) ? trim(htmlspecialchars($_POST['name'])) : null;
				$phone = (!empty($_POST['phone'])) ? trim(htmlspecialchars($_POST['phone'])) : null;
				$address = (!empty($_POST['address'])) ? trim(htmlspecialchars($_POST['address'])) : null;
				if (!empty($_FILES)) {
					$uploaddir = $_SERVER['DOCUMENT_ROOT'].'/src/img/photo/';
					$filename = $i . '_' . time() . '.png';
					if (move_uploaded_file($_FILES['photo']['tmp_name'][$i], $uploaddir.$filename)) {
						$photo = $filename;
					}
				}
				$photo = (!empty($photo)) ? $photo : $res['lom']['photo'];
				if (($name != null) and ($phone != null) and ($address != null)) {
					$save_lom = raw('UPDATE `lombard` SET `name`="'.$name.'",`phone`="'.$phone.'",`photo`="'.$photo.'",`address`="'.$address.'" WHERE `id`='.$res['lom']['id'],2);
				}
				header('Location: /shop/lombard/');
			}
		}
		return $res;
	}

	public function item() {
		if ($_SESSION['user']['type'] != 2) header('Location: '.$_SESSION['user']['home']);
		$res['title'] = 'Товары';
		$res['subcat'] = $this->cat;
		for ($i=0; $i < count($res['subcat']); $i++) { 
			$res['subcat'][$i]['subcat'] = raw('SELECT * FROM `subcat` WHERE `cat_id`='.$res['subcat'][$i]['id']);
		}
		if (is_numeric($_GET['add_item'])) { //ДОБАВИТЬ ТОВАР
			$res['scat'] = raw('SELECT * FROM `subcat` WHERE `id`='.$_GET['add_item'],1);
			if (!$res['scat']) header('Location: '.$_SESSION['user']['home']);
			$res['subtitle'] = 'Добавить товар';
			$res['scat']['filter'] = raw('SELECT * FROM `filter` WHERE `subcat_id`='.$_GET['add_item']);
			if (isset($_POST['add_item_btn'])) {
				$title = (!empty($_POST['title'])) ? trim(htmlspecialchars($_POST['title'])) : null;
				$info = (!empty($_POST['info'])) ? trim(htmlspecialchars($_POST['info'])) : null;
				$price = (!empty($_POST['price']) and is_numeric($_POST['price'])) ? trim(htmlspecialchars($_POST['price'])) : null;
				$lom_id = (is_numeric($_POST['lom_id'])) ? trim(htmlspecialchars($_POST['lom_id'])) : null;
				$subcat_id = (is_numeric($_POST['subcat_id'])) ? trim(htmlspecialchars($_POST['subcat_id'])) : null;
				if (!empty($_POST['filter'])) {
					foreach ($_POST['filter'] as $f) $filters .= ';'.$f;
				}
				if (!empty($_FILES)) {
					for ($i=0; $i < count($_FILES['photos']['name']); $i++) { 
						$uploaddir = $_SERVER['DOCUMENT_ROOT'].'/src/img/product/';
						$filename = $i . '_' . time() . '.png';
						if (move_uploaded_file($_FILES['photos']['tmp_name'][$i], $uploaddir.$filename)) {
							$photos .= '~'.$filename;
						}
					}
				}
				$photos = (!empty($photos)) ? $photos : '~no_photo.png';
				if (($title != null) and ($info != null) and ($price != null) and ($lom_id != null) and ($subcat_id != null)) {
					$add_item = raw('INSERT INTO `item`(`title`, `info`, `price`, `subcat_id`, `lom_id`, `filters`, `photos`) VALUES ("'.$title.'","'.addslashes($info).'","'.$price.'","'.$subcat_id.'","'.$lom_id.'","'.$filters.'","'.$photos.'")',2);
					header('Location: '.$_SESSION['user']['home']);
				} else {
					header('Location: '.$_SESSION['user']['home']);
				}
			}
		} elseif (is_numeric($_GET['del_item'])) { // УДАЛИТЬ ТОВАР
			$res['item'] = raw('SELECT * FROM `item` WHERE `id`='.$_GET['del_item'],1);
			if ((!$res['item']) or ($_SESSION['user']['lom_id'] != $res['item']['lom_id'])) {
				header('Location: '.$_SESSION['user']['home']);
			} else {
				$del = raw('DELETE FROM `item` WHERE `id`='.$_GET['del_item'],2);
				header('Location: '.$_SESSION['user']['home']);
			}
		} elseif (is_numeric($_GET['edit_item'])) { // РЕДАКТИРОВАТЬ ТОВАР
			$res['item'] = raw('SELECT * FROM `item` WHERE `id`='.$_GET['edit_item'],1);
			if ((!$res['item']) or ($_SESSION['user']['lom_id']!=$res['item']['lom_id'])) header('Location: '.$_SESSION['user']['home']);
			$res['subtitle'] = 'Редактировать товар';
			// Для отображения фильтров
			$res['item']['filter'] = explode(';', strtolower(trim($res['item']['filters'])));
			unset($res['item']['filter'][0]);
			if (!empty($res['item']['filter'])) {
				for ($i=1; $i <= count($res['item']['filter']); $i++) { 
					$res['item']['filter'][$i] = raw('SELECT * FROM `filter` WHERE `id`='.$res['item']['filter'][$i],1);
				}
			}
			// Для подкатегории
			$res['scat'] = raw('SELECT * FROM `subcat` WHERE `id`='.$res['item']['subcat_id'],1);
			if (!$res['scat']) header('Location: '.$_SESSION['user']['home']);
			$res['scat']['filter'] = raw('SELECT * FROM `filter` WHERE `subcat_id`='.$res['item']['subcat_id']);
			// РЕДАКТИРОВАНИЕ
			if (isset($_POST['add_item_btn'])) {
				$title = (!empty($_POST['title'])) ? trim(htmlspecialchars($_POST['title'])) : null;
				$info = (!empty($_POST['info'])) ? trim(htmlspecialchars($_POST['info'])) : null;
				$price = (!empty($_POST['price']) and is_numeric($_POST['price'])) ? trim(htmlspecialchars($_POST['price'])) : null;
				if (!empty($_POST['filter'])) {
					foreach ($_POST['filter'] as $f) {
						$filters .= ';'.$f;
					}
				}
				if (($title != null) and ($info != null) and ($price != null) and ($lom_id != null) and ($subcat_id != null)) {
					$sql = 'UPDATE `item` SET `title`="'.$title.'",`info`="'.addslashes($info).'",`price`="'.$price.'",`filters`="'.$filters.'" WHERE `id`='.$_GET['edit_item'];
					$set = raw($sql,2);
					header('Location: /');
				}			
			}
		}
		return $res;
	}

	public function poster() {
		if ($_SESSION['user']['type'] != 2) header('Location: '.$_SESSION['user']['home']);
		$res['title'] = 'Постеры';
		$res['poster'] = raw('SELECT * FROM `poster` WHERE `lom_id`='.$_SESSION['user']['lom_id']);
		if (is_numeric($_GET['set_poster'])) {
			$res['pstr'] = raw('SELECT * FROM `poster` WHERE `lom_id`="'.$_SESSION['user']['lom_id'].'" AND `id`='.$_GET['set_poster'],1);
			if (!$res['pstr']) header('Location: /shop/poster/');
			$set = raw('UPDATE `poster` SET `home`="1" WHERE `lom_id`="'.$_SESSION['user']['lom_id'].'" AND `id`='.$_GET['set_poster'],2);
			header('Location: /shop/poster/');
		} elseif (is_numeric($_GET['unset_poster'])) {
			$res['pstr'] = raw('SELECT * FROM `poster` WHERE `lom_id`="'.$_SESSION['user']['lom_id'].'" AND `id`='.$_GET['unset_poster'],1);
			if (!$res['pstr']) header('Location: /shop/poster/');
			$unset = raw('UPDATE `poster` SET `home`="0" WHERE `lom_id`="'.$_SESSION['user']['lom_id'].'" AND `id`='.$_GET['unset_poster'],2);
			header('Location: /shop/poster/');
		} elseif (is_numeric($_GET['edit_poster'])) {
			$res['pstr'] = raw('SELECT * FROM `poster` WHERE `lom_id`="'.$_SESSION['user']['lom_id'].'" AND `id`='.$_GET['edit_poster'],1);
			if (!$res['pstr']) header('Location: /shop/poster/');
			$res['subtitle'] = 'Редактировать постер';
			if (isset($_POST['ok_poster'])) {
				$url = (!empty($_POST['url'])) ? trim(htmlspecialchars($_POST['url'])) : null;
				$text = (!empty($_POST['text'])) ? trim(htmlspecialchars($_POST['text'])) : null;
				if (!empty($_FILES)) {
					$uploaddir = $_SERVER['DOCUMENT_ROOT'].'/src/img/poster/';
					$filename = $i . '_' . time() . '.png';
					if (move_uploaded_file($_FILES['image']['tmp_name'][$i], $uploaddir.$filename)) {
						$image = $filename;
					}
				}
				$image = (!empty($image)) ? $image : $res['pstr']['image'];
				if (($url != null) and ($text != null)) {
					$set_ad = raw('UPDATE `poster` SET `url`="'.$url.'",`text`="'.addslashes($text).'",`image`="'.$image.'" WHERE `lom_id`="'.$_SESSION['user']['lom_id'].'" AND `id`='.$_GET['edit_poster'],2);
				}
				header('Location: /shop/poster/');
			}
		} elseif (is_numeric($_GET['del_poster'])) {
			$del = raw('DELETE FROM `poster` WHERE `lom_id`="'.$_SESSION['user']['lom_id'].'" AND `id`='.$_GET['del_poster'],2);
			header('Location: /shop/poster/');
		} else {
			if (isset($_POST['ok_poster'])) {
				$url = (!empty($_POST['url'])) ? trim(htmlspecialchars($_POST['url'])) : null;
				$text = (!empty($_POST['text'])) ? trim(htmlspecialchars($_POST['text'])) : null;
				if (!empty($_FILES)) {
					$uploaddir = $_SERVER['DOCUMENT_ROOT'].'/src/img/poster/';
					$filename = $i . '_' . time() . '.png';
					if (move_uploaded_file($_FILES['image']['tmp_name'][$i], $uploaddir.$filename)) {
						$image = $filename;
					}
				}
				$image = (!empty($image)) ? $image : 'no_poster.png';
				if (($url != null) and ($text != null)) {
					$add = raw('INSERT INTO `poster`(`url`,`text`,`image`,`lom_id`) VALUES ("'.$url.'","'.addslashes($text).'","'.$image.'","'.$url.'","'.$_SESSION['user']['lom_id'].'")',2);
				}
				header('Location: /shop/poster/');
			}
		}
		return $res;
	}

}

?>