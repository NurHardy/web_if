<?php
class web_link extends CI_Model{
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
}