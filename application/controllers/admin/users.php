<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users extends CI_Controller {
	public function index() {
		if ($this->load->check_session()) {
			$this->load->model ('web_admin');
			$this->load->model ('web_functions');
			
			$data['page_title'] = $data['content_title'] = 'Daftar User';
			$data['username_']	= $this->nativesession->get('user_name_');
			
			$_ipp = $this->input->get('n'); // item per page
			$_cur = $this->input->get('p'); // current page (zero-based)
			$_maxpage = $this->input->get('x');
			$_filter = intval($this->input->get('cat'));

			$this->web_functions->check_pagination($_ipp, $_cur, $_maxpage);
			if ($_maxpage === false) {
				$_n = $this->web_admin->count_users();
				$_maxpage = ($_n==0?0:ceil($_n/$_ipp)-1);
			}
			
			$data['_users']		= $this->web_admin->get_users($_ipp, $_cur+1);
			$data['_paging']	= $this->web_functions->pagination(
				$_maxpage,
				$_cur,
				2,
				'/admin/users',
				'n='.$_ipp
			);
			$data['_ctr'] = $_cur*$_ipp;
			$data['_ipp'] = $_ipp;
			$this->load->template_admin('admin/user_list', $data, false, "&raquo; akun");
		}
	}
	public function newuser() {
		// == UNDER CONSTRUCTION...!
		if ($this->load->check_session()) {
			$this->load->model ('web_posting');
			
			$data['page_title'] = $data['content_title'] = 'User Baru';
			$data['form_action']= '/admin/users/newuser';
			$data['username_']	= $this->nativesession->get('user_name_');
			$data['errors'] = array();
			
			$data['f_fullname'] = htmlentities($this->input->post('f_fullname'));
			$data['f_username'] = htmlentities($this->input->post('f_username'));
			$data['f_email']    = htmlentities($this->input->post('f_email'));
			$data['f_userprev'] = $this->input->post('f_prev_cat');
			
			$_f_pass1	= md5($this->input->post('f_passw1'));
			$_f_pass2	= md5($this->input->post('f_passw2'));
			
			$_submitter = $this->input->post('form_submit');
			if ($_submitter == 'USER_POST_FORM') {
				// validasi
				if (empty($data['f_fullname'])) $data['errors'][] = "Nama lengkap user harus diisi.";
				if (empty($data['f_username'])) $data['errors'][] = "Username harus diisi.";
				if (empty($data['f_email'])) $data['errors'][]	  = "E-mail user harus diisi.";
				if (!($this->input->post('f_passw1')) || !($this->input->post('f_passw2')))
					$data['errors'][]	  = "Password dan konfirmasi harus diisi.";
				// === EXPERIMENTAL... ==
				$data['errors'][] = count($data['f_userprev']);
				$data['errors'][] = $data['f_userprev'][0];
				
				if (empty($data['errors'])) { // semua data lengkap
					if ($_f_pass1 != $_f_pass2) {
						$data['errors'][] = "Password dan konfirmasi tidak sama";
						goto selesai;
					} else if (strlen($this->input->post('f_passw1')) <= 5) {
						$data['errors'][] = "Password minimal 5 karakter...";
						goto selesai;
					}
					$this->load->model ('web_admin');
					$_chk_res = $this->web_admin->check_username($this->input->post('f_username'));
					if ($_chk_res != null) {
						$data['errors'][] = $_chk_res;
						goto selesai;
					}
					$_newuser_data = array(
						$data['f_username'],
						$_f_pass1,
						$data['f_fullname'],
						$data['f_email'],
						0
					);
					/*
					$_result = $this->web_admin->save_user(
						$_newuser_data,
						$this->nativesession->get('user_id_'),
						$this->nativesession->get('user_name_')
					);
					*/
					$_result = false;
					if ($_result) {
						$data['infos']	 = array('User berhasil dibuat.');
						$data['no_form'] = true;
					}
					else $data['errors'] = array('Terjadi kesalahan. Silakan periksa konten dan ulangi lagi.');
				}
			}
			selesai:
			$data['_cats']	= $this->web_posting->get_categories();
			$this->load->template_admin('admin/user_form', $data, false, "&raquo; <a href='/admin/users'>akun</a> &raquo; akun baru");
		}
	}
	public function changeauth($_uid = -1) {
		if ($this->load->check_session()) {
			//$this->load->model ('web_menu');
			$data['page_title'] = 'Ganti Password';
			$data['username_']	= $this->nativesession->get('user_name_');
			
			$data['errors'] = array();
			$_isself = false;
			$__uid = intval($_uid);
			if ($__uid <= 0) {
				$__uid = $this->nativesession->get('user_id_');
				$_isself = true; // target akun yg akan diganti pass-nya adalah dirinya sendiri
			} else if ($__uid == $this->nativesession->get('user_id_')) $_isself = true;
			if ($_isself) $data['isself'] = true;
			$data['form_action'] = '/admin/users/changeauth/'.$__uid;
			$this->load->model ('web_admin');
			$_userinfo =  $this->web_admin->get_user($__uid);
			if (!$_userinfo) {
				$data['errors'][] = "ID User tidak ditemukan.";
				$data['no_form'] = true;
				goto selesai;
			}
			$data['target_uname'] = $_userinfo->f_username;
			if ($_isself) $_f_pass0	= md5($this->input->post('f_passw'));
			$_f_pass1	= md5($this->input->post('f_passw1'));
			$_f_pass2	= md5($this->input->post('f_passw2'));
			$_submitter = $this->input->post('form_submit');
			if ($_submitter == 'AUTH_FORM') {
				if (!($this->input->post('f_passw1')) || !($this->input->post('f_passw2')))
					$data['errors'][]	  = "Password dan konfirmasi harus diisi.";
				
				if (empty($data['errors'])) { // tdk ada error
					if ($_f_pass1 != $_f_pass2) {
						$data['errors'][] = "Password dan konfirmasi tidak sama";
						goto selesai;
					} else if (strlen($this->input->post('f_passw1')) < 5) {
						$data['errors'][] = "Password minimal 5 karakter...";
						goto selesai;
					}
					if ($_isself) { // perlu pengecekan password lama
						$_oldpass = $_userinfo->f_password;
						if ($_f_pass0 != $_oldpass) {
							$data['errors'][] = "Password lama Anda salah.";
							goto selesai;
						}
						if ($_f_pass1 == $_oldpass) {
							$data['errors'][] = "Password baru sama dengan password lama.";
							goto selesai;
						}
					}
					$_result = $this->web_admin->update_userpass($__uid, $_f_pass1);
					if ($_result) {
						$data['infos']	 = array('Password berhasil diperbaharui...');
						$data['no_form'] = true;
					}
					else $data['errors'] = array('Tidak ada perubahan data...');
				}
			}
			selesai:
			$this->load->template_admin('admin/user_password', $data, false, "&raquo; <a href='/admin/users'>akun</a> &raquo; ganti password");
		}
	}
	
	public function checkusername() {
		if ($this->load->check_session(true)) {
			$_uname = $this->input->post('uname');
			$this->load->model ('web_admin');
			$_chk_res = $this->web_admin->check_username($_uname);
			if ($_chk_res === null) {
				$this->output->append_output("<span class='info_fine_mark'>Username valid.</span>");
			} else {
				$this->output->append_output("<span class='info_error_mark'>".$_chk_res."</span>");
			}
		}
	}
}