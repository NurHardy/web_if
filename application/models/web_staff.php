<?php
class web_staff extends CI_Model {
/* ------------------------------------------ STAFF ------------------- */
	function get_staff($total) 
	{			
		$_query  = "SELECT * FROM t_staff";
		$_query .= " ORDER BY id_staff  LIMIT 0,$total";
		$query = $this->db->query($_query);
        return $query->result();
	}		
	function get_jabatan($jabatan) 
	{			
		$_query  = "SELECT * FROM t_staff WHERE jabatan='$jabatan'";
		$query = $this->db->query($_query);
        return $query->row();
	}	
	function get_staff_id($nip) 
	{			
		$_query  = "SELECT * FROM t_staff WHERE nip='$nip'";
		$query = $this->db->query($_query);
        return $query->row();
	}	
}
