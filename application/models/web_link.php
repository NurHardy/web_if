<?php
class web_link extends CI_Model{
	function get_links($total = -1, $stat = 1) {
		$stat_ = $stat;
		if (!is_numeric($stat_)) $stat = -1;
		$_query  = "SELECT * FROM t_link";
		if ($stat_ >= 0) $_query .= " WHERE f_status =$stat_";
		$_query .= " ORDER BY f_order DESC";
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
	function update_order($_id, $_order, $_publish) {
		if ($_id > 0) {
			$__order = intval($_order);
			$__publish = ($_publish?1:0);
			$this->db->query("UPDATE t_link SET f_order = $__order, f_status = $__publish WHERE f_id = $_id");
		}
	}
}