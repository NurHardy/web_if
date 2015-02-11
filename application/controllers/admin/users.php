<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users extends CI_Controller {
	private $_cpmask = 512;
	
	public function index() {
		if ($this->load->check_session($this->_cpmask)) {
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
				base_url('/admin/users'),
				'n='.$_ipp
			);
			$data['_ctr'] = $_cur*$_ipp;
			$data['_ipp'] = $_ipp;
			$this->load->template_admin('admin/user_list', $data, false, "&raquo; akun");
		}
	}
	public function newuser() {
		// == UNDER CONSTRUCTION...!
		if ($this->load->check_session($this->_cpmask)) {
			$this->load->model ('web_posting');
			
			$data['page_title'] = $data['content_title'] = 'User Baru';
			$data['form_action']= base_url('/admin/users/newuser');
			$data['username_']	= $this->nativesession->get('user_name_');
			$data['errors'] = array();
			
			$data['f_fullname'] = htmlentities($this->input->post('f_fullname'));
			$data['f_username'] = htmlentities($this->input->post('f_username'));
			$data['f_email']    = htmlentities($this->input->post('f_email'));
			$data['f_userprev'] = $this->input->post('f_prev_');
			$data['f_catprev'] = $this->input->post('f_prev_cat');
			$data['f_catflag'] = 0;
			$data['f_defcat'] = $this->input->post('f_def_cat');
			
			$_f_pass1	= md5($this->input->post('f_passw1'));
			$_f_pass2	= md5($this->input->post('f_passw2'));
			
			$_submitter = $this->input->post('form_submit');
			if ($_submitter == 'USER_POST_FORM') {
				// validasi
				if (empty($data['f_fullname'])) $data['errors'][] = "Nama lengkap user harus diisi.";
				if (empty($data['f_username'])) $data['errors'][] = "Username harus diisi.";
				if (empty($data['f_email'])) $data['errors'][]	  = "E-mail user harus diisi.";
				if (empty($data['f_userprev'])) $data['f_userprev'] = array();
				if (!($this->input->post('f_passw1')) || !($this->input->post('f_passw2')))
					$data['errors'][]	  = "Password dan konfirmasi harus diisi.";
				// === EXPERIMENTAL... ==
				//$data['errors'][] = count($data['f_userprev']);
				//$data['errors'][] = $data['f_userprev'][0];
				if (!is_array($data['f_userprev'])) {
					$data['errors'][] = "Struktur data tidak valid! Pastikan Anda mengisi pada form yang benar...";
					goto selesai;
				}
				$_uprev = 0;
				$_ucatprev = 0; $_udefcat = 0;
				if (isset($data['f_userprev'][0])) {
					$_uprev = 0xFFFFF;
				} else {
					if (isset($data['f_userprev'][1])) { // posting
						if (is_array($data['f_catprev'])) {
							foreach ($data['f_catprev'] as $_catitem) {
								if (($_catitem > 0) && ($_catitem <= 16)) $_ucatprev |= (1 << ($_catitem - 1));
							}
							if ($_ucatprev > 0) $_uprev |= 2;
							$_udefcat = intval($data['f_defcat']);
							$data['f_catflag'] = $_ucatprev;
						} else {
							unset($data['f_userprev'][1]);
						}
					}
					if (isset($data['f_userprev'][2])) $_uprev |= 4;
					if (isset($data['f_userprev'][3])) $_uprev |= 8;
					if (isset($data['f_userprev'][4])) $_uprev |= 16;
					if (isset($data['f_userprev'][5])) $_uprev |= 32;
					if (isset($data['f_userprev'][6])) $_uprev |= 64;
				}
				if ($_uprev == 0) $data['errors'][] = 'User harus mempunyai paling tidak satu role.';
				if (empty($data['errors'])) { // semua data lengkap
					if ($_f_pass1 != $_f_pass2) {
						$data['errors'][] = "Password dan konfirmasi tidak sama";
						goto selesai;
					} else if (strlen($this->input->post('f_passw1')) <= 5) {
						$data['errors'][] = "Password minimal 5 karakter...";
						goto selesai;
					}
					
					$this->load->model ('web_admin');
					$_chk_res = $this->web_admin->check_username($data['f_username']);
					if ($_chk_res != null) {
						$data['errors'][] = 'Username: '.$_chk_res;
						goto selesai;
					}

					
					$_newuser_data = array(
						$data['f_username'],
						$_f_pass1,
						$data['f_fullname'],
						$data['f_email'],
						$_uprev,
						$_ucatprev,
						$_udefcat
					);
					
					$_result = $this->web_admin->save_user(
						$_newuser_data,
						$this->nativesession->get('user_id_'),
						$this->nativesession->get('user_name_')
					);
					
					$_result = false;
					if ($_result) {
						$data['infos']	 = array("User <b>{$data['f_username']}</b> berhasil dibuat.");
						$data['no_form'] = true;
					}
					else $data['errors'] = array('Terjadi kesalahan. Silakan periksa konten dan ulangi lagi.');
				}
			}
			selesai:
			$data['_cats']	= $this->web_posting->get_categories();
			$this->load->template_admin('admin/user_form', $data, false, "&raquo; <a href='".base_url("/admin/users")."'>akun</a> &raquo; akun baru");
		}
	}
	public function changeauth($_uid = -1) {
		if ($this->load->check_session($this->_cpmask)) {
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
			$data['form_action'] = base_url('/admin/users/changeauth/'.$__uid);
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
			$this->load->template_admin('admin/user_password', $data, false, "&raquo; <a href='".base_url("/admin/users")."'>akun</a> &raquo; ganti password");
		}
	}
	public function edituser($_uid = -1) {
		if ($this->load->check_session($this->_cpmask)) {
			if (!is_numeric($_uid)) $this->output->set_header('Location: '.base_url('/admin/users'));
			$this->load->model ('web_posting');
			
			$data['page_title'] = $data['content_title'] = 'Edit Akun';
			$data['form_action']= base_url('/admin/users/edituser/'.$_uid);
			$data['username_']	= $this->nativesession->get('user_name_');
			$data['errors'] = array();
			
			$data['f_fullname'] = htmlentities($this->input->post('f_fullname'));
			$data['f_username'] = htmlentities($this->input->post('f_username'));
			$data['f_email']    = htmlentities($this->input->post('f_email'));
			$data['f_userprev'] = $this->input->post('f_prev_');
			$data['f_catprev'] = $this->input->post('f_prev_cat');
			$data['f_catflag'] = 0;
			$data['f_defcat'] = $this->input->post('f_def_cat');
			$data['_is_editing'] = true;
			
			$_submitter = $this->input->post('form_submit');
			if ($_submitter == 'USER_POST_FORM') {
				// validasi
				if (empty($data['f_fullname'])) $data['errors'][] = "Nama lengkap user harus diisi.";
				if (empty($data['f_username'])) $data['errors'][] = "[Warn] No username info";
				if (empty($data['f_email'])) $data['errors'][]	  = "E-mail user harus diisi.";
				if (empty($data['f_userprev'])) $data['f_userprev'] = array();
				
				if (!is_array($data['f_userprev'])) {
					$data['errors'][] = "Struktur data tidak valid! Pastikan Anda mengisi pada form yang benar...";
					goto selesai;
				}
				$_uprev = 0;
				$_ucatprev = 0; $_udefcat = 0;
				if (isset($data['f_userprev'][0])) {
					$_uprev = 0xFFFFF;
				} else {
					if (isset($data['f_userprev'][1])) { // posting
						if (is_array($data['f_catprev'])) {
							foreach ($data['f_catprev'] as $_catitem) {
								if (($_catitem > 0) && ($_catitem <= 16)) $_ucatprev |= (1 << ($_catitem - 1));
							}
							if ($_ucatprev > 0) $_uprev |= 2;
							$_udefcat = intval($data['f_defcat']);
							$data['f_catflag'] = $_ucatprev;
						} else {
							unset($data['f_userprev'][1]);
						}
					}
					if (isset($data['f_userprev'][2])) $_uprev |= 4;
					if (isset($data['f_userprev'][3])) $_uprev |= 8;
					if (isset($data['f_userprev'][4])) $_uprev |= 16;
					if (isset($data['f_userprev'][5])) $_uprev |= 32;
					if (isset($data['f_userprev'][6])) $_uprev |= 64;
				}
				if ($_uprev == 0) $data['errors'][] = 'User harus mempunyai paling tidak satu role.';
				if (empty($data['errors'])) { // semua data lengkap
					$this->load->model ('web_admin');
					$_newuser_data = array(
						$data['f_username'],
						null,
						$data['f_fullname'],
						$data['f_email'],
						$_uprev,
						$_ucatprev,
						$_udefcat
					);
					$_result = $this->web_admin->save_user(
						$_newuser_data,
						$this->nativesession->get('user_id_'),
						$this->nativesession->get('user_name_'),
						$_uid
					);
					
					if ($_result) {
						$data['infos']	 = array("User <b>{$data['f_username']}</b> berhasil diperbaharui.");
						$data['no_form'] = true;
					}
					else $data['errors'] = array('Terjadi kesalahan. Silakan periksa konten dan ulangi lagi.');
				}
			} else {
				$this->load->model ('web_admin');
				$udata_ = $this->web_admin->get_user($_uid);
				if (empty($udata_)) {
					$this->output->set_header('Location: '.base_url('/admin/users'));
					return;
				}
				$data['f_fullname'] = $udata_->f_fullname;
				$data['f_username'] = $udata_->f_username;
				$data['f_email']    = $udata_->f_email;
				$data['f_userprev'] = array();
				$uprev_ = $udata_->f_prev_flags;
				if ($uprev_ >= 0xFFFFF) $data['f_userprev'][0] = '1';
				for ($c_=1;$c_< 7;$c_++) {
					$uprev_ = $uprev_ >> 1;
					if ($uprev_ & 1) $data['f_userprev'][$c_] = '1';
				}
				$ucatprev = intval($udata_->f_cat_flags);
				$data['f_catflag'] = $ucatprev;
				for ($c_=1;$c_<= 16;$c_++) {
					if (($ucatprev & 1) || ($uprev_ >= 0xFFFFF)) $data['f_catprev'][] = "{$c_}";
					$ucatprev = $ucatprev >> 1;
				}
				$data['f_defcat'] = $udata_->f_def_cat;
			}
			selesai:
			$data['_cats']	= $this->web_posting->get_categories();
			$this->load->template_admin('admin/user_form', $data, false, "&raquo; <a href='".base_url("/admin/users")."'>akun</a> &raquo; edit akun");
		}
	}
	public function checkusername() {
		if ($this->load->check_session($this->_cpmask, true)) {
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