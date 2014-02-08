<?php
class web_admin extends CI_Model {
/* ------------------------------------------ ADMINISTRATION ------------------- */
	function user_authenticate($_username, $_md5pass) {
		$query = $this->db->query("SELECT * FROM t_users WHERE (f_username = ?) AND (f_password = ?)", array($_username, $_md5pass));

		if ($query->num_rows() == 1) return $query->result();
		else return null;
	}
	
	function get_users($_items = 15, $_page = 1) {
		$_start = ($_page-1)*$_items;
		$_query  = "SELECT * FROM t_users LIMIT $_start, $_items";
		$query = $this->db->query($_query);
		
		return $query->result();
	}
	
	function count_users() {
		$_query  = "SELECT COUNT(*) AS _count FROM t_users";
		$query = $this->db->query($_query);
		$_res  = $query->row();
        return $_res->_count;
	}
}
