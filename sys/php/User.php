<?php

defined('MAD') or die('ERROR');

class User extends Core {
	
	public function main() {
		if (!isset($_SESSION['user'])) {
			if (!empty($_POST['token'])) {
				$s = file_get_contents('http://ulogin.ru/token.php?token='.$_POST['token'].'&host='.$_SERVER['HTTP_HOST']);
				$user = json_decode($s, true);
				$user_info = raw('SELECT * FROM `user` WHERE `uid`='.$user['uid'],1);
				if (!$user_info) {
					$add_user = raw('INSERT INTO `user`(`uid`, `first_name`, `last_name`, `city`, `email`, `profile`) VALUES ("'.$user['uid'].'","'.$user['first_name'].'","'.$user['last_name'].'","'.$user['city'].'","'.$user['email'].'","'.$user['profile'].'")',2);
					$user_info = raw('SELECT * FROM `user` WHERE `uid`='.$user['uid'],1);
				}
				$_SESSION['user'] = $user;
				$_SESSION['user']['id'] = $user_info['id'];
				$_SESSION['user']['type'] = $user_info['type'];
				$_SESSION['user']['email'] = $user_info['email'];
				$_SESSION['user']['first_name'] = $user_info['first_name'];
				$_SESSION['user']['last_name'] = $user_info['last_name'];
				$_SESSION['user']['city'] = $user_info['city'];
				switch ($user_info['type']) {
					case '0': $_SESSION['user']['home'] = '/user/bookmark/'; break;
					case '1': $_SESSION['user']['home'] = '/user/admin/'; break;
					case '2': $_SESSION['user']['home'] = '/shop/item/'; break;
					default: $_SESSION['user']['home'] = ''; break;
				}
				if (($user_info['type'] == 2) and ($user_info['lom_id'] != NULL)) {
					$_SESSION['user']['lom_id'] = $user_info['lom_id'];
				}
				header('Location: '.$_SESSION['user']['home']);
			} else {
				$this->err = 'auth';
			}
		} else {
			header('Location: '.$_SESSION['user']['home']);
		}
		return $res;
	}

	public function bookmark() {
		if (isset($_SESSION['user'])) {
			$res['title'] = $_SESSION['user']['first_name'] . ' ' . $_SESSION['user']['last_name'];
			$res['user'] = $_SESSION['user'];

			$items = raw('SELECT * FROM `bookmark` WHERE `user_id`='.$res['user']['uid']);
			if ($items) {
				$res['items'] = $items;
				for ($i=0; $i < count($items); $i++) { 
					$res['items'][$i]['item'] = raw('SELECT * FROM `item` WHERE `id`='.$items[$i]['item_id'],1);
					$res['items'][$i]['item']['photo'] = explode('~', strtolower(trim($res['items'][$i]['item']['photos'])))[1];
				}
			}
		} else {
			header('Location: /user/');
		}
		return $res;
	}

	public function settings() {
		if (isset($_SESSION['user'])) {
			$res['title'] = $_SESSION['user']['first_name'] . ' ' . $_SESSION['user']['last_name'] . ' / Настройки';
			$res['user'] = $_SESSION['user'];
			$res['usr'] = raw('SELECT * FROM `user` WHERE `id`='.$res['user']['id'],1);
			if (isset($_POST['save'])) {
				$first_name = (!empty($_POST['first_name'])) ? trim(htmlspecialchars($_POST['first_name'])) : null;
				$last_name = (!empty($_POST['last_name'])) ? trim(htmlspecialchars($_POST['last_name'])) : null;
				$city = (!empty($_POST['city'])) ? trim(htmlspecialchars($_POST['city'])) : null;
				$email = (!empty($_POST['email'])) ? trim(htmlspecialchars($_POST['email'])) : null;
				if (($first_name != null) and ($last_name != null) and ($city != null) and ($email != null)) {
					$save = raw('UPDATE `user` SET `first_name`="'.$first_name.'",`last_name`="'.$last_name.'",`city`="'.$city.'",`email`="'.$email.'" WHERE `id`='.$res['usr']['id'],2);
					$_SESSION['user']['first_name'] = $first_name;
					$_SESSION['user']['last_name'] = $last_name;
					$_SESSION['user']['city'] = $city;
					$_SESSION['user']['email'] = $email;
					header('Location: /user/settings/');
				} else {
					header('Location: /user/settings/');
				}
			}
		} else {
			header('Location: /user/');
		}
		return $res;
	}

