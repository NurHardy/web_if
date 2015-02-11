<?php
class web_draft extends CI_Model {
/* ------------------------------------------ DRAFT ------------------- */
	function get_drafts($_items = 15, $_page = 1, $_draft_type = -1) {
		$_start = ($_page-1)*$_items;
		$_query  = "SELECT * FROM t_draft";
		if ($_draft_type > 0) $_query .= " WHERE f_type = $_draft_type";
		$_query .= " ORDER BY f_id DESC LIMIT $_start, $_items";
		$query = $this->db->query($_query);
        return $query->result();
	}
	function get_draft($draft_id) {
		if ((!is_numeric($draft_id)) || ($draft_id <= 0)) return null;
		$query = $this->db->query("SELECT * FROM t_draft WHERE f_id = $draft_id");
        return $query->row();
	}
	function count_drafts($_draft_type = -1) {
		$_query = "SELECT COUNT(*) AS _count FROM t_category";
		if ($_draft_type > 0) $_query .= " WHERE f_type = $_draft_type";
		$query = $this->db->query($_query);
		$_result = $query->row();
		return $_result->_count;
	}
	function get_draft_id($_type, $_id) {
		if ($_id <= 0) return -1;
		$query = $this->db->query("SELECT f_id FROM t_draft WHERE (f_type = $_type) AND (f_origin = $_id)");
		if ($query->num_rows() > 0) {
			$_result = $query->row();
			return $_result->f_id;
		} else return -1;
	}
	function delete_draft($_id) {
		$this->db->query("DELETE FROM t_draft WHERE f_id=$_id");
	}
	function cancel_draft($_id) {
		$_draftdata = $this->get_draft($_id);
		if ($_draftdata) {
			if ($_draftdata->f_origin>0) {
				if ($_draftdata->f_type==1) $this->db->query("UPDATE t_posts SET f_id_draft=0 WHERE id_berita={$_draftdata->f_origin}");
			}
			$this->delete_draft($_id);
			return true;
		}
		return false;
	}
}