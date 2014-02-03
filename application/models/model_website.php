<?php
class Model_Website extends CI_Model{

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

/* ------------------------------------------ POSTING -------------------*/
	function get_post($post_id) {
		if ((!is_numeric($post_id)) || ($post_id <= 0)) return null;
		$_query  = "SELECT * FROM t_posts WHERE id_berita = $post_id";
		
		$query = $this->db->query($_query);
        return $query->result();
	}
	function save_post($_title, $_content, $_category, $_id_creator, $_creator, $_publish = true, $_id = -1) {
		$_query_data = array(
			'judul'			=> $_title,		// tidak perlu htmlentities
			'isi_berita'	=> $_content,
			'tanggal_edit'	=> null,
			'creator'		=> $_creator,	// creator sudah dalam htmlentities
			'id_creator'	=> $_id_creator,
			'status'		=> ($_publish?1:0)
		);
		if ($_id > 0) {
			$_query_data['tanggal_edit'] = date('Y-m-d H:i:s');
			$this->db->where('id_berita', $_id);
			$this->db->update('t_posts', $_query_data); 
		} else {
			$_query_data['tanggal'] = date('Y-m-d H:i:s');
			$this->db->insert('t_posts', $_query_data);
		}
		if ($this->db->affected_rows() == 0) return false;
		return true;
	}
	function get_newest_posts($total = 5, $category = null) {
		$news_table		= 't_posts';
		$news_id_field  = 'id_berita';
		$news_cat_field	= 'id_kategori';
		
		$_total = ($total <= 0 ? 5 : $total);
		
		$_query  = "SELECT * FROM $news_table";
		
		if (!empty($category)) $_query .= " WHERE $news_cat_field = $category";
		
		$_query .= " ORDER BY $news_id_field DESC LIMIT $_total";
		$query = $this->db->query($_query);
        return $query->result();
	}

/* ------------------------------------------ EVENT -------------------*/
	function get_nearest_event($total = 5) {
		$_total = ($total <= 0 ? 5 : $total);
		
		$_query  = "SELECT * FROM t_event";
		
		$_query .= " WHERE (f_date >= NOW()) ORDER BY f_date LIMIT $_total";
		$query = $this->db->query($_query);
		
        return $query->result();
	}
	function save_event($_ev_date, $_name, $_id_creator, $_creator, $_desc = null, $_publish = true, $_id = -1) {
		
		$_query_data = array(
			'f_name'			=> $_name,
			'f_date'			=> $_ev_date,
			'f_desc'			=> $_desc,
			'f_id_creator'		=> $_id_creator,
			'f_creator'			=> $_creator,
			'f_status'			=> ($_publish ? 1 : 0)
		);
		if ($_id > 0) {
			$_query_data['f_date_edit'] = date('Y-m-d H:i:s');
			$this->db->where('f_id', $_id);
			$this->db->update('t_event', $_query_data); 
		} else {
			$_query_data['f_date_submit'] = date('Y-m-d H:i:s');
			$this->db->insert('t_event', $_query_data);
		}
		if ($this->db->affected_rows() == 0) return false;
		return true;
	}
	function get_event_json($_month, $_year) {
		$JSON_result = array();
		$query_tampil = sprintf("SELECT * FROM t_event WHERE MONTH(f_date)=%d AND YEAR(f_date)=%d ORDER BY DAY(f_date)",$_month,$_year);
		$tampil = $this->db->query($query_tampil);
		$tampilres = $tampil->result();
		$event_count = $tampil->num_rows();
		if ($event_count != 0) {
			foreach ($tampilres as $_ev) {
				$ev_date = date_parse($_ev->f_date);
				$JSON_result[] = array('ev_id' => $_ev->f_id, 'ev_date' => $ev_date['day'], 'ev_desc' => $_ev->f_name);
			}
		}
		return (json_encode($JSON_result));
	}
/* ------------------------------------------ LINK ------------------- */
	function get_links($total = -1) {
		$_query  = "SELECT * FROM t_link";
		
		if ($total > 0) $_query .= " LIMIT $total";
		
		$query = $this->db->query($_query);
        return $query->result();
	}
	
	function get_link($link_id) {
		if ((!is_numeric($link_id)) || ($link_id <= 0)) return null;
		$query = $this->db->query("SELECT * FROM t_link WHERE f_id = $link_id");
        return $query->result();
	}
	
	function save_link($_name, $_url, $_id_creator, $_creator, $_id = -1) {
		$_query_data = array(
			'f_name'			=> $_name,
			'f_url'				=> $_url,
			'f_creator'			=> $_creator,
			'f_id_creator'		=> $_id_creator,
		);
		if ($_id > 0) {
			$this->db->where('f_id', $_id);
			$this->db->update('t_link', $_query_data); 
		} else {
			$_query_data['f_date_submit'] = date('Y-m-d H:i:s');
			$this->db->insert('t_link', $_query_data);
		}
		if ($this->db->affected_rows() == 0) return false;
		return true;
	}
/* ------------------------------------------ MEDIA ------------------- */
	function get_media($_items = 15, $_page = 1) {
		$_start = ($_page-1)*$_items;
		$_query  = "SELECT * FROM t_media LIMIT $_start, $_items";
		$query = $this->db->query($_query);
        return $query->result();
	}
/* ------------------------------------------ PAGE ------------------- */
	function get_pages($_items = 15, $_page = 1) {
		$_start = ($_page-1)*$_items;
		$_query  = "SELECT * FROM t_page";
		$_query .= " ORDER BY f_id DESC LIMIT $_start, $_items";
		$query = $this->db->query($_query);
        return $query->result();
	}
	function get_page($page_id) {
		if ((!is_numeric($page_id)) || ($page_id <= 0)) return null;
		$query = $this->db->query("SELECT * FROM t_page WHERE f_id = $page_id");
        return $query->result();
	}
	function save_page($_title, $_permalink, $_content, $_id_creator, $_creator, $_publish = true, $_id = -1) {
		$_query_data = array(
			'f_title'		=> $_title,		// tidak perlu htmlentities
			'f_content'		=> $_content,
			'f_permalink'	=> $_permalink,
			'f_creator'		=> $_creator,	// creator sudah dalam htmlentities
			'f_id_creator'	=> $_id_creator,
			'f_status'		=> ($_publish?1:0)
		);
		if ($_id > 0) {
			$_query_data['f_date_edit'] = date('Y-m-d H:i:s');
			$this->db->where('f_id', $_id);
			$this->db->update('t_page', $_query_data); 
		} else {
			$_query_data['f_date_submit'] = date('Y-m-d H:i:s');
			$this->db->insert('t_page', $_query_data);
		}
		if ($this->db->affected_rows() == 0) return false;
		return true;
	}
/* ------------------------------------------ MENU ------------------- */
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
/* ------------------------------------------ ADMINISTRATION ------------------- */
	function user_authenticate($_username, $_md5pass) {
		$query = $this->db->query("SELECT * FROM t_users WHERE (f_username = ?) AND (f_password = ?)", array($_username, $_md5pass));

		if ($query->num_rows() == 1) return $query->result();
		else return null;
	}
}
