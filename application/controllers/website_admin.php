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
	
	public function index() {
		if (!$this->nativesession->get('user_id_')) {
			$this->login();
		} else { // sudah login
			$this->output->set_header('Location: /admin/dashboard');
		}
	}
	
	public function dashboard() {
		if ($this->_check_session()) {
			$data['page_title'] = 'Dasbor';
			$data['username_'] = $this->nativesession->get('user_name_');
			$this->load->template_admin('admin/dashboard', $data);
		}
	}
	
	public function newpost() {
		if ($this->_check_session()) {
			$data['page_title'] = $data['content_title'] = 'Tulis Posting Baru';
			$data['form_action']= '/admin/newpost';
			$data['username_']	= $this->nativesession->get('user_name_');
			$data['f_title']	= htmlentities($this->input->post('txt_post_title'));
			$data['f_content']	= $this->input->post('txt_post_content');
			
			$_submitter = $this->input->post('form_submit');
			if ($_submitter == 'POSTING_FORM') {
				if ((!$this->input->post('txt_post_title')) || (!$this->input->post('txt_post_content'))) {
					$data['errors'] = array('Mohon isi judul dan konten posting...');
				} else {
					$this->load->model ('model_website');
					$_result = $this->model_website->save_post(
						$this->input->post('txt_post_title'),
						$this->input->post('txt_post_content'),
						0, // DEBUG
						$this->nativesession->get('user_id_'),
						$this->nativesession->get('user_name_')
					);
					if ($_result) {
						$data['infos']	 = array('Posting berhasil dipublikasikan...');
						$data['no_form'] = true;
					}
					else $data['errors'] = array('Terjadi kesalahan. Silakan periksa konten dan ulangi lagi.');
				}
			}
			$this->load->template_admin('admin/post_form', $data);
		}
	}
	
	public function editpost($id_post = -1) {
		if ($this->_check_session()) {
			if (!is_numeric($id_post)) $this->output->set_header('Location: /admin/posts');
			$data['page_title']		= $data['content_title'] = 'Edit Posting';
			$data['form_action']	= '/admin/editpost/'.$id_post;
			$data['username_']		= $this->nativesession->get('user_name_');
			$data['f_title']		= htmlentities($this->input->post('txt_post_title'));
			$data['f_content']		= $this->input->post('txt_post_content');
			
			$this->load->model ('model_website');
			$_submitter = $this->input->post('form_submit');
			if ($_submitter == 'POSTING_FORM') {
				if ((!$this->input->post('txt_post_title')) || (!$this->input->post('txt_post_content'))) {
					$data['errors'] = array('Mohon isi judul dan konten posting...');
				} else {
					$_result = $this->model_website->save_post(
						$this->input->post('txt_post_title'),
						$this->input->post('txt_post_content'),
						0, // DEBUG
						$this->nativesession->get('user_id_'),
						$this->nativesession->get('user_name_'),
						true, // published?
						$id_post
					);
					if ($_result) {
						$data['infos']	 = array('Posting berhasil diperbaharui...');
						$data['no_form'] = true;
					}
					else $data['errors'] = array('Terjadi kesalahan. Silakan periksa konten dan ulangi lagi.');
				}
			} else {
				$_dump = $this->model_website->get_post($id_post);
				if (empty($_dump)) {
					$this->output->set_header('Location: /admin/posts');
					return;
				}	
				$data['f_title']	= $_dump[0]->judul;
				$data['f_content']	= $_dump[0]->isi_berita;
			}
			$this->load->template_admin('admin/post_form', $data);
		}
	}
	public function posts() {
		if ($this->_check_session()) {
			$this->load->model ('model_website');
			$data['page_title'] = 'Daftar Posting';
			$data['username_']	= $this->nativesession->get('user_name_');
			$data['_posts']		= $this->model_website->get_newest_posts(10);
			$this->load->template_admin('admin/post_list', $data);
		}
	}
	
	public function events() {
		if ($this->_check_session()) {
			$data['page_title'] = 'Event Organizer';
			$data['username_']	= $this->nativesession->get('user_name_');
			$this->load->template_admin('admin/event_calendar', $data);
		}
	}
	public function eventajax() {
		if ($this->_check_session(true)) {
			$this->load->model ('model_website');
			$_m = $this->input->post('m');
			$_y = $this->input->post('y');
			$_json_ = $this->model_website->get_event_json($_m, $_y);
			$this->output->append_output($_json_);
		}
	}
	public function newevent() {
		if ($this->_check_session()) {
			$data['page_title'] = $data['content_title'] = 'Create New Event';
			$data['username_']	= $this->nativesession->get('user_name_');
			$data['f_d'] = htmlentities($this->input->get('d'));
			$data['f_m'] = htmlentities($this->input->get('m'));
			$data['f_y'] = htmlentities($this->input->get('y'));
			$data['f_ev_name'] = $this->input->post('f_ev_name');
			$data['f_ev_desc'] = $this->input->post('f_ev_desc');
			
			$data['form_action']= '/admin/newevent/'.($this->input->get('m')?"?m=".$this->input->get('m'):"");
			$_submitter = $this->input->post('form_submit');
			if ($_submitter == 'EVENT_POST_FORM') {
				$data['f_date_str'] = $this->input->post('f_ev_date');
				if ((!$this->input->post('f_ev_name')) || (!$this->input->post('f_ev_date'))) {
					$data['errors'] = array('Mohon isi nama dan tanggal event...');
				} else {
					if ($this->input->post('f_ev_desc')) $_f_ev_desc = $this->input->post('f_ev_desc');
					else $_f_ev_desc = null;
					$f_ev_date_ = date_create($this->input->post('f_ev_date'));
					if (!$f_ev_date_) {
						$e = date_get_last_errors();
						foreach ($e['errors'] as $error) {
							$data['errors'][] = "Kesalahan format tanggal: ".$error;
						}
						goto selesai;
					} else $f_ev_date__ = date_format($f_ev_date_, "Y-m-d");
					$f_date_str = $f_ev_date__;
					
					//function save_event($_ev_date, $_name, $_id_creator, $_creator, $_desc = null, $_publish = true, $_id = -1)
					$this->load->model ('model_website');
					$_result = $this->model_website->save_event(
						$f_date_str,
						$this->input->post('f_ev_name'),
						$this->nativesession->get('user_id_'),
						$this->nativesession->get('user_name_'),
						$_f_ev_desc
					);
					if ($_result) {
						$data['infos']	 = array('Event berhasil dipublikasikan...');
						$data['no_form'] = true;
					}
					else $data['errors'] = array('Terjadi kesalahan. Silakan periksa konten dan ulangi lagi.');
				}
			} else {
				$data['f_date_str'] = $data['f_y']."/".$data['f_m']."/".$data['f_d'];
			}
selesai:
			$this->load->template_admin('admin/event_form', $data);
		}
	}
	
	public function links() {
		if ($this->_check_session()) {
			$this->load->model ('model_website');
			$data['page_title'] = 'Daftar Tautan';
			$data['username_']	= $this->nativesession->get('user_name_');
			$data['_links']		= $this->model_website->get_links();
			$this->load->template_admin('admin/link_list', $data);
		}
	}
	
	public function newlink() {
		if ($this->_check_session()) {
			$data['page_title'] = $data['content_title'] = 'Tulis Posting Baru';
			$data['form_action']= '/admin/newlink';
			$data['username_']	= $this->nativesession->get('user_name_');
			$data['f_lnk_name']	= htmlentities($this->input->post('f_lnk_name'));
			$data['f_lnk_url']	= $this->input->post('f_lnk_url');
			
			$_submitter = $this->input->post('form_submit');
			if ($_submitter == 'LINK_POST_FORM') {
				if ((!$this->input->post('f_lnk_name')) || (!$this->input->post('f_lnk_url'))) {
					$data['errors'] = array('Mohon isi nama link dan alamat URL');
				} else {
					if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$data['f_lnk_url'])) {
						$data['errors'][] = "URL tidak valid. Gunakan alamat URL yang valid (Misal: http://www.undip.ac.id)";
						goto selesai;
					}
					$this->load->model ('model_website');
					$_result = $this->model_website->save_link(
						$this->input->post('f_lnk_name'),
						$this->input->post('f_lnk_url'),
						$this->nativesession->get('user_id_'),
						$this->nativesession->get('user_name_')
					);
					if ($_result) {
						$data['infos']	 = array('Link berhasil ditambahkan...');
						$data['no_form'] = true;
					}
					else $data['errors'] = array('Terjadi kesalahan. Silakan periksa konten dan ulangi lagi.');
				}
			}
			selesai:
			$this->load->template_admin('admin/link_form', $data);
		}
	}
	public function editlink($id_link = -1) {
		if (!is_numeric($id_link)) $this->output->set_header('Location: /admin/links');
		else {
			$data['page_title']		= $data['content_title'] = 'Edit Tautan';
			$data['form_action']	= '/admin/editlink/'.$id_link;
			$data['username_']		= $this->nativesession->get('user_name_');
			$data['f_lnk_name']	= htmlentities($this->input->post('f_lnk_name'));
			$data['f_lnk_url']	= $this->input->post('f_lnk_url');
			
			$this->load->model ('model_website');
			$_submitter = $this->input->post('form_submit');
			if ($_submitter == 'LINK_POST_FORM') {
				if ((!$this->input->post('f_lnk_name')) || (!$this->input->post('f_lnk_url'))) {
					$data['errors'] = array('Mohon isi nama link dan alamat URL');
				} else {
					$_result = $this->model_website->save_link(
						$this->input->post('f_lnk_name'),
						$this->input->post('f_lnk_url'),
						$this->nativesession->get('user_id_'),
						$this->nativesession->get('user_name_'),
						$id_link
					);
					if ($_result) {
						$data['infos']	 = array('Tautan berhasil diperbaharui...');
						$data['no_form'] = true;
					}
					else $data['errors'] = array('Terjadi kesalahan. Silakan periksa konten dan ulangi lagi.');
				}
			} else {
				$_dump = $this->model_website->get_link($id_link);
				if (empty($_dump)) {
					$this->output->set_header('Location: /admin/links');
					return;
				}	
				$data['f_lnk_name']	= $_dump[0]->f_name;
				$data['f_lnk_url']	= htmlentities($_dump[0]->f_url);
			}
			$this->load->template_admin('admin/link_form', $data);
		}
	}
	public function media() {
		if ($this->_check_session()) {
			$this->load->model ('model_website');
			$data['page_title'] = 'Daftar Media Terunggah';
			$data['username_']	= $this->nativesession->get('user_name_');
			$data['_medias']	= $this->model_website->get_media();
			$this->load->template_admin('admin/media_list', $data);
		}
	}
	public function newmedia() {
		if ($this->_check_session()) {
			$this->load->model ('model_website');
			$data['page_title'] = 'Unggah file baru';
			$data['username_']	= $this->nativesession->get('user_name_');
			$this->load->template_admin('admin/media_form', $data);
		}
	}
	public function uploadmedia() {
		if ($this->_check_session()) {
			$this->load->model ('model_website');
			$data['page_title'] = 'Daftar Media Terunggah';
			$data['username_']	= $this->nativesession->get('user_name_');
			
			$this->load->template_admin('admin/media_form', $data);
		}
	}
	public function savemenu() {
		if ($this->_check_session(true)) {
			$this->load->model ('model_website');
			$JSONdata = $this->input->post('JSON_menu');
			if (!$JSONdata) {$this->output->append_output("Empty query"); return;}
			$_json_ = $this->model_website->save_menu($JSONdata);
			if ($_json_ == 'OK') $_json_ = 'Menu berhasil disimpan...!';
			$this->output->append_output($_json_);
		}
	}
	public function login() { // action login		
		if (!$this->nativesession->get('user_id_')) {
			$data['page_title'] = 'Administrative Login';
			$redir_url = $this->input->get('next');
			
			$_submitter		= $this->input->post('form_submit');
			$_login_user	= $this->input->post('f_user');
			$_login_pass	= md5($this->input->post('f_password'));
			
			if (isset($_submitter) && ($_submitter == "LOGIN_FORM")) {
				if (!empty($_login_user)) {
					$this->load->model ('model_website');
					$_user_row = $this->model_website->user_authenticate($_login_user, $_login_pass);
					if ($_user_row != null) {
						$this->nativesession->set('user_id_'  , $_user_row[0]->f_id);
						$this->nativesession->set('user_name_', htmlentities($_user_row[0]->f_username));
						$this->nativesession->set('user_role_', $_user_row[0]->f_role_id);
						
						if (!$redir_url) $redir_url = "/admin/";
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
			$this->output->set_header('Location: /admin/dashboard');
		}
	}
	public function pages() {
		if ($this->_check_session()) {
			$this->load->model ('model_website');
			$data['page_title'] = 'Daftar Halaman';
			$data['username_']	= $this->nativesession->get('user_name_');
			$data['_pages']		= $this->model_website->get_pages();
			$this->load->template_admin('admin/page_list', $data);
		}
	}
	public function editpage($id_page = -1) {
		if ($this->_check_session()) {
			if (!is_numeric($id_page)) $this->output->set_header('Location: /admin/pages');
			$data['page_title']		= $data['content_title'] = 'Edit Halaman';
			$data['form_action']	= '/admin/editpage/'.$id_page;
			$data['username_']		= $this->nativesession->get('user_name_');
			$data['f_title']		= htmlentities($this->input->post('f_title'));
			$data['f_content']		= $this->input->post('f_content');
			$data['f_permalink']	= $this->input->post('f_permalink');
			
			$this->load->model ('model_website');
			$_submitter = $this->input->post('form_submit');
			if ($_submitter == 'PAGE_POST_FORM') {
				if ((!$this->input->post('f_title')) || (!$this->input->post('f_content')) || (!$this->input->post('f_permalink'))) {
					$data['errors'] = array('Mohon isi judul, permalink dan konten halaman...');
				} else {
					$_result = $this->model_website->save_page(
						$this->input->post('f_title'),
						$this->input->post('f_permalink'),
						$this->input->post('f_content'),
						$this->nativesession->get('user_id_'),
						$this->nativesession->get('user_name_'),
						true, // published?
						$id_page
					);
					if ($_result) {
						$data['infos']	 = array('Halaman berhasil diperbaharui...');
						$data['no_form'] = true;
					}
					else $data['errors'] = array('Terjadi kesalahan. Silakan periksa konten dan ulangi lagi.');
				}
			} else {
				$_dump = $this->model_website->get_page($id_page);
				if (empty($_dump)) {
					$this->output->set_header('Location: /admin/pages');
					return;
				}	
				$data['f_title']	= $_dump[0]->f_title;
				$data['f_content']	= $_dump[0]->f_content;
				$data['f_permalink']= $_dump[0]->f_permalink;
			}
			$this->load->template_admin('admin/page_form', $data);
		}
	}
	
	public function newpage() {
		if ($this->_check_session()) {
			$data['page_title'] = $data['content_title'] = 'Tulis Halaman Baru';
			$data['form_action']= '/admin/newpage';
			$data['username_']	= $this->nativesession->get('user_name_');
			$data['f_title']	= htmlentities($this->input->post('f_title'));
			$data['f_content']	= $this->input->post('f_content');
			$data['f_permalink']= $this->input->post('f_permalink');
			
			$_submitter = $this->input->post('form_submit');
			if ($_submitter == 'PAGE_POST_FORM') {
				if ((!$this->input->post('f_title')) || (!$this->input->post('f_content')) || (!$this->input->post('f_permalink'))) {
					$data['errors'] = array('Mohon isi judul, permalink dan konten halaman...');
				} else {
					$this->load->model ('model_website');
					$_result = $this->model_website->save_page(
						$this->input->post('f_title'),
						$this->input->post('f_permalink'),
						$this->input->post('f_content'),
						$this->nativesession->get('user_id_'),
						$this->nativesession->get('user_name_')
					);
					if ($_result) {
						$data['infos']	 = array('Halaman berhasil dipublikasikan...');
						$data['no_form'] = true;
					}
					else $data['errors'] = array('Terjadi kesalahan. Silakan periksa konten dan ulangi lagi.');
				}
			}
			$this->load->template_admin('admin/page_form', $data);
		}
	}
	
	public function menu() {
		if ($this->_check_session()) {
			$this->load->model ('model_website');
			$data['page_title'] = 'Daftar Halaman';
			$data['username_']	= $this->nativesession->get('user_name_');
			$this->load->template_admin('admin/menueditor', $data);
		}
	}
	public function logout() {
		if ($this->nativesession->get('user_id_')) {
			$this->nativesession->delete('user_id_');
			$this->nativesession->delete('user_name_');
			$this->nativesession->delete('user_role_');
		}
		$this->output->set_header('Location: /admin');
	}
}
