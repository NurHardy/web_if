<?php
class web_admin extends CI_Model {
/* ------------------------------------------ ADMINISTRATION ------------------- */
	function user_authenticate($_username, $_md5pass) {
		$query = $this->db->query("SELECT * FROM t_users WHERE (f_username = ?) AND (f_password = ?)", array($_username, $_md5pass));
		$_udata = null;
		if ($query->num_rows() == 1) {
			$_udata = $query->row();
			$this->db->query("UPDATE t_users SET f_date_last = '".date('Y-m-d H:i:s')."' WHERE f_id=".$_udata->f_id);
		}
		return $_udata;
	}
	function get_users($_items = 15, $_page = 1) {
		$_start = ($_page-1)*$_items;
		$_query  = "SELECT * FROM t_users LIMIT $_start, $_items";
		$query = $this->db->query($_query);
		
		return $query->result();
	}
	
	function count_users() {
		$_query  = "SELECT COUNT(*) AS _count FROM t_users";
		$query = $this->db->query($_query);
		$_res  = $query->row();
        return $_res->_count;
	}
	function get_user($_uid) {
		$__uid = intval($_uid);
		$_query  = "SELECT * FROM t_users WHERE f_id=$__uid";
		$query = $this->db->query($_query);
        return $query->row();
	}
	function check_username($_username) {
		$err_msg = null;
		if (preg_match('/^[a-zA-Z0-9]+$/', $_username)) {
			// cek ketersediaan
			$_uname =  $this->db->escape_str($_username);
			$_query = "SELECT COUNT(*) AS _count FROM t_users WHERE f_username = '$_uname'";
			$query = $this->db->query($_query);
			$_res  = $query->row();
			if ($_res->_count == 1) {
				$_uname = htmlentities($_uname);
				$err_msg = "Username '{$_uname}' tidak tersedia. Silakan gunakan username lain.";
			}
		} else {
			$err_msg = "Gunakan hanya karakter alfanumerik.";
		}
		return $err_msg;
	}
	function update_userpass($_uid, $_md5pass) {
		if ($_uid <= 0) return false;
		$_query_data = array('f_password'	=> $_md5pass);
		$this->db->where('f_id', $_uid);
		$this->db->update('t_users', $_query_data); 
		if ($this->db->affected_rows() == 0) return false;
		return true;
	}
	function save_user($_udata, $_id_creator, $_creator, $_uid = -1) {
		$_query_data = array(
			'f_fullname'	=> $_udata[2],
			'f_email'		=> $_udata[3],
			'f_prev_flags'	=> $_udata[4],
			'f_cat_flags'	=> $_udata[5],
			'f_def_cat'		=> $_udata[6]
		);
		if ($_uid > 0) {
			$_query_data['f_date_edit'] = date('Y-m-d H:i:s');
			$this->db->where('f_id', $_uid);
			$this->db->update('t_users', $_query_data); 
		} else {
			$_query_data['f_username']	= $_udata[0];
			$_query_data['f_password']	= $_udata[1];
			$_query_data['f_parent']	= $_creator;
			$_query_data['f_parent_id']	= $_id_creator;
			$_query_data['f_date_reg'] = date('Y-m-d H:i:s'); // date registered
			$this->db->insert('t_users', $_query_data);
		}
		if ($this->db->affected_rows() == 0) return false;
		return true;
	}
}
