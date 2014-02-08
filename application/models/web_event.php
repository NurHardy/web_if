<?php
class web_event extends CI_Model{
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
}