	public function admin() {
		if ($_SESSION['user']['type'] != 1) header('Location: '.$_SESSION['user']['home']);
		$res['title'] = 'Разделы';
		$res['Cat'] = $this->cat;
		for ($i=0; $i < count($res['Cat']); $i++) { 
			$res['Cat'][$i]['subcat'] = raw('SELECT * FROM `subcat` WHERE `cat_id`='.$res['Cat'][$i]['id']);
		}
		if (isset($_GET['add_cat'])) {
			$res['subtitle'] = 'Добавить раздел';
			if (isset($_POST['save_admin'])) {
				$url = (!empty($_POST['url'])) ? trim(htmlspecialchars($_POST['url'])) : null;
				$name = (!empty($_POST['name'])) ? trim(htmlspecialchars($_POST['name'])) : null;
				$ico = (!empty($_POST['ico'])) ? trim(htmlspecialchars($_POST['ico'])) : 'fa fa-list text-secondary';
				if (($url != null) and ($name != null)) {
					$add_cat = raw('INSERT INTO `cat`(`url`, `name`, `ico`) VALUES ("'.$url.'","'.$name.'","'.$ico.'")',2);
					if ($add_cat) header('Location: /user/admin/');
				}
			}
		} elseif (is_numeric($_GET['add_subcat'])) {
			$res['subtitle'] = 'Добавить подраздел';
			$res['scat'] = raw('SELECT * FROM `cat` WHERE `id`='.$_GET['add_subcat'],1);
			if (!$res['scat']) header('Location: /user/admin/');
			if (isset($_POST['save_admin'])) {
				$url = (!empty($_POST['url'])) ? trim(htmlspecialchars($_POST['url'])) : null;
				$name = (!empty($_POST['name'])) ? trim(htmlspecialchars($_POST['name'])) : null;
				$ico = (!empty($_POST['ico'])) ? trim(htmlspecialchars($_POST['ico'])) : 'fa fa-list text-secondary';
				if (($url != null) and ($name != null)) {
					$add_subcat = raw('INSERT INTO `subcat`(`url`, `name`, `cat_id`, `ico`) VALUES ("'.$url.'","'.$name.'","'.$_GET['add_subcat'].'","'.$ico.'")',2);
					if ($add_subcat) header('Location: /user/admin/');
				}
			}
		} elseif (is_numeric($_GET['add_filter'])) {
			$res['subtitle'] = 'Добавить фильтр';
			$res['filters'] = raw('SELECT * FROM `filter` WHERE `subcat_id`='.$_GET['add_filter']);
			$res['scat'] = raw('SELECT * FROM `subcat` WHERE `id`='.$_GET['add_filter']);
			if (!$res['scat']) header('Location: /user/admin/');
			if (isset($_POST['save_admin'])) {
				$url = (!empty($_POST['url'])) ? trim(htmlspecialchars($_POST['url'])) : null;
				$name = (!empty($_POST['name'])) ? trim(htmlspecialchars($_POST['name'])) : null;
				if (($url != null) and ($name != null)) {
					$add_filter = raw('INSERT INTO `filter`(`name`, `subcat_id`, `url`) VALUES ("'.$name.'","'.$_GET['add_filter'].'","'.$url.'")',2);
					if ($add_filter) header('Location: /user/admin/');
				}
			}
		} elseif (is_numeric($_GET['edit_cat'])) {
			$res['subtitle'] = 'Редактировать раздел';
			$res['scat'] = raw('SELECT * FROM `cat` WHERE `id`='.$_GET['edit_cat'],1);
			if (!$res['scat']) header('Location: /user/admin/');
			if (isset($_POST['save_admin'])) {
				$url = (!empty($_POST['url'])) ? trim(htmlspecialchars($_POST['url'])) : null;
				$name = (!empty($_POST['name'])) ? trim(htmlspecialchars($_POST['name'])) : null;
				$ico = (!empty($_POST['ico'])) ? trim(htmlspecialchars($_POST['ico'])) : 'fa fa-list text-secondary';
				if (($url != null) and ($name != null)) {
					$edit_cat = raw('UPDATE `cat` SET `url`="'.$url.'",`name`="'.$name.'",`ico`="'.$ico.'" WHERE `id`='.$_GET['edit_cat'],2);
					if ($edit_cat) header('Location: /user/admin/');
				}
			}
		} elseif (is_numeric($_GET['edit_subcat'])) {
			$res['subtitle'] = 'Редактировать подраздел';
			$res['scat'] = raw('SELECT * FROM `subcat` WHERE `id`='.$_GET['edit_subcat'],1);
			if (!$res['scat']) header('Location: /user/admin/');
			if (isset($_POST['save_admin'])) {
				$url = (!empty($_POST['url'])) ? trim(htmlspecialchars($_POST['url'])) : null;
				$name = (!empty($_POST['name'])) ? trim(htmlspecialchars($_POST['name'])) : null;
				$ico = (!empty($_POST['ico'])) ? trim(htmlspecialchars($_POST['ico'])) : 'fa fa-list text-secondary';
				if (($url != null) and ($name != null)) {
					$edit_cat = raw('UPDATE `subcat` SET `url`="'.$url.'",`name`="'.$name.'", `ico`="'.$ico.'" WHERE `id`='.$_GET['edit_subcat'],2);
					if ($edit_cat) header('Location: /user/admin/');
				}
			}
			
		} elseif (is_numeric($_GET['edit_filter'])) {
			$res['subtitle'] = 'Редактировать фильтр';
			$res['scat'] = raw('SELECT * FROM `filter` WHERE `id`='.$_GET['edit_filter'],1);
			if (!$res['scat']) header('Location: /user/admin/');
			if (isset($_POST['save_admin'])) {
				$url = (!empty($_POST['url'])) ? trim(htmlspecialchars($_POST['url'])) : null;
				$name = (!empty($_POST['name'])) ? trim(htmlspecialchars($_POST['name'])) : null;
				if (($url != null) and ($name != null)) {
					$edit_filter = raw('UPDATE `filter` SET `name`="'.$name.'",`url`="'.$url.'" WHERE `id`='.$_GET['edit_filter'],2);
					if ($edit_filter) header('Location: /user/admin/?add_filter='.$res['scat']['subcat_id']);
				}
			}
		} elseif (is_numeric($_GET['del_cat'])) {
			$del_cat = raw('DELETE FROM `cat` WHERE `id`='.$_GET['del_cat'],2);
			$scats = raw('SELECT * FROM `subcat` WHERE `cat_id`='.$_GET['del_cat']);
			if ($scats) {
				foreach ($scats as $sc) {
					$del_sc = raw('DELETE FROM `subcat` WHERE `id`='.$sc['id'],2);
				}
			}
			header('Location: /user/admin/');
		} elseif (is_numeric($_GET['del_subcat'])) {
			$del_subcat = raw('DELETE FROM `subcat` WHERE `id`='.$_GET['del_subcat'],2);
			header('Location: /user/admin/');
		} elseif (is_numeric($_GET['del_filter'])) {
			$del_filter = raw('DELETE FROM `filter` WHERE `id`='.$_GET['del_filter'],2);
			header('Location: /user/admin/');
		}
		return $res;
	}

