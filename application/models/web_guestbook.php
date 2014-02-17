<?php
class web_guestbook extends CI_Model {
/* ------------------------------------------ WEBSITE GUESTBOOK ------------------- */
	function get_messages($_items = 15, $_page = 1, $_category = -1) {
		$_start = ($_page-1)*$_items;
		$_query  = "SELECT * FROM t_guestbook";
		if ($_category >= 0) $_query .= " WHERE f_read = $_category";
		$_query .= " ORDER BY f_id DESC LIMIT $_start, $_items";
		$query = $this->db->query($_query);
        return $query->result();
	}
	function save_message($_name, $_email, $_content, $_ip_addr, $_uagent, $_website = null) {
		$_query_data = array(
			'f_name'		=> $_name,
			'f_email'		=> $_email,
			'f_message'		=> $_content,
			'f_ip_address'	=> $_ip_addr,
			'f_browser'		=> $_uagent,
			'f_date'		=> date('Y-m-d H:i:s')
		);
		if (!empty($_website)) $_query_data['f_website'] = $_website;
		
		$this->db->insert('t_guestbook', $_query_data);
		if ($this->db->affected_rows() == 0) return false;
		return true;
	}
	function count_messages($_category = -1) {
		$_query  = "SELECT COUNT(*) AS _count FROM t_guestbook";
		if ($_category >= 0) $_query .= " WHERE f_read = $_category";
		$query = $this->db->query($_query);
		$_res  = $query->row();
        return $_res->_count;
	}
}