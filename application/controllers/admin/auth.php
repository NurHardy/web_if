<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Auth extends CI_Controller {

	public function index() {
		if (!$this->nativesession->get('user_id_')) {
			$this->authenticate();
		} else { // sudah login
			$this->output->set_header('Location: '.base_url("/admin/dashboard"));
		}
	}
	
	public function authenticate() { // action login		
		if (!$this->nativesession->get('user_id_')) {
			$data['page_title'] = 'Administrative Login';
			$redir_url = $this->input->get('next');
			
			$_submitter		= $this->input->post('form_submit');
			$_login_user	= $this->input->post('f_user');
			$_login_pass	= md5($this->input->post('f_password'));
			
			if (isset($_submitter) && ($_submitter == "LOGIN_FORM")) {
				if (!empty($_login_user)) {
					$this->load->model ('web_admin');
					$_user_row = $this->web_admin->user_authenticate($_login_user, $_login_pass);
					if ($_user_row != null) {
						$this->nativesession->set('user_id_'  , $_user_row->f_id);
						$this->nativesession->set('user_name_', htmlentities($_user_row->f_username));
						$this->nativesession->set('user_role_', $_user_row->f_role_id);
						
						if (!$redir_url) $redir_url = base_url("/admin/");
						$this->output->set_header("Location: $redir_url");
						return;
					} else {
						$data['errors'] = array('Username atau password salah. Pastikan Anda telah menuliskannya dengan benar.');
					}
				}
			}
			if ($redir_url) $data['redir_url'] = $redir_url;
			$this->load->template_admin_simple('admin/login_form', $data);
		} else { // sudah login
			$this->output->set_header('Location: '.base_url("/admin/dashboard"));
		}
	}
	public function logout() {
		if ($this->nativesession->get('user_id_')) {
			$this->nativesession->delete('user_id_');
			$this->nativesession->delete('user_name_');
			$this->nativesession->delete('user_role_');
		}
		$this->output->set_header('Location: '.base_url("/admin"));
	}
}