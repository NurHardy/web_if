<?php
class web_slider extends CI_Model {
	function get_slides($stat = 1) {
		$stat_ = $stat;
		if (!is_numeric($stat_)) $stat = -1;
		$_query  = "SELECT * FROM t_slider";
		if ($stat_ >= 0) $_query .= " WHERE f_status =$stat_";
		$_query .= " ORDER BY f_order DESC";
		
		$query = $this->db->query($_query);
        return $query->result();
	}
	function insert_newslide($_img_url, $_id_creator, $_creator, $_status = 1) {
		$_query_data = array(
			'f_url'			=> $_img_url,
			'f_desc'		=> 'Unlabelled',
			'f_effect'		=> 'fromLeft',
			'f_status'		=> ($_status===1?1:0),
			'f_id_creator'	=> $_id_creator,
			'f_creator'		=> $_creator
		);
		
		$_query_data['f_date_submit'] = date('Y-m-d H:i:s'); // date registered
		$this->db->insert('t_slider', $_query_data);
		
		if ($this->db->affected_rows() == 0) return false;
		return true;
	}
	function update_slide($_id, $sdata = null) {
		$_query_data = array();
		if (isset($sdata['url'])) $_query_data['f_url'] = $sdata['url'];
		if (isset($sdata['desc'])) $_query_data['f_desc'] = $sdata['desc'];
		if (isset($sdata['effect'])) $_query_data['f_effect'] = $sdata['effect'];
		if (isset($sdata['order'])) $_query_data['f_order'] = $sdata['order'];
		if (isset($sdata['status'])) $_query_data['f_status'] = $sdata['status'];
		
		if (!empty($_query_data)) {
			$_query_data['f_date_edit'] = date('Y-m-d H:i:s');
			$this->db->where('f_id', $_id);
			$this->db->update('t_slider', $_query_data); 
		}
		if ($this->db->affected_rows() == 0) return false;
		return true;
	}
	public function delete_slide($_id) {
		if (intval($_id) <= 0) return false;
		$this->db->query("DELETE FROM t_slider WHERE f_id=$_id");
		if ($this->db->affected_rows() == 0) return false;
		return true;
	}
}