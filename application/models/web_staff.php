<?php
class web_staff extends CI_Model {
/* ------------------------------------------ STAFF ------------------- */
	function get_staff() 
	{			
		$_query  = "SELECT * FROM t_staff order by nip";
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
	function save_staff($_nama, $_nip, $_alamat, $_ttl,$_pddk,$_email, $_web, $_bidilmu, $_lab , $_matkul,$_hp,$_nidn,$_foto) {
		$_query_data = array(
			'nama'			=> $_nama,
			'nip'			=> $_nip,
			'alamat'		=> $_alamat,
			'ttl'			=> $_ttl,
			'pddk'			=> $_pddk,
			'email'			=> $_email,
			'website'		=> $_web,
			'bidangilmu'	=> $_bidilmu,
			'lab'			=> $_lab,
			'matkul'		=> $_matkul,
			'hp'			=> $_hp,
			'nidn'			=> $_nidn,
			'link_foto'		=> $_foto
		);
		$this->db->insert('t_staff', $_query_data);
		if ($this->db->affected_rows() == 0) return false;
		return true;
		}
		
		
		function update_staff($_nama, $_nip, $_alamat, $_ttl,$_pddk,$_email, $_web, $_bidilmu, $_lab , $_matkul,$_hp,$_nidn,$_foto) {
		$_query_data = array(
			'nama'			=> $_nama,
			'nip'			=> $_nip,
			'alamat'		=> $_alamat,
			'ttl'			=> $_ttl,
			'pddk'			=> $_pddk,
			'email'			=> $_email,
			'website'		=> $_web,
			'bidangilmu'	=> $_bidilmu,
			'lab'			=> $_lab,
			'matkul'		=> $_matkul,
			'hp'			=> $_hp,
			'nidn'			=> $_nidn,
			'link_foto'		=> $_foto
		);
		$this->db->where('nip', $_nip);
		$this->db->update('t_staff', $_query_data); 
		if ($this->db->affected_rows() == 0) return false;
		return true;
		}
		
}
