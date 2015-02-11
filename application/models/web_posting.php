<?php
class web_posting extends CI_Model{
/* ------------------------------------------ POSTING -------------------*/
	function get_post($post_id, $_slug = null) {
		if ((!is_numeric($post_id)) || ($post_id <= 0)) return null;
		$_query  = "SELECT * FROM t_posts WHERE id_berita = $post_id";
		
		$query = $this->db->query($_query);
        return $query->row();
	}
	
	function save_post($_title, $_content, $_category, $_id_creator, $_creator, $_publish = true, $_draft = -1, $_id = -1) {
		$_ptitle = strtolower(html_entity_decode($_title));
		$_pslug = substr(preg_replace('/[^A-Za-z0-9-]+/', '-', $_ptitle),0,64);
		$_query_data = array(
			'judul'			=> $_title,		// tidak perlu htmlentities
			'id_kategori'	=> $_category,
			'isi_berita'	=> $_content,
			'tanggal_edit'	=> null,
			'creator'		=> $_creator,	// creator sudah dalam htmlentities
			'id_creator'	=> $_id_creator,
			'status'		=> ($_publish?1:0),
			'f_id_draft'	=> 0,
			'f_slug'		=> $_pslug
		);
		if ($_id > 0) {
			$_query_data['tanggal_edit'] = date('Y-m-d H:i:s');
			$this->db->where('id_berita', $_id);
			$this->db->update('t_posts', $_query_data); 
		} else {
			$_query_data['tanggal'] = date('Y-m-d H:i:s');
			$this->db->insert('t_posts', $_query_data);
		}
		if ($this->db->affected_rows() == 0) return false;
		$this->load->model('web_draft');
		if ($_draft > 0) $this->web_draft->delete_draft($_draft);
		return true;
	}
	
