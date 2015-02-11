<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class System extends CI_Controller {

	public function index() {
		if ($this->load->check_session()) {
			$data['page_title'] = $data['content_title'] = 'Tentang CMS';
			$data['username_']	= $this->nativesession->get('user_name_');
			$this->load->template_admin('admin/changelog', $data, false, "&raquo; Tentang CMS");
		}
	}
	public function changelog() {
		if ($this->load->check_session()) {
			$data['page_title'] = $data['content_title'] = 'Chengelog';
			$data['username_']	= $this->nativesession->get('user_name_');
			$this->load->template_admin('admin/changelog', $data, false, "&raquo; CMS Changelog");
		}
	}
}
