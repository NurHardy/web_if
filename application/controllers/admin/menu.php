<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Menu extends CI_Controller {
	public function index() {
		if ($this->load->check_session()) {
			$this->load->model ('web_menu');
			$data['page_title'] = 'Menu Editor';
			$data['username_']	= $this->nativesession->get('user_name_');
			$this->load->template_admin('admin/menueditor', $data, false, "&raquo; menu editor");
		}
	}
	
	public function savemenu() {
		if ($this->load->check_session(true)) {
			$this->load->model ('web_menu');
			$JSONdata = $this->input->post('JSON_menu');
			if (!$JSONdata) {$this->output->append_output("Empty query"); return;}
			$_json_ = $this->web_menu->save_menu($JSONdata);
			if ($_json_ == 'OK') $_json_ = 'Menu berhasil disimpan...!';
			$this->output->append_output($_json_);
		}
	}
}