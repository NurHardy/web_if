<?php
class Tabel extends CI_Model{

	
	
    function get_user_all()
    {
        $query=$this->db->query("SELECT * FROM user ORDER BY id_ DESC");
        return $query->result();
    }
	
	function get_newest_posts($total = 5, $category = null) {
		$news_table		= 'berita';
		$news_id_field  = 'id_berita';
		$news_cat_field	= 'id_kategori';
		
		$_total = ($total <= 0 ? 5 : $total);
		
		$_query  = "SELECT * FROM $news_table";
		
		if (!empty($category)) $_query .= " WHERE $news_cat_field = $category";
		
		$_query .= " ORDER BY $news_id_field DESC LIMIT $_total";
		$query = $this->db->query($_query);
        return $query->result();
	}
	
	function get_nearest_event($total = 5) {
		$_total = ($total <= 0 ? 5 : $total);
		
		$_query  = "SELECT * FROM t_event";
		
		$_query .= " WHERE (f_date >= NOW()) ORDER BY f_date LIMIT $_total";
		$query = $this->db->query($_query);
		
        return $query->result();
	}
	
	function get_links($total = -1) {
		$_query  = "SELECT * FROM t_link";
		
		if ($total > 0) $_query .= " LIMIT $total";
		
		$query = $this->db->query($_query);
        return $query->result();
	}
}
