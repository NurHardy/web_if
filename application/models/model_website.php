<?php
class Model_Website extends CI_Model{

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
			'f_desc'			=> null,
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
/* ------------------------------------------ ADMINISTRATION ------------------- */
	function user_authenticate($_username, $_md5pass) {
		$query = $this->db->query("SELECT * FROM t_users WHERE (f_username = ?) AND (f_password = ?)", array($_username, $_md5pass));

		if ($query->num_rows() == 1) return $query->result();
		else return null;
	}
}
