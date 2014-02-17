<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Website_Admin extends CI_Controller {

	private function _check_session($_no_redir = false, $_err_msg = null) {
		if (!$this->nativesession->get('user_id_')) {
			if ($_no_redir) {
				$this->output->append_output(($_err_msg?$_err_msg:"Sorry, you must logged in to continue..."));
			} else $this->output->set_header('Location: /admin/login?next='.urlencode($_SERVER['REQUEST_URI']));
			return false;
		}
		return true;
	}
	
	
	
	
	
}
