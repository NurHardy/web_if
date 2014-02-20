<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Guestbook extends CI_Controller {
	public function index() 
	{ 
		$this->load->model('web_link');
		$data['page_title'] = 'Buku Tamu';
		
		$this->load->model ('web_guestbook');
		$this->load->model ('web_functions');
		
		$data['f_name']		= htmlentities($this->input->post('f_gb_name'));
		$data['f_email']	= htmlentities($this->input->post('f_gb_email'));
		$data['f_website']	= htmlentities($this->input->post('f_gb_website'));
		$data['f_content']	= $this->input->post('f_gb_content');
		
		$_submitter = $this->input->post('form_submit');
		$data['errors'] = array();
		if ($_submitter == 'GUESTBOOK_FORM') {
			// validasi
			if (empty($data['f_name'])) $data['errors'][] = 'Mohon isi nama';
			if (empty($data['f_email'])) $data['errors'][] = 'Mohon isi e-mail';
			if (empty($data['f_content'])) $data['errors'][] = 'Mohon tulis pesan Anda';
			if (count($data['errors']) == 0) {
				
				$_result = $this->web_guestbook->save_message(
					$data['f_name'],
					$data['f_email'],
					$data['f_content'],
					$_SERVER['REMOTE_ADDR'],
					$_SERVER['HTTP_USER_AGENT'],
					$data['f_website']
				);
				if ($_result) {
					$data['infos']	 = array('Pesan Anda berhasil disimpan. Terima kasih atas masukannya.');
					$data['no_form'] = true;
				}
				else $data['errors'] = array('Terjadi kesalahan. Silakan periksa konten dan ulangi lagi.');
			}
		}
		$_ipp = $this->input->get('n'); // item per page
		$_cur = $this->input->get('p'); // current page (zero-based)
		$_maxpage = $this->input->get('x');

		$this->web_functions->check_pagination($_ipp, $_cur, $_maxpage);
		if ($_maxpage === false) {
			$_n = $this->web_guestbook->count_messages();
			$_maxpage = ($_n==0?0:ceil($_n/$_ipp)-1);
		}
		
		$data['daftar_tautan'] = $this->web_link->get_links();
		$data['_paging']	= $this->web_functions->pagination(
			$_maxpage,
			$_cur,
			2,
			'/guestbook',
			'n='.$_ipp
		);
		if ($_cur > 0) $data['no_form'] = true;
		$data['_ctr'] = $_cur*$_ipp;
		$data['_ipp'] = $_ipp;
		$data['gmessages'] = $this->web_guestbook->get_messages($_ipp, $_cur+1);
		$this->load->template_akademik('guestbook', $data, false, "&raquo; Buku Tamu");
	}
}