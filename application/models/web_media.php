<?php
class web_media extends CI_Model{
	function get_media($_items = 15, $_page = 1) {
		$_start = ($_page-1)*$_items;
		$_query  = "SELECT * FROM t_media LIMIT $_start, $_items";
		$query = $this->db->query($_query);
        return $query->result();
	}
}