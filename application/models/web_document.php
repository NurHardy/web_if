<?php
class web_document extends CI_Model{
	function get_documents($statusFilter = -1, $limitItem = -1, $limitStart = -1) {
		if ($statusFilter > 0) $this->db->where('f_status', $statusFilter);
		$this->db->order_by("f_date_submit","desc");
		if ($limitItem > 0) {
			if ($limitStart > 0) {
				$this->db->limit($limitItem);
			} else {
				$this->db->limit($limitItem, $limitStart);
			}
		}
		$query = $this->db->get("t_documents");
        return $query->result();
	}
	function get_document($idDocument) {
		if (is_array($idDocument)) {
			$this->db->where_in("f_id", $idDocument);
			$query = $this->db->get("t_documents");
			return $query->result();
		} else {
			$query = $this->db->get_where("t_documents", array("f_id"=>$idDocument), 1);
			return $query->row();
		}
	}
	function save_document($docData, $uploaderIp, $idCreator, $creator, $idDocument = -1) {
		$queryData = array(
			'f_name'		=> $docData[0],
			'f_file_path'	=> $docData[1],
			'f_file_type_id'=> $docData[2],
			'f_file_type'	=> $docData[3],
			'f_desc'		=> $docData[4],
			'f_file_size'	=> $docData[5],
			'f_slug'		=> $docData[6]
		);
		
		$queryResult = null;
		if ($idDocument > 0) {
			$queryData['f_date_edit'] = date('Y-m-d H:i:s'); // date registered
			$this->db->where('f_id', $idDocument);
			$queryResult = $this->db->update('t_documents', $queryData);
			
		} else {
			$queryData['f_date_submit']	= date('Y-m-d H:i:s');
			$queryData['f_uploader_ip']	= $uploaderIp;
			$queryData['f_id_creator']	= $idCreator;
			$queryData['f_creator']		= $creator;
			
			$queryResult = $this->db->insert('t_documents', $queryData);
		}
		return $queryResult;
	}
	
	function hit_document($idDocument) {
		$this->db->where('f_id', $idDocument);
		$this->db->set('f_hits', 'f_hits+1', FALSE);
		$this->db->update('t_documents');
	}
}