	public function ad() {
		if ($_SESSION['user']['type'] != 1) header('Location: '.$_SESSION['user']['home']);
		$res['title'] = 'Реклама';
		$res['ad'] = raw('SELECT * FROM `reklama` ORDER BY `id` DESC');
		if (is_numeric($_GET['edit_ad'])) {
			$res['subtitle'] = 'Редактировать';
			$res['ad1'] = raw('SELECT * FROM `reklama` WHERE `id`='.$_GET['edit_ad'],1);
			if (!$res['ad1']) header('Location: /user/ad/');
			if (isset($_POST['add_ad'])) {
				$title = (!empty($_POST['title'])) ? trim(htmlspecialchars($_POST['title'])) : null;
				$info = (!empty($_POST['info'])) ? trim(htmlspecialchars($_POST['info'])) : null;
				$url = (!empty($_POST['url'])) ? trim(htmlspecialchars($_POST['url'])) : null;
				if (!empty($_FILES)) {
					$uploaddir = $_SERVER['DOCUMENT_ROOT'].'/src/img/other/';
					$filename = $i . '_' . time() . '.png';
					if (move_uploaded_file($_FILES['photo']['tmp_name'][$i], $uploaddir.$filename)) {
						$photo = $filename;
					}
				}
				$photo = (!empty($photo)) ? $photo : $res['ad1']['photo'];
				if (($title != null) and ($info != null) and ($url != null)) {
					$set_ad = raw('UPDATE `reklama` SET `title`="'.$title.'",`info`="'.addslashes($info).'",`photo`="'.$photo.'",`url`="'.$url.'" WHERE `id`='.$_GET['edit_ad'],2);
				}
				header('Location: /user/ad/');
			}
		} elseif (is_numeric($_GET['del_ad'])) {
			$del = raw('DELETE FROM `reklama` WHERE `id`='.$_GET['del_ad'],2);
			header('Location: /user/ad/');
		} else {
			if (isset($_POST['add_ad'])) {
				$title = (!empty($_POST['title'])) ? trim(htmlspecialchars($_POST['title'])) : null;
				$info = (!empty($_POST['info'])) ? trim(htmlspecialchars($_POST['info'])) : null;
				$url = (!empty($_POST['url'])) ? trim(htmlspecialchars($_POST['url'])) : null;
				if (!empty($_FILES)) {
					$uploaddir = $_SERVER['DOCUMENT_ROOT'].'/src/img/other/';
					$filename = $i . '_' . time() . '.png';
					if (move_uploaded_file($_FILES['photo']['tmp_name'][$i], $uploaddir.$filename)) {
						$photo = $filename;
					}
				}
				$photo = (!empty($photo)) ? $photo : 'no_photo_ad.png';
				if (($title != null) and ($info != null) and ($url != null)) {
					$add_ad = raw('INSERT INTO `reklama`(`title`, `info`, `photo`, `url`) VALUES ("'.$title.'","'.addslashes($info).'","'.$photo.'","'.$url.'")',2);
				}
				header('Location: /user/ad/');
			}
		}
		return $res;
	}

