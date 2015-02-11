<?php
class web_pengumuman extends CI_Model {
/* ------------------------------------------ Pengumuman ------------------- */
	function get_newst_nounce($total = 5) {
		$_total = ($total <= 0 ? 5 : $total);
		
		$_query  = "SELECT * FROM t_pengumuman";
		
		$_query .= " WHERE (tgl_berakhir >= NOW()) ORDER BY tgl_berakhir LIMIT $_total";
		$query = $this->db->query($_query);
        return $query->result();
	}
	
	function get_published_nounce() {	
		$_query  = "SELECT * FROM t_pengumuman";
		
		$_query .= " WHERE (tgl_berakhir >= NOW())";
		$query = $this->db->query($_query);
        return $query->result();
	}
	
	function get_unpublished_nounce() {	
		$_query  = "SELECT * FROM t_pengumuman";
		
		$_query .= " WHERE (tgl_berakhir < NOW())";
		$query = $this->db->query($_query);
        return $query->result();
	}
	
	function get_pengumuman_id($id_p) 
	{			
		$_query  = "SELECT * FROM t_pengumuman WHERE id_pengumuman='$id_p'";
		$query = $this->db->query($_query);
        return $query->row();
	}	
	function save_pengumuman($_judul, $_isi, $_tgl) {
		$_query_data = array(
			'judul'			=> $_judul,
			'isi'			=> $_isi,
			'tgl_berakhir'		=> $_tgl
		);
		$this->db->insert('t_pengumuman', $_query_data);
		if ($this->db->affected_rows() == 0) return false;
		return true;
		}
		
		
	function update_pengumuman($_judul, $_isi, $_tgl, $_idp) {
		$_query_data = array(
			'judul'			=> $_judul,
			'isi'			=> $_isi,
			'tgl_berakhir'	=> $_tgl
		);
		$this->db->where('id_pengumuman', $_idp);
		$this->db->update('t_pengumuman', $_query_data); 
		if ($this->db->affected_rows() == 0) return false;
		return true;
		}
		
}
