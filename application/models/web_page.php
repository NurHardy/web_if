<?php
class web_page extends CI_Model {
/* ------------------------------------------ PAGE -------------------*/
	function get_pages($_items = 15, $_page = 1) {
		$_start = ($_page-1)*$_items;
		$_query  = "SELECT * FROM t_page";
		$_query .= " ORDER BY f_id DESC LIMIT $_start, $_items";
		$query = $this->db->query($_query);
        return $query->result();
	}
	function get_page($page_id) {
		$_query = "SELECT * FROM t_page";
		if (is_numeric($page_id)) {
			if ($page_id <= 0) return null;
			$_query .= " WHERE f_id = $page_id";
		} else {
			$_permalnk = $this->db->escape_str($page_id);
			$_query .= " WHERE f_permalink = '$_permalnk'";
		}
		$query = $this->db->query($_query);
        return $query->row();
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
	
	function count_pages() {
		$_query  = "SELECT COUNT(*) AS _count FROM t_page";
		$query = $this->db->query($_query);
		$_res  = $query->row();
        return $_res->_count;
	}
	
	function check_permalink($_permalink, $_excp_id = -1) {
		$err_msg = null;
		if (preg_match('/^[-_a-zA-Z0-9]+$/', $_permalink)) {
			// cek ketersediaan
			$_plink =  $this->db->escape_str($_permalink);
			$_query = "SELECT f_id FROM t_page WHERE f_permalink = '$_plink'";
			$query = $this->db->query($_query);
			$_res  = $query->num_rows();
			if ($_res == 1) {
				$_resrw = $query->row();
				if ($_resrw->f_id != $_excp_id) {
					$_plink = htmlentities($_plink);
					$err_msg = "Permalink '{$_plink}' tidak tersedia. Silakan gunakan permalink lain.";
				}
			}
		} else {
			$err_msg = "Gunakan hanya karakter alfanumerik, strip ( - ) atau underscore ( _ )";
		}
		return $err_msg;
	}
}