	public function text() {
		if ($_SESSION['user']['type'] != 1) header('Location: '.$_SESSION['user']['home']);
		$res['title'] = 'Тексты';
		$res['text'] = raw('SELECT * FROM `info`');
		if (is_numeric($_GET['edit_text'])) {
			$res['subtitle'] = 'Редактировать';
			$res['text'] = raw('SELECT * FROM `info` WHERE `id`='.$_GET['edit_text'],1);
			if (!$res['text']) header('Location: /user/text/');
			if (isset($_POST['save_text'])) {
				$title = (!empty($_POST['title'])) ? trim(htmlspecialchars($_POST['title'])) : null;
				$text = (!empty($_POST['text'])) ? trim(htmlspecialchars($_POST['text'])) : null;
				$url = (!empty($_POST['url'])) ? trim(htmlspecialchars($_POST['url'])) : null;
				if (($title != null) and ($text != null) and ($url != null)) {
					$save_text = raw('UPDATE `info` SET `title`="'.$title.'",`text`="'.addslashes($text).'",`url`="'.$url.'" WHERE `id`='.$_GET['edit_text'],2);
				}
				header('Location: /user/text/');
			}
		} elseif (is_numeric($_GET['del_text'])) {
			$del = raw('DELETE FROM `info` WHERE `id`='.$_GET['del_text'],2);
			header('Location: /user/text/');
		} else {
			if (isset($_POST['save_text'])) {
				$title = (!empty($_POST['title'])) ? trim(htmlspecialchars($_POST['title'])) : null;
				$text = (!empty($_POST['text'])) ? trim(htmlspecialchars($_POST['text'])) : null;
				$url = (!empty($_POST['url'])) ? trim(htmlspecialchars($_POST['url'])) : null;
				if (($title != null) and ($text != null) and ($url != null)) {
					$save_text = raw('INSERT INTO `info`(`title`, `text`, `url`) VALUES ("'.$title.'","'.addslashes($text).'","'.$url.'")',2);
				}
				header('Location: /user/text/'.$url.'/');
			}
		}
		return $res;
	}

	public function poster() {
		if ($_SESSION['user']['type'] != 1) header('Location: '.$_SESSION['user']['home']);
		$res['title'] = 'Постеры';
		$res['poster'] = raw('SELECT * FROM `poster`');
		if (is_numeric($_GET['set_poster'])) {
			$res['pstr'] = raw('SELECT * FROM `poster` WHERE `id`='.$_GET['set_poster'],1);
			if (!$res['pstr']) header('Location: /user/poster/');
			$set = raw('UPDATE `poster` SET `home`="1" WHERE `id`='.$_GET['set_poster'],2);
			header('Location: /user/poster/');
		} elseif (is_numeric($_GET['unset_poster'])) {
			$res['pstr'] = raw('SELECT * FROM `poster` WHERE `id`='.$_GET['unset_poster'],1);
			if (!$res['pstr']) header('Location: /user/poster/');
			$unset = raw('UPDATE `poster` SET `home`="0" WHERE `id`='.$_GET['unset_poster'],2);
			header('Location: /user/poster/');
		} elseif (is_numeric($_GET['edit_poster'])) {
			$res['pstr'] = raw('SELECT * FROM `poster` WHERE `id`='.$_GET['edit_poster'],1);
			if (!$res['pstr']) header('Location: /user/poster/');
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
					$set_ad = raw('UPDATE `poster` SET `url`="'.$url.'",`text`="'.addslashes($text).'",`image`="'.$image.'" WHERE `id`='.$_GET['edit_poster'],2);
				}
				header('Location: /user/poster/');
			}
		} elseif (is_numeric($_GET['del_poster'])) {
			$del = raw('DELETE FROM `poster` WHERE `id`='.$_GET['del_poster'],2);
			header('Location: /user/poster/');
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
					$add = raw('INSERT INTO `poster`(`url`, `text`, `image`) VALUES ("'.$url.'","'.addslashes($text).'","'.$image.'","'.$url.'")',2);
				}
				header('Location: /user/poster/');
			}
		}
		return $res;
	}

	public function sign_out() {
		session_destroy();
		header('Location: /');
		return 0;
	}

}

?>