	function save_post_draft($_title, $_content, $_category, $_id_creator, $_creator, $_origin = 0, $_id = -1) {
		$last_id = $_id;
		$_query_data = array(
			'f_title'		=> $_title,
			'f_category'	=> $_category,
			'f_content'		=> $_content,
			'f_date_last'	=> null,
			'f_creator'		=> $_creator,
			'f_id_creator'	=> $_id_creator,
			'f_origin'		=> $_origin,
			'f_type'		=> 1 // tipe posting
		);
		if ($_id > 0) {
			$_query_data['f_date_last'] = date('Y-m-d H:i:s');
			$this->db->where('f_id', $_id);
			$this->db->update('t_draft', $_query_data);
			if ($this->db->affected_rows() == 0) return false;
		} else {
			$_query_data['f_date_saved'] = date('Y-m-d H:i:s');
			$this->db->insert('t_draft', $_query_data);
			if ($this->db->affected_rows() == 0) return false;
			
			if ($_origin > 0) {
				// Update field pada record posting
				$_result = $this->db->query("SELECT MAX(f_id) AS new_id FROM t_draft");
				$last_id_ = $_result->row();
				$last_id  = $last_id_->new_id;
				$_q_result = $this->db->simple_query("UPDATE t_posts SET f_id_draft = $last_id WHERE id_berita = $_origin");
				if (!$_q_result) return false;
			}
		}
		return $last_id;
	}
	function get_posts($_items = 15, $_page = 1, $postCategory = -1, $postStatus = 1) {
		// tambahkan bitmask di sini!!
		$_start = ($_page-1)*$_items;
		
		if (is_array($postCategory)) {
			if (count($postCategory) > 0) {
				$this->db->where_in("id_kategori", $postCategory);
			}
		} else if ($postCategory > 0)	$this->db->where('id_kategori', $postCategory);
		
		if ($postStatus > 0)	$this->db->where('status', $postStatus);
		
		$this->db->order_by("tanggal", "desc");
		if ($_items > 0) $this->db->limit($_start, $_items);
		
		$query  = $this->db->get('t_posts');
        return $query->result();
	}
	function get_newest_posts($total = 5, $category = null) {
		$news_table		= 't_posts';
		$news_id_field  = 'id_berita';
		$news_cat_field	= 'id_kategori';
		
		$_total = ($total <= 0 ? 5 : $total);
		
		$_query  = "SELECT * FROM $news_table";
		
		if (!empty($category)) $_query .= " WHERE $news_cat_field = $category";
		
		$_query .= " ORDER BY $news_id_field DESC LIMIT $_total";
		$query = $this->db->query($_query);
        return $query->result();
	}
	function count_posts($category = null) {
		$_query  = "SELECT COUNT(*) AS _count FROM t_posts";
		if (!empty($category)) $_query .= " WHERE id_kategori = $category";
		$query = $this->db->query($_query);
		$_res  = $query->row();
        return $_res->_count;
	}
	function delete_post($_id) {
		if (intval($_id) <= 0) return false;
		// == Hapus draf yang dipunya posting terkait
		$_postdata = $this->get_post($_id);
		if ($_postdata) {
			$d_id=$_postdata->f_id_draft;
			if ($d_id>0) $this->db->query("DELETE FROM t_draft WHERE f_id=$d_id");
			$this->db->query("DELETE FROM t_posts WHERE id_berita=$_id");
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		return false;
	}
	function hit_post($post_id) { // caution: no validation
		$this->db->query("UPDATE t_posts SET counter = counter+1 WHERE id_berita=".$post_id);
	}
	function set_post_status($_pid, $_status) {
		$this->db->query("UPDATE t_posts SET status=? WHERE id_berita=?", array($_status, $_pid));
		if ($this->db->affected_rows() == 0) return false;
		return true;
	}
/* ------------------------------------------ CATEGORY ------------------- */
	// items bernilai < 1 => tampilkan semua
	function get_categories($_catmask = null) {
		//$_start = ($_page-1)*$_items;
		$_query  = "SELECT * FROM t_category_posts";
		if (isset($_catmask) && (is_array($_catmask))) {
			$idmask = '0';
			if (count($_catmask) > 0) $idmask = implode(',',$_catmask);
			$_query .= " WHERE f_id IN ($idmask)";
		}
		$query = $this->db->query($_query);
        return $query->result();
	}
	function get_array_categories($_catmask = null) {
		$_query  = "SELECT * FROM t_category_posts";
		if (isset($_catmask) && (is_array($_catmask))) {
			$idmask = '0';
			if (count($_catmask) > 0) $idmask = implode(',',$_catmask);
			$_query .= " WHERE f_id IN ($idmask)";
		}
		$query = $this->db->query($_query);
        $catList = $query->result();
		
		$catArray = array();
		foreach($catList as $catItem) {
			$catArray[$catItem->f_id] = $catItem->f_name;
		}
		return $catArray;
	}
	function count_categories() {
		$query = $this->db->query("SELECT COUNT(*) AS _count FROM t_category_posts");
		$_result = $query->row();
		return $_result->_count;
	}
	function save_draft($_title, $_permalink, $_content, $_id_creator, $_creator, $_id = -1) {
		$_query_data = array(
			'f_title'		=> $_title,		// tidak perlu htmlentities
			'f_content'		=> $_content,
			'f_permalink'	=> $_permalink,
			'f_creator'		=> $_creator,	// creator sudah dalam htmlentities
			'f_id_creator'	=> $_id_creator,
		);
		if ($_id > 0) {
			$_query_data['f_date_edit'] = date('Y-m-d H:i:s');
			$this->db->where('f_id', $_id);
			$this->db->update('t_page', $_query_data); 
		} else {
			$_query_data['f_date_submit'] = date('Y-m-d H:i:s');
			$this->db->insert('t_page', $_query_data);
		}
		if ($this->db->affected_rows() == 0) return false;
		return true;
	}
	function get_name_categori($_id) {
		$query = $this->db->query("SELECT f_name FROM  t_category_posts WHERE f_id=$_id");
		$_result = $query->row();
		return $_result->f_name;
	}
}