<?php
class web_media extends CI_Model{
	function get_media($_items = 15, $_page = 1) {
		$_start = ($_page-1)*$_items;
		$_query  = "SELECT * FROM t_media LIMIT $_start, $_items";
		$query = $this->db->query($_query);
        return $query->result();
	}
	function save_media($_fdata, $_uploader_ip, $_id_creator, $_creator) {
		$_query_data = array(
			'f_name'	=> $_fdata[0],
			'f_file_path'	=> $_fdata[1],
			'f_file_type'	=> $_fdata[2],
			'f_file_type_id'	=> $_fdata[3],
			'f_file_size'		=> $_fdata[4],
			'f_uploader_ip'		=> $_uploader_ip,
			'f_creator'		=> $_creator,
			'f_id_creator'	=> $_id_creator
		);
		
		$_query_data['f_date_submit'] = date('Y-m-d H:i:s'); // date registered
		$this->db->insert('t_media', $_query_data);
		
		if ($this->db->affected_rows() == 0) return false;
		return true;
	}
}