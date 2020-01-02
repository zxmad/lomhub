<?php

defined('MAD') or die('ERROR');

class Cat extends Core {

	public function main() {
		if (!empty($this->url[2])) {
			$cat = raw('SELECT * FROM `cat` WHERE `url`="'.$this->url[2].'"',1);
			if ($cat) {
				$res['title'] = $cat['name'];
				$subcat = raw('SELECT * FROM `subcat` WHERE `cat_id`='.$cat['id']);
				if ($subcat) {
					for ($i=0; $i < count($subcat); $i++) { 
						$subcat[$i]['filter'] = raw('SELECT * FROM `filter` WHERE `subcat_id`='.$subcat[$i]['id']);
						$subcat_ids .= $subcat[$i]['id'].', ';
						$subcat_id[$subcat[$i]['url']] = $subcat[$i]['id'];
						foreach ($subcat[$i]['filter'] as $filter) $filter_id[$filter['url']] = $filter['id'];
					}
					$res['subcat'] = $subcat;
				} else {
					$err = 1;
				}
			} else {
				$this->err = '404';
			}
			
			$res['show'] = (empty($this->url[3])) ? explode(',', strtolower(trim($subcat_ids, '')))[0] : $subcat_id[$this->url[3]];
			if (!empty($this->url[3])) {
				if (!$subcat_id[$this->url[3]]) {
					$this->err = '404';
				} else {
					$sql = '`subcat_id`='.$subcat_id[$this->url[3]];
					if (!empty($this->url[4])) {
						if (!$filter_id[$this->url[4]]) {
							$this->err = '404';
						} else {
							$sql .= ' AND `filters` LIKE "%'.$filter_id[$this->url[4]].'%"';
						}
					}
				}
			} else {
				$sql = '`subcat_id` IN('.substr($subcat_ids, 0, -2).')';
			}
			if (!$err) {
				$res['items'] = raw('SELECT * FROM `item` WHERE '.$sql);
				for ($i=0; $i < count($res['items']); $i++) { 
					$res['items'][$i]['photo'] = explode('~', strtolower(trim($res['items'][$i]['photos'])))[1];
				}
			}
		} else {
			$this->err = '404';
		}
		return $res;
	}
}

?>