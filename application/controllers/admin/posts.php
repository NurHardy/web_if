<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Posts extends CI_Controller {
	private $_cpmask = 2;
	
	public function newpost($draft_id = -1) {
		if ($this->load->check_session($this->_cpmask)) {
			$_is_error = false;
			$data['page_title'] = $data['content_title'] = 'Tulis Posting Baru';
			$data['form_action']= base_url('/admin/posts/newpost');
			$data['username_']	= $this->nativesession->get('user_name_');
			$data['userprev'] = $this->nativesession->get('user_role_');
			$data['ucatprev'] = $this->nativesession->get('user_catflags_');
			$data['udefcat'] = $this->nativesession->get('user_defcat_');
			
			$this->load->model ('web_posting');
			$this->load->model ('web_draft');
			
			$data['f_draft_id']	= $this->input->post('txt_draft_id');
			$data['f_title']	= htmlentities($this->input->post('txt_post_title'));
			$data['f_content']	= $this->input->post('txt_post_content');
			$data['f_cat']		= $this->input->post('txt_post_cat');
			
			// validation
			$_is_error |= ((!$this->input->post('txt_post_title')) || (!$this->input->post('txt_post_content')));
			$_is_error |= ($this->input->post('txt_post_cat') <= 0);
			
			$_submitter = $this->input->post('form_submit');
			if ($data['userprev'] >= 0xFFFFF) $data['_cats'] = $this->web_posting->get_categories();
			else {
				$this->load->helper('bitmask');
				$_maskarray = bitmask_to_array($data['ucatprev']);
				$data['_cats'] = $this->web_posting->get_categories($_maskarray);
			}
			if ($_submitter == 'POSTING_FORM') {
				if ($_is_error) {
					$data['errors'] = array('Mohon isi judul, kategori dan konten posting...');
				} else {
					$_result = $this->web_posting->save_post(
						$data['f_title'],
						$data['f_content'],
						$data['f_cat'],
						$this->nativesession->get('user_id_'),
						$this->nativesession->get('user_name_'),
						true,
						$data['f_draft_id']
					);
					if ($_result) {
						$data['infos']	 = array('Posting berhasil dipublikasikan...');
						$data['no_form'] = true;
					}
					else $data['errors'] = array('Terjadi kesalahan. Silakan periksa konten dan ulangi lagi.');
				}
			} else if ($draft_id > 0) {
				$_draft_dump = $this->web_draft->get_draft($draft_id);
				if ($_draft_dump == null) {
					$this->output->set_header('Location: '.base_url("/admin/newpost/"));
					return;
				}
				$data['f_draft_id']	= $draft_id;
				$data['f_title']	= $_draft_dump->f_title;
				$data['f_content']	= $_draft_dump->f_content;
				$data['f_cat']		= $_draft_dump->f_category;
				$data['f_last_saved'] = $_draft_dump->f_date_last;
				if (empty($_draft_dump->f_date_last)) $data['f_last_saved'] = $_draft_dump->f_date_saved;
			} else {
				$data['f_draft_id']	= -1;
			}
			$this->load->template_admin('admin/post_form', $data, false, "&raquo; <a href='".base_url("/admin/posts")."'>posting</a> &raquo; posting baru");
		}
	}
	
	public function editpost($id_post = -1) {
		if ($this->load->check_session($this->_cpmask)) {
			if (!is_numeric($id_post)) $this->output->set_header('Location: '.base_url('/admin/posts'));
			$_is_error = false;
			$data['page_title']		= $data['content_title'] = 'Edit Posting';
			$data['form_action']	= base_url('/admin/posts/editpost/'.$id_post);
			$data['username_']		= $this->nativesession->get('user_name_');
			$data['userprev']		= $this->nativesession->get('user_role_');
			$data['ucatprev']		= $this->nativesession->get('user_catflags_');
			$data['udefcat']		= $this->nativesession->get('user_defcat_');
			
			$data['f_draft_id']		= $this->input->post('txt_draft_id');
			$data['f_title']		= htmlentities($this->input->post('txt_post_title'));
			$data['f_content']		= $this->input->post('txt_post_content');
			$data['f_cat']			= $this->input->post('txt_post_cat');
			// validation
			$_is_error |= ((!$this->input->post('txt_post_title')) || (!$this->input->post('txt_post_content')));
			$_is_error |= ($this->input->post('txt_post_cat') <= 0);
			
			$this->load->model ('web_posting');
			$this->load->model ('web_draft');
			$data['_cats']			= $this->web_posting->get_categories(-1);
			$_submitter = $this->input->post('form_submit');
			if ($_submitter == 'POSTING_FORM') {
				if ($_is_error) {
					$data['errors'] = array('Mohon isi judul, kategori dan konten posting...');
				} else {
					$_result = $this->web_posting->save_post(
						$data['f_title'],
						$data['f_content'],
						$data['f_cat'],
						$this->nativesession->get('user_id_'),
						$this->nativesession->get('user_name_'),
						true, // published?
						$data['f_draft_id'],
						$id_post
					);
					if ($_result) {
						$data['infos']	 = array('Posting berhasil diperbaharui...');
						$data['no_form'] = true;
					}
					else $data['errors'] = array('Terjadi kesalahan. Silakan periksa konten dan ulangi lagi.');
				}
			} else {
				$_dump = $this->web_posting->get_post($id_post);
				if (empty($_dump)) {
					$this->output->set_header('Location: '.base_url('/admin/posts'));
					return;
				}
				$data['f_post_id']	= $_dump->id_berita;
				$data['f_title']	= $_dump->judul;
				$data['f_content']	= $_dump->isi_berita;
				$data['f_cat']		= $_dump->id_kategori;
				if ($_dump->f_id_draft != 0) { // ada draf...
					$_draft_dump = $this->web_draft->get_draft($_dump->f_id_draft);
					if ($_draft_dump != null) {
						$data['f_title']	= $_draft_dump->f_title;
						$data['f_content']	= $_draft_dump->f_content;
						$data['f_cat']		= $_draft_dump->f_category;
						$data['f_last_saved'] = $_draft_dump->f_date_last;
						if (empty($_draft_dump->f_date_last)) $data['f_last_saved'] = $_draft_dump->f_date_saved;
					}
					$data['f_draft_id']	= $_dump->f_id_draft;
				} else $data['f_draft_id']	= -1; // no draft
			}
			$this->load->template_admin('admin/post_form', $data, false, "&raquo; <a href='".base_url('/admin/posts')."'>posting</a> &raquo; edit posting");
		}
	}
	public function index() {
		if ($this->load->check_session($this->_cpmask)) {
			$this->load->model ('web_posting');
			$this->load->model ('web_draft');
			$this->load->model ('web_functions');
			
			$data['page_title'] = 'Daftar Posting';
			$data['username_']	= $this->nativesession->get('user_name_');
			$data['userprev']		= $this->nativesession->get('user_role_');
			$data['ucatprev']		= $this->nativesession->get('user_catflags_');
			$data['udefcat']		= $this->nativesession->get('user_defcat_');
			
			$_ipp = $this->input->get('n'); // item per page
			$_cur = $this->input->get('p'); // current page (zero-based)
			$_maxpage = $this->input->get('x');
			$_filter = intval($this->input->get('cat'));

			$this->web_functions->check_pagination($_ipp, $_cur, $_maxpage);
			if ($_maxpage === false) {
				$_n = $this->web_posting->count_posts($_filter);
				$_maxpage = ($_n==0?0:ceil($_n/$_ipp)-1);
			}
			
			$data['_drafts']	= $this->web_draft->get_drafts();
			$data['_posts']		= $this->web_posting->get_posts($_ipp, $_cur+1, $_filter);
			$data['_cats']		= $this->web_posting->get_categories(-1);
			$data['_paging']	= $this->web_functions->pagination(
				$_maxpage,
				$_cur,
				2,
				base_url('/admin/posts'),
				'cat='.$_filter.'&amp;n='.$_ipp
			);
			$data['_ctr'] = $_cur*$_ipp;
			$data['_filter'] = $_filter;
			$data['_ipp'] = $_ipp;
			
			$data['urlAjaxRequest']	= base_url("/admin/posts/ajax_getposts");
			$this->load->template_admin('admin/post_list', $data, false, "&raquo; posting");
		}
	}
	public function postsavedraft() {
		$_datenow = date('d-m-Y H:i:s');
		$_return_data = array(
			'status'	=> 'Error',
			'message'	=> 'No session. Please login...',
			'datestr'	=> $_datenow,
			'newid'		=> -1
		);
		if ($this->load->check_session($this->_cpmask, true, json_encode($_return_data), json_encode($_return_data))) {
			
			//$_is_error = false
			$data['f_title']	= htmlentities($this->input->post('txt_post_title'));
			$data['f_content']	= $this->input->post('txt_post_content');
			$data['f_cat']		= $this->input->post('txt_post_cat');
			$data['f_draft_id']	= $this->input->post('txt_draft_id');
			
			$draft_id = $this->input->post('txt_draft_id');
			$_submitter = $this->input->post('form_submit');
			
			if ($_submitter == 'POSTING_FORM') {
				$this->load->model ('web_posting');
				
				$_result = $this->web_posting->save_post_draft(
					$data['f_title'],
					$data['f_content'],
					$data['f_cat'],
					$this->nativesession->get('user_id_'),
					$this->nativesession->get('user_name_'),
					$this->input->post('txt_post_id'),
					$draft_id
				);
				if ($_result) {
					$_return_data['status'] = 'OK';
					$_return_data['message'] = 'Draft saved';
					$_return_data['newid'] = $_result;
				}
				else $_return_data['message'] = 'Error while saving data. Please check content and try again...';
				$this->output->append_output(json_encode($_return_data));
			}
		}
	}
	public function categories($page = 1) {
		if ($this->load->check_session($this->_cpmask)) {
			$this->load->model ('web_posting');
			$data['page_title'] = 'Daftar Kategori';
			$data['username_']	= $this->nativesession->get('user_name_');
			$data['_cats']	= $this->web_posting->get_categories();
			$this->load->template_admin('admin/category_list', $data, false, "&raquo; <a href='".base_url("/admin/posts")."'>posting</a> &raquo; kategori");
		}
	}
	
	public function preview() {
		$this->load->model('web_posting');
		$this->load->model('web_link');
		
		$data['other_posts'] = array();
		$data['daftar_tautan'] = $this->web_link->get_links();
		
		$data['_posting'] = new stdclass;
		$data['_posting']->judul = "[Preview]: ".htmlentities($this->input->post('txt_post_title'));
		$data['_posting']->isi_berita = $this->input->post('txt_post_content');
		$data['_posting']->creator = $this->nativesession->get('user_name_');
		$data['_posting']->tanggal = date('Y-m-d H:i:s');
		
		$data['page_title'] = $data['_posting']->judul;
		$this->load->template_posting('posting', $data, false, true);
	}
	public function ajax_getposts($idCategory = -1) {
		if (!$this->load->check_session($this->_cpmask, true)) return;
		
		$data['userprev']		= $this->nativesession->get('user_role_');
		$data['ucatprev']		= $this->nativesession->get('user_catflags_');
		$data['udefcat']		= $this->nativesession->get('user_defcat_');
			
		$this->load->model('web_posting');
		
		$data['_cats'] = $this->web_posting->get_array_categories();
		if ($idCategory > 0) {
			$idCategory_ = intval($idCategory);
			$data['_posts']		= $this->web_posting->get_posts(0, 0, $idCategory_, -1);
		} else {
			if ($data['userprev'] >= 0xFFFFF) $data['_posts'] = $this->web_posting->get_posts(0, 0, -1, -1);
			else {
				$this->load->helper('bitmask');
				$_maskarray = bitmask_to_array($data['ucatprev']);
				$data['_posts']		= $this->web_posting->get_posts(0, 0, $_maskarray, -1);
			}
		}
		$data['editURLPrefix']	= base_url("/admin/posts/editpost/");
		$this->load->view('admin/ajax/posts_json', $data);
	}
	// AJAX
	public function post_ajax_act() {
		if (!$this->load->check_session($this->_cpmask, true)) return;
		$_action = $this->input->post('_act');
		if ($_action === false) {$this->output->append_output("Action parameter expected."); return;}
		
		$this->load->model('web_posting');
		$_actresult = false;
		if ($_action === 'del') {
			$p_id = intval($this->input->post('_postid'));
			if ($p_id > 0) $_actresult = $this->web_posting->delete_post($p_id);
		} else if ($_action === 'pub') {
			$p_id= intval($this->input->post('_postid'));
			if ($p_id > 0) $_actresult = $this->web_posting->set_post_status($p_id, 1);
		} else if ($_action === 'unpub') {
			$p_id= intval($this->input->post('_postid'));
			if ($p_id > 0) $_actresult = $this->web_posting->set_post_status($p_id, 0);
		} else if ($_action === 'canceldraft') {
			$this->load->model('web_draft');
			$d_id= intval($this->input->post('_draftid'));
			if ($d_id > 0) $_actresult = $this->web_draft->cancel_draft($d_id);
		} else {
			$this->output->append_output("Unknown action");
			return;
		}
		
		if ($_actresult) {
			$this->output->append_output("OK");
		} else {
			$this->output->append_output("Cannot execute specified action.");
		}
	}
}