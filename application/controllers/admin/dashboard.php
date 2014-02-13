<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard extends CI_Controller {

	public function index() {
		if ($this->load->check_session()) {
			$data['page_title'] = 'Dasbor';
			$data['username_'] = $this->nativesession->get('user_name_');
			$this->load->template_admin('admin/dashboard', $data);
		}
	}
}