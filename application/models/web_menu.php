<?php
class web_menu extends CI_Model {
/* ------------------------------------------ MENU ------------------- */
	// Private
	function _process_children(&$buffer_, $data, $n_children, &$counter) {
		for ($c_=0; $c_<$n_children; $c_++) {
			$counter++;
			$buffer_ .= "<li>";
			if (!empty($data[$counter]['url'])) $buffer_ .= "<a href='".$data[$counter]['url']."'><span>".$data[$counter]['label']."</span></a>";
			else $buffer_ .= "<span>".htmlentities($data[$counter]['label'])."</span>";
			$buffer_ .= "\n";
			if ($data[$counter]['children'] > 0) {
				$buffer_ .= "<div><ul>";
				$this->_process_children($buffer_, $data, $data[$counter]['children'], $counter);
				$buffer_ .= "</ul></div>";
			};
			$buffer_ .= "</li>\n";
		}
	}
	
	function save_menu($JSONdata) {
		$json_data = $JSONdata;
		if (empty($json_data)) return "Empty query";
		$json_array = json_decode($json_data, true);
		$is_menu_valid = true;

		$menu_final = array(); // array final untuk menu
		if ($json_array == null) {
			if (json_last_error() != JSON_ERROR_NONE) {
				return "Error parsing JSON data...";
			}
		}

		if ($json_array[0]['level'] != 1) {
			return "Invalid menu structure (passed a level)";
		}

		if (count($json_array)>1) {
			// cek pohon
			for ($c_=0;$c_<count($json_array)-1;$c_++) {
				if (($json_array[$c_+1]['level']-$json_array[$c_]['level']) > 1) {
					$is_menu_valid = false;
				}
			}
			if (!$is_menu_valid) {
				return "Invalid menu structure (passed a level). Please check...";
			}
		}

		$nodes = 0;
		for ($c_=0;$c_<count($json_array);$c_++) {
			$parent = -1;
			if ($json_array[$c_]['level'] != 1) {
				$d_ = $c_-1;
				while (($d_ > 0) && ($json_array[$d_]['level'] >= $json_array[$c_]['level'])) $d_--;
				$parent = $d_;
				$menu_final[$parent]['children']++;
			} else $nodes++;
			$menu_final[] = array('label' => $json_array[$c_]['label'], 'url' => $json_array[$c_]['url'], 'parent' => $parent, 'children' => 0);
		}

		$counter_ = -1;
		$buffer__ = "";

		$buffer__ .= "<ul class='menu'>";
		$this->_process_children($buffer__, $menu_final, $nodes, $counter_);
		$buffer__ .= "</ul>\n";

		$file = fopen(FCPATH."/assets/menu.json","w");
		$status = fwrite($file,$json_data);
		fclose ($file);

		$file = fopen(FCPATH."/assets/menu.php","w");
		$status = fwrite($file,$buffer__);
		fclose ($file);

		return "OK";
	